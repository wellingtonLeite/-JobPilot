<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Modules\Matching\Contracts\AIProvider::class,
            function ($app) {
                return new \App\Modules\Matching\Providers\FallbackAIProvider([
                    $app->make(\App\Modules\Matching\Providers\GeminiAIProvider::class),
                    $app->make(\App\Modules\Matching\Providers\OpenRouterAIProvider::class),
                    $app->make(\App\Modules\Matching\Providers\OllamaAIProvider::class),
                ]);
            }
        );

        $this->app->when(\App\Modules\Jobs\Services\JobSearchService::class)
            ->needs(\App\Modules\Integrations\Contracts\JobSourceAdapter::class)
            ->give(function ($app) {
                return [
                    $app->make(\App\Modules\Integrations\Adapters\LinkedInAdapter::class),
                    $app->make(\App\Modules\Integrations\Adapters\InfoJobsAdapter::class),
                    $app->make(\App\Modules\Integrations\Adapters\GupyAdapter::class),
                ];
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
