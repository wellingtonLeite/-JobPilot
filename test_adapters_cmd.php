<?php
$params = new \App\Modules\Integrations\Contracts\JobSearchParams(['php', 'laravel']);

echo "Testando InfoJobs...\n";
$infojobs = new \App\Modules\Integrations\Adapters\InfoJobsAdapter();
$jobs = $infojobs->searchJobs($params);
echo count($jobs) . " vagas encontradas.\n";

echo "Testando Gupy...\n";
$gupy = new \App\Modules\Integrations\Adapters\GupyAdapter();
$jobs2 = $gupy->searchJobs($params);
echo count($jobs2) . " vagas encontradas.\n";

echo "Testando LinkedIn...\n";
$linkedin = new \App\Modules\Integrations\Adapters\LinkedInAdapter();
$jobs3 = $linkedin->searchJobs($params);
echo count($jobs3) . " vagas encontradas.\n";
