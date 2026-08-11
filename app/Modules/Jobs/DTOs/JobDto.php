<?php

namespace App\Modules\Jobs\DTOs;

use DateTimeImmutable;

readonly class JobDto
{
    public function __construct(
        public string $id,
        public string $source, // "linkedin" | "infojobs" | "gupy"
        public string $externalId,
        public string $title,
        public string $company,
        public string $description,
        public array $requirements,
        public array $location, // ['city' => string, 'state' => string, 'country' => string]
        public string $workMode, // "remote" | "hybrid" | "onsite" | "unknown"
        public string $applicationStatus, // "open" | "closed" | "unknown"
        public DateTimeImmutable $discoveredAt,
        public ?string $employmentType = null,
        public ?array $salary = null, // ['min' => number, 'max' => number, 'currency' => string]
        public ?DateTimeImmutable $publishedAt = null,
        public ?string $applicationUrl = null,
        public ?string $sourceUrl = null,
    ) {}
}
