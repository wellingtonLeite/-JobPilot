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
        $keyword = implode('+', $params->keywords ?? ['desenvolvedor']);
        $url = "https://www.infojobs.com.br/vagas-de-emprego.aspx?Palabra={$keyword}";

        $jobs = [];

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(10)->get($url);

            if ($response->successful()) {
                $crawler = new \Symfony\Component\DomCrawler\Crawler($response->body());

                // Seletor básico do InfoJobs (pode variar, iterando sobre as vagas)
                $crawler->filter('.js_rowVaga')->each(function (\Symfony\Component\DomCrawler\Crawler $node) use (&$jobs) {
                    try {
                        $titleNode = $node->filter('.js_vagaLink')->first();
                        $title = $titleNode->count() > 0 ? $titleNode->text() : 'Vaga InfoJobs';
                        
                        $companyNode = $node->filter('.js_vagaCompany')->first();
                        $company = $companyNode->count() > 0 ? $companyNode->text() : 'Empresa Confidencial';

                        $link = $titleNode->count() > 0 ? $titleNode->attr('href') : null;
                        
                        $jobs[] = new JobDto(
                            id: uniqid('ij_'),
                            source: 'infojobs',
                            externalId: uniqid(),
                            title: trim($title),
                            company: trim($company),
                            description: 'Descrição completa acessível no link.',
                            requirements: [],
                            location: ['city' => 'Brasil'],
                            workMode: 'unknown',
                            applicationStatus: 'open',
                            discoveredAt: new \DateTimeImmutable(),
                            sourceUrl: $link
                        );
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::warning('Erro ao fazer parse de uma vaga InfoJobs: ' . $e->getMessage());
                    }
                });
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erro ao buscar vagas no InfoJobs: ' . $e->getMessage());
        }

        return $jobs;
    }

    public function getJob(string $jobId): ?JobDto
    {
        return null; // Implementação futura para capturar a página detalhada da vaga
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
