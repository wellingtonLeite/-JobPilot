<?php

namespace App\Modules\Integrations\Contracts;

use App\Modules\Jobs\DTOs\JobDto;

interface JobSourceAdapter
{
    /**
     * @return JobDto[]
     */
    public function searchJobs(JobSearchParams $params): array;

    public function getJob(string $jobId): ?JobDto;

    public function checkAvailability(JobDto $job): JobAvailability;

    public function getApplicationUrl(JobDto $job): ?string;

    public function normalizeJob(array|object $job): JobDto;
}
