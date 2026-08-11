<?php

namespace App\Modules\Integrations\Adapters;

use App\Modules\Integrations\Contracts\JobAvailability;
use App\Modules\Integrations\Contracts\JobSearchParams;
use App\Modules\Integrations\Contracts\JobSourceAdapter;
use App\Modules\Jobs\DTOs\JobDto;

class LinkedInAdapter implements JobSourceAdapter
{
    public function searchJobs(JobSearchParams $params): array
    {
        $keyword = implode('%20', $params->keywords ?? ['desenvolvedor']);
        $url = "https://br.linkedin.com/jobs/search?keywords={$keyword}&location=Brasil";

        $jobs = [];

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(10)
                ->withoutVerifying()
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36',
                    'Accept-Language' => 'pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
                ])->get($url);

            if ($response->successful()) {
                $dom = new \DOMDocument();
                @$dom->loadHTML($response->body());
                $xpath = new \DOMXPath($dom);

                $jobNodes = $xpath->query("//ul[contains(@class, 'jobs-search__results-list')]/li");

                foreach ($jobNodes as $node) {
                    try {
                        $titleNode = $xpath->query(".//*[contains(@class, 'base-search-card__title')]", $node);
                        $title = $titleNode->length > 0 ? trim($titleNode->item(0)->textContent) : 'Vaga LinkedIn';
                        
                        $companyNode = $xpath->query(".//*[contains(@class, 'base-search-card__subtitle')]", $node);
                        $company = $companyNode->length > 0 ? trim($companyNode->item(0)->textContent) : 'Empresa Confidencial';

                        $linkNode = $xpath->query(".//a[contains(@class, 'base-card__full-link')]", $node);
                        $link = $linkNode->length > 0 ? trim($linkNode->item(0)->getAttribute('href')) : null;
                        
                        preg_match('/view\/(\d+)/', $link ?? '', $matches);
                        $externalId = $matches[1] ?? uniqid();

                        $jobs[] = new JobDto(
                            id: uniqid('li_'),
                            source: 'linkedin',
                            externalId: $externalId,
                            title: $title,
                            company: $company,
                            description: 'Acesse o link para ver a descrição completa (protegido por login).',
                            requirements: [],
                            location: ['country' => 'Brasil'],
                            workMode: 'unknown',
                            applicationStatus: 'open',
                            discoveredAt: new \DateTimeImmutable(),
                            sourceUrl: $link
                        );

                        if (count($jobs) >= 10) break;
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::warning('Erro ao fazer parse de uma vaga LinkedIn: ' . $e->getMessage());
                    }
                }
            } else {
                \Illuminate\Support\Facades\Log::warning("LinkedIn bloqueou a requisição (Status {$response->status()}).");
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erro ao buscar vagas no LinkedIn: ' . $e->getMessage());
        }

        return $jobs;
    }

    public function getJob(string $jobId): ?JobDto
    {
        return null;
    }

    public function checkAvailability(JobDto $job): JobAvailability
    {
        return JobAvailability::OPEN;
    }

    public function getApplicationUrl(JobDto $job): ?string
    {
        return $job->sourceUrl;
    }

    public function normalizeJob(array|object $job): JobDto
    {
        throw new \Exception("Not implemented");
    }
}
