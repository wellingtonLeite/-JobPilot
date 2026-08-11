<?php

namespace App\Modules\Jobs\Services;

use App\Modules\Jobs\DTOs\JobDto;

class JobDeduplicationService
{
    /**
     * @param JobDto[] $jobs
     * @return JobDto[]
     */
    public function deduplicate(array $jobs): array
    {
        $uniqueJobs = [];
        $hashes = [];

        foreach ($jobs as $job) {
            // Um hash básico combinando título normalizado e empresa
            $hash = md5(strtolower(trim($job->title)) . '|' . strtolower(trim($job->company)));

            if (!isset($hashes[$hash])) {
                $hashes[$hash] = true;
                $uniqueJobs[] = $job;
            }
        }

        return $uniqueJobs;
    }
}
