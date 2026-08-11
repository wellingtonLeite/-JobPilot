<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class JobPilotSearchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobpilot:search';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executa o orquestrador de busca e IA para encontrar vagas.';

    /**
     * Execute the console command.
     */
    public function handle(\App\Modules\Jobs\Services\JobSearchService $searchService)
    {
        $this->info('Iniciando pesquisa paralela JobPilot...');

        $profile = \App\Models\UserProfile::first();
        if (!$profile) {
            $this->error('Nenhum perfil configurado no banco de dados. Cadastre-se primeiro.');
            return;
        }

        $this->info('Perfil encontrado: ID ' . $profile->user_id . ' (Score mínimo: ' . $profile->min_match_score . '%)');
        $this->info('Consultando LinkedIn, InfoJobs e Gupy...');
        
        $results = $searchService->execute($profile, ['desenvolvedor', 'php', 'laravel']);
        
        $this->info('Processo concluído! ' . count($results) . ' vagas deram match e foram salvas no banco de dados.');
    }
}
