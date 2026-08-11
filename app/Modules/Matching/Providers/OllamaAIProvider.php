<?php

namespace App\Modules\Matching\Providers;

use App\Modules\Matching\Contracts\AIProvider;
use Illuminate\Support\Facades\Http;

class OllamaAIProvider implements AIProvider
{
    public function calculateMatchScore(string $jobDescription, string $userProfileText): array
    {
        $url = \App\Models\SystemSetting::where('key', 'ollama_url')->value('value');
        if (empty($url)) {
            $url = 'http://localhost:11434';
        }

        $prompt = "Avalie a vaga e o candidato e retorne EXATAMENTE UM JSON.
VAGA:
$jobDescription
CANDIDATO:
$userProfileText
FORMATO JSON: {\"score\":85,\"hard_skills\":[],\"soft_skills\":[],\"cover_letter\":\"\"}";

        $response = Http::timeout(60)->post("{$url}/api/generate", [
            'model' => 'llama3',
            'prompt' => $prompt,
            'stream' => false,
            'format' => 'json'
        ]);

        if (!$response->successful()) {
            throw new \Exception("Ollama API Error: " . $response->body());
        }

        $data = json_decode($response->json('response'), true);

        if (!$data || !isset($data['score'])) {
            throw new \Exception("Ollama returned invalid JSON.");
        }

        return $data;
    }
}
