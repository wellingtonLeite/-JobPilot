<?php

namespace App\Modules\Matching\Providers;

use App\Modules\Matching\Contracts\AIProvider;
use Illuminate\Support\Facades\Log;

class FallbackAIProvider implements AIProvider
{
    private array $providers;

    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    public function calculateMatchScore(string $jobDescription, string $userProfileText): array
    {
        $lastException = null;

        foreach ($this->providers as $provider) {
            try {
                return $provider->calculateMatchScore($jobDescription, $userProfileText);
            } catch (\Exception $e) {
                Log::warning("AI Provider [" . get_class($provider) . "] failed: " . $e->getMessage());
                $lastException = $e;
            }
        }

        throw new \Exception("All AI Providers failed. Last error: " . $lastException?->getMessage());
    }
}
