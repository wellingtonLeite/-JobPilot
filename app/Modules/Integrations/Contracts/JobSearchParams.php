<?php

namespace App\Modules\Integrations\Contracts;

class JobSearchParams
{
    public function __construct(
        public array $keywords = [],
        public array $locations = [],
        public ?bool $homeOfficeOnly = null,
        public ?bool $hasEnglishProficiency = null,
        public ?int $recencyDays = 7,
    ) {}
}
