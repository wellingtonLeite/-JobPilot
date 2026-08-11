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
            \App\Modules\Matching\Providers\GeminiAIProvider::class
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
