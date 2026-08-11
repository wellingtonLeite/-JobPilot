<?php

namespace App\Modules\Matching\Services;

use App\Modules\Matching\Contracts\AIProvider;
use App\Modules\Jobs\DTOs\JobDto;

class JobScoringService
{
    public function __construct(private AIProvider $aiProvider) {}

    public function scoreJob(JobDto $job, string $userProfileText): array
    {
        $jobText = $job->title . " " . $job->description . " " . implode(", ", $job->requirements);
        return $this->aiProvider->calculateMatchScore($jobText, $userProfileText);
    }
}
