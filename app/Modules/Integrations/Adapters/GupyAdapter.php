<?php

namespace App\Modules\Integrations\Adapters;

use App\Modules\Integrations\Contracts\JobAvailability;
use App\Modules\Integrations\Contracts\JobSearchParams;
use App\Modules\Integrations\Contracts\JobSourceAdapter;
use App\Modules\Jobs\DTOs\JobDto;

class GupyAdapter implements JobSourceAdapter
{
    public function searchJobs(JobSearchParams $params): array
    {
        $keyword = urlencode(implode(' ', $params->keywords ?? ['desenvolvedor']));
        $url = "https://portal.gupy.io/api/v1/jobs?jobName={$keyword}&limit=10";

        $jobs = [];

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(10)
                ->withoutVerifying()
                ->get($url);

            if ($response->successful()) {
                $html = $response->body();
                
                // O Gupy injeta os dados via NEXT.js
                if (preg_match('/<script id="__NEXT_DATA__".*?>(.*?)<\/script>/is', $html, $matches)) {
                    $jsonData = json_decode($matches[1], true);
                    $results = $jsonData['props']['pageProps']['initialState']['searchJob']['results'] ?? [];
                    
                    // Se a rota mudou e não tiver 'results' ali, busca em outro lugar
                    if (empty($results) && isset($jsonData['props']['pageProps']['jobs'])) {
                        $results = $jsonData['props']['pageProps']['jobs'];
                    }
                    
                    // Outro local comum
                    if (empty($results)) {
                        $results = $jsonData['props']['pageProps']['initialState']['jobs']['data'] ?? [];
                    }

                    // Nova API Gupy? As vezes vem direto de outra query... vamos fazer uma busca recursiva pelos jobs:
                    if (empty($results)) {
                        preg_match_all('/"name":"(.*?)","careerPageName":"(.*?)","jobUrl":"(.*?)"/i', $html, $regexMatches, PREG_SET_ORDER);
                        foreach ($regexMatches as $item) {
                            $jobs[] = new JobDto(
                                id: uniqid('gp_'),
                                source: 'gupy',
                                externalId: md5($item[3]),
                                title: $item[1],
                                company: $item[2],
                                description: 'Acesse o portal da Gupy para mais detalhes.',
                                requirements: [],
                                location: ['country' => 'Brasil'],
                                workMode: 'unknown',
                                applicationStatus: 'open',
                                discoveredAt: new \DateTimeImmutable(),
                                sourceUrl: $item[3]
                            );
                        }
                    }

                    foreach ($results as $item) {
                        $jobs[] = new JobDto(
                            id: uniqid('gp_'),
                            source: 'gupy',
                            externalId: (string) ($item['id'] ?? uniqid()),
                            title: $item['name'] ?? 'Vaga Gupy',
                            company: $item['careerPageName'] ?? 'Empresa Confidencial',
                            description: $item['description'] ?? 'Descrição no link.',
                            requirements: [],
                            location: [
                                'city' => $item['city'] ?? null,
                                'state' => $item['state'] ?? null,
                                'country' => $item['country'] ?? 'Brasil',
                            ],
                            workMode: $this->parseWorkMode($item['workplaceType'] ?? ''),
                            applicationStatus: 'open',
                            discoveredAt: new \DateTimeImmutable(),
                            publishedAt: isset($item['publishedDate']) ? new \DateTimeImmutable($item['publishedDate']) : null,
                            sourceUrl: $item['jobUrl'] ?? null
                        );
                    }
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erro ao buscar vagas na Gupy: ' . $e->getMessage());
        }

        return $jobs;
    }

    private function parseWorkMode(string $type): string
    {
        $type = strtolower($type);
        if (str_contains($type, 'remote') || str_contains($type, 'teletrabalho')) return 'remote';
        if (str_contains($type, 'hybrid') || str_contains($type, 'hibrido')) return 'hybrid';
        if (str_contains($type, 'onsite') || str_contains($type, 'presencial')) return 'onsite';
        return 'unknown';
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
