<?php

namespace App\Modules\Matching\Providers;

use App\Modules\Matching\Contracts\AIProvider;
use Illuminate\Support\Facades\Http;

class OpenRouterAIProvider implements AIProvider
{
    public function calculateMatchScore(string $jobDescription, string $userProfileText): array
    {
        $apiKey = \App\Models\SystemSetting::where('key', 'openrouter_api_key')->value('value');
        
        if (empty($apiKey)) {
            throw new \Exception("OpenRouter API Key not configured.");
        }

        $prompt = "Você é um recrutador tech sênior. Avalie o perfil do candidato contra a vaga e retorne APENAS um JSON válido.
VAGA:
$jobDescription

CANDIDATO:
$userProfileText

FORMATO JSON OBRIGATÓRIO:
{
  \"score\": 85,
  \"hard_skills\": [\"skill1\", \"skill2\"],
  \"soft_skills\": [\"skill1\"],
  \"cover_letter\": \"Olá, tenho experiência em...\"
}";

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => 'meta-llama/llama-3-8b-instruct:free',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ]
        ]);

        if (!$response->successful()) {
            throw new \Exception("OpenRouter API Error: " . $response->body());
        }

        $content = $response->json('choices.0.message.content');
        $content = str_replace(['```json', '```', "\n"], '', $content);
        $data = json_decode(trim($content), true);

        if (!$data || !isset($data['score'])) {
            throw new \Exception("OpenRouter returned invalid JSON: " . $content);
        }

        return $data;
    }
}
