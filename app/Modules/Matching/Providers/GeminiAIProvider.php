<?php

namespace App\Modules\Matching\Providers;

use App\Modules\Matching\Contracts\AIProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiAIProvider implements AIProvider
{
    public function calculateMatchScore(string $jobDescription, string $userProfileText): array
    {
        $apiKey = \App\Models\SystemSetting::where('key', 'gemini_api_key')->value('value');

        if (empty($apiKey)) {
            throw new \Exception("Gemini API Key not configured.");
        }

        $prompt = "Você é um especialista em RH e análise de currículos. Analise a seguinte vaga e o perfil do usuário.\n";
        $prompt .= "Retorne estritamente um JSON no seguinte formato (sem formatação markdown, apenas o JSON puro):\n";
        $prompt .= '{"score": (inteiro 0-100), "hard_skills": ["skill1"], "soft_skills": ["skill2"], "cover_letter": "carta em pt-br"}'."\n\n";
        $prompt .= "Vaga: " . $jobDescription . "\n\n";
        $prompt .= "Perfil do Usuário: " . $userProfileText;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])
        ->withoutVerifying()
        ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ],
            'generationConfig' => [
                'temperature' => 0.2,
            ]
        ]);

        if (!$response->successful()) {
            throw new \Exception("Gemini API Error: " . $response->body());
        }

        $data = $response->json();
        $textResult = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
        
        $textResult = preg_replace('/```json|```/', '', $textResult);
        $json = json_decode(trim($textResult), true);

        if (!is_array($json) || !isset($json['score'])) {
            throw new \Exception("Gemini returned invalid JSON.");
        }

        return $json;
    }
}
