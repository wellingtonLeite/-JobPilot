<?php

namespace App\Modules\Jobs\Services;

use App\Models\UserProfile;
use App\Modules\Integrations\Contracts\JobSearchParams;
use App\Modules\Integrations\Contracts\JobSourceAdapter;
use App\Modules\Matching\Services\JobScoringService;

class JobSearchService
{
    /** @var JobSourceAdapter[] */
    private array $adapters;

    public function __construct(
        private JobDeduplicationService $deduplicator,
        private JobScoringService $scorer,
        JobSourceAdapter ...$adapters
    ) {
        $this->adapters = $adapters;
    }

    public function execute(UserProfile $userProfile, array $keywords = []): array
    {
        $params = new JobSearchParams(
            keywords: $keywords,
            homeOfficeOnly: $userProfile->home_office_only,
            hasEnglishProficiency: $userProfile->has_english_proficiency,
            recencyDays: 7
        );

        $allJobs = [];
        // 1. SEARCH: Pesquisa paralela simulada por iteração (no PHP nativo seria loop, ou workers assíncronos)
        foreach ($this->adapters as $adapter) {
            $jobsFromAdapter = $adapter->searchJobs($params);
            $allJobs = array_merge($allJobs, $jobsFromAdapter);
        }

        // 2. DEDUPLICATE: Remove duplicatas
        $uniqueJobs = $this->deduplicator->deduplicate($allJobs);

        // 3. FILTERING & SCORING
        $results = [];
        foreach ($uniqueJobs as $job) {
            // Checkers
            if ($userProfile->home_office_only && $job->workMode !== 'remote') {
                continue;
            }

            // SCORE
            $userResume = $userProfile->resume_text ?? "Desenvolvedor Profissional";
            $aiData = $this->scorer->scoreJob($job, $userResume);
            $score = $aiData['score'] ?? 0;

            if ($score >= $userProfile->min_match_score) {
                // PERSISTÊNCIA NO BANCO
                $jobSource = \App\Models\JobSource::firstOrCreate(
                    ['slug' => $job->source],
                    ['name' => ucfirst($job->source), 'enabled' => true]
                );

                $jobPosting = \App\Models\JobPosting::updateOrCreate(
                    ['external_id' => $job->externalId, 'job_source_id' => $jobSource->id],
                    [
                        'title' => $job->title,
                        'company' => $job->company,
                        'description' => substr($job->description, 0, 2000),
                        'requirements' => $job->requirements,
                        'city' => $job->location['city'] ?? null,
                        'state' => $job->location['state'] ?? null,
                        'country' => $job->location['country'] ?? null,
                        'work_mode' => $job->workMode,
                        'source_url' => $job->sourceUrl,
                    ]
                );

                \App\Models\JobMatch::updateOrCreate(
                    ['user_id' => $userProfile->user_id, 'job_posting_id' => $jobPosting->id],
                    [
                        'score' => $score, 
                        'status' => 'pending',
                        'match_details' => [
                            'hard_skills' => $aiData['hard_skills'] ?? [],
                            'soft_skills' => $aiData['soft_skills'] ?? []
                        ]
                    ]
                );

                // SE SCORE EXCEPCIONAL -> GERA CANDIDATURA AUTOMÁTICA (Draft)
                if ($score >= 90 && isset($aiData['cover_letter'])) {
                    \App\Models\Application::firstOrCreate(
                        ['user_id' => $userProfile->user_id, 'job_posting_id' => $jobPosting->id],
                        ['status' => 'cv_generated', 'cover_letter' => $aiData['cover_letter']]
                    );
                }

                $results[] = [
                    'job' => $job,
                    'score' => $score
                ];
            }
        }

        // 4. SORT (Melhor score primeiro)
        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);

        return $results;
    }
}
