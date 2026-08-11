<?php

namespace App\Modules\Matching\Providers;

use App\Modules\Matching\Contracts\AIProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiAIProvider implements AIProvider
{
    public function calculateMatchScore(string $jobDescription, string $userProfileText): int
    {
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            Log::warning('GEMINI_API_KEY não configurada. Usando score padrão de fallback.');
            return rand(60, 99); // Fallback caso não haja chave
        }

        $prompt = "Você é um especialista em RH e análise de currículos. Analise a seguinte descrição de vaga e o perfil do usuário.\n";
        $prompt .= "Retorne APENAS UM NÚMERO INTEIRO entre 0 e 100 representando a porcentagem de compatibilidade (match score).\n";
        $prompt .= "Vaga: " . $jobDescription . "\n";
        $prompt .= "Perfil do Usuário: " . $userProfileText;

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ],
                'generationConfig' => [
                    'temperature' => 0.1,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $textResult = $data['candidates'][0]['content']['parts'][0]['text'] ?? '0';
                
                // Limpar resultado para extrair apenas o número
                preg_match('/\d+/', $textResult, $matches);
                return isset($matches[0]) ? (int) $matches[0] : 0;
            }

            Log::error('Erro na API do Gemini: ' . $response->body());
            return 0;

        } catch (\Exception $e) {
            Log::error('Exceção ao conectar no Gemini: ' . $e->getMessage());
            return 0;
        }
    }
}
