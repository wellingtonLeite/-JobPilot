<?php

namespace App\Modules\Matching\Providers;

use App\Modules\Matching\Contracts\AIProvider;

class MockAIProvider implements AIProvider
{
    public function calculateMatchScore(string $jobDescription, string $userProfileText): array
    {
        return [
            'score' => rand(60, 99),
            'hard_skills' => ['PHP', 'Laravel', 'SQL'],
            'soft_skills' => ['Liderança', 'Proatividade'],
            'cover_letter' => 'Prezado recrutador, sou um excelente candidato para esta vaga com experiência na stack requisitada.'
        ];
    }
}
