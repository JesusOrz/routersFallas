<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class IAService
{
    public static function analizarConIA($provider, $model, $logs, $tipo, $descripcion)
    {
        $prompt = "Realiza un análisis del siguiente tipo: *{$tipo}*.\n" .
                  "Descripción: {$descripcion}\n\nLogs:\n{$logs}\n\n" .
                  "Responde SOLO con JSON:\n" .
                  "{ \"severidad\": \"alta|media|baja\", \"mensaje\": \"...\", \"recomendaciones\": [\"...\", \"...\"] }";

        switch ($provider) {
            case 'OpenRouter':
                $apiKey = env('OPENROUTER_API_KEY');
                $url = 'https://openrouter.ai/api/v1/chat/completions';

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])->post($url, [
                    'model' => $model,
                    'messages' => [
                        ['role' => 'system', 'content' => 'Eres un experto en redes que analiza logs de routers MikroTik.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);
                break;

            case 'OpenAI':
                $apiKey = env('OPENAI_API_KEY');
                $url = 'https://api.openai.com/v1/chat/completions';

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])->post($url, [
                    'model' => $model,
                    'messages' => [
                        ['role' => 'system', 'content' => 'Eres un experto en redes que analiza logs de routers MikroTik.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);
                break;

            case 'Gemini':
                $apiKey = env('GEMINI_API_KEY');
                $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->post($url, [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]]
                    ]
                ]);
                break;

            default:
                return null;
        }

        return $response->json();
    }
}
