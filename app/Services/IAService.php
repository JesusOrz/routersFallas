<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Keys;
use App\Models\ArtificialIntelligence;

class IAService
{
    public static function analizarConIA($provider, $model, $logs, $tipo, $descripcion, $userId = null)
    {
        $apiKey = self::obtenerApiKey($provider, $model, $userId);
        if (!$apiKey) {
            return ['error' => 'No se encontró API key válida para ' . $provider . ' - ' . $model];
        }

        $prompt = <<<EOT
Eres un experto en redes que analiza logs de routers MikroTik.

Tipo de análisis: {$tipo}
Descripción: {$descripcion}

Logs:
{$logs}

Devuelve únicamente un JSON válido en este formato, sin explicaciones ni texto adicional:

{
  "severidad": "alta|media|baja",
  "mensaje": "Descripción breve del problema detectado",
  "recomendaciones": ["Recomendación 1", "Recomendación 2"]
}
EOT;

        switch ($provider) {
            case 'Openrouter':
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
                return ['error' => 'Proveedor de IA no válido'];
        }

        return $response->json();
    }

    private static function obtenerApiKey($provider, $model, $userId = null)
    {
        $ia = ArtificialIntelligence::where('ia', $provider)
                                    ->where('model', $model)
                                    ->first();

        if (!$ia) return null;

        return Keys::where('ia_id', $ia->id)
                   ->when($userId, fn($q) => $q->where('user_id', $userId))
                   ->inRandomOrder()
                   ->value('key');
    }
}
