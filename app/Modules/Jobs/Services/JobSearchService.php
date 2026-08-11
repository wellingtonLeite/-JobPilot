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
            $score = $this->scorer->scoreJob($job, "Perfil do usuario simulado");

            if ($score >= $userProfile->min_match_score) {
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
