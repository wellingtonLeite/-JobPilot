<?php

namespace App\Modules\Integrations\Adapters;

use App\Modules\Integrations\Contracts\JobAvailability;
use App\Modules\Integrations\Contracts\JobSearchParams;
use App\Modules\Integrations\Contracts\JobSourceAdapter;
use App\Modules\Jobs\DTOs\JobDto;

class InfoJobsAdapter implements JobSourceAdapter
{
    public function searchJobs(JobSearchParams $params): array
    {
        $keyword = urlencode(implode('+', $params->keywords ?? ['desenvolvedor']));
        $url = "https://www.infojobs.com.br/vagas-de-emprego.aspx?Palabra={$keyword}";

        $jobs = [];

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(10)
                ->withoutVerifying()
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                    'Accept-Language' => 'pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
                ])->get($url);

            if ($response->successful()) {
                $dom = new \DOMDocument();
                @$dom->loadHTML($response->body());
                $xpath = new \DOMXPath($dom);

                // Infojobs list items
                $jobNodes = $xpath->query("//div[contains(@class, 'card')] | //div[contains(@class, 'vaga')] | //a[contains(@class, 'text-decoration-none')]");
                
                foreach ($jobNodes as $node) {
                    try {
                        $titleNode = $xpath->query(".//h2 | .//div[contains(@class, 'h3')]", $node);
                        $companyNode = $xpath->query(".//div[contains(@class, 'company')] | .//div[contains(@class, 'text-body')]", $node);
                        
                        if ($titleNode->length === 0) continue;

                        $title = trim($titleNode->item(0)->textContent);
                        $company = $companyNode->length > 0 ? trim($companyNode->item(0)->textContent) : 'Confidencial';
                        $link = null;

                        if ($node->nodeName === 'a' && $node->hasAttribute('href')) {
                            $link = $node->getAttribute('href');
                        } else {
                            $linkNodes = $xpath->query(".//a", $node);
                            if ($linkNodes->length > 0) {
                                $link = $linkNodes->item(0)->getAttribute('href');
                            }
                        }

                        if ($link && !str_starts_with($link, 'http')) {
                            $link = 'https://www.infojobs.com.br' . $link;
                        }

                        $externalId = uniqid('ij_');
                        if ($link && preg_match('/vaga-de-emprego-(.+)\.aspx/i', $link, $matches)) {
                            $externalId = $matches[1];
                        }

                        $jobs[] = new JobDto(
                            id: uniqid('ij_'),
                            source: 'infojobs',
                            externalId: $externalId,
                            title: $title,
                            company: $company,
                            description: "Veja os detalhes completos no InfoJobs.",
                            requirements: [],
                            location: ['country' => 'Brasil'],
                            workMode: 'unknown',
                            applicationStatus: 'open',
                            discoveredAt: new \DateTimeImmutable(),
                            sourceUrl: $link
                        );

                        if (count($jobs) >= 10) break; // Limit to 10 to speed up
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::warning('Erro ao fazer parse de uma vaga InfoJobs: ' . $e->getMessage());
                    }
                }
            } else {
                \Illuminate\Support\Facades\Log::warning("InfoJobs bloqueou a requisição (Status {$response->status()}).");
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erro ao buscar vagas no InfoJobs: ' . $e->getMessage());
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
