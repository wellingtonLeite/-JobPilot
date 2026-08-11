<?php

namespace App\Modules\Matching\Contracts;

interface AIProvider
{
    /**
     * @param string $jobDescription
     * @param string $userProfileText
     * @return int Um score de 0 a 100
     */
    public function calculateMatchScore(string $jobDescription, string $userProfileText): int;
}
