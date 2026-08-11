<?php

namespace App\Modules\Matching\Providers;

use App\Modules\Matching\Contracts\AIProvider;

class MockAIProvider implements AIProvider
{
    public function calculateMatchScore(string $jobDescription, string $userProfileText): int
    {
        // Mock score entre 60 e 99 para fins de demonstração
        return rand(60, 99);
    }
}
