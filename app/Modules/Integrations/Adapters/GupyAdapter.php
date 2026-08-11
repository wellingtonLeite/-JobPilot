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
        // Endpoint genérico do portal da Gupy
        $url = "https://portal.gupy.io/api/v1/jobs?jobName={$keyword}&limit=10";

        $jobs = [];

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(10)
                ->withoutVerifying()
                ->get($url);

            if ($response->successful()) {
                $data = $response->json();
                $results = $data['data'] ?? [];

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
