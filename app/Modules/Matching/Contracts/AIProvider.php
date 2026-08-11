<?php

namespace App\Modules\Matching\Contracts;

interface AIProvider
{
    /**
     * @param string $jobDescription
     * @param string $userProfileText
     * @return array contendo score, hard_skills, soft_skills, e cover_letter
     */
    public function calculateMatchScore(string $jobDescription, string $userProfileText): array;
}
