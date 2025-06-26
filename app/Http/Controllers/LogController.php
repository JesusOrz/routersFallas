<?php

namespace App\Http\Controllers;
use OpenAI;

use Illuminate\Support\Facades\Http;
use App\Services\MikrotikService;
use App\Models\Router;
use App\Services\IAService;

use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        return view('dashboard.logs');
    }

    public function cargarLogsView()
    {
        return view('dashboard.cargarLog');
    }

    public function getLogs(Request $request)
    {
        $router = Router::findOrFail($request->router_id);

        try {
            $mikrotik = new MikrotikService([
                'host' => $router->host,
                'user' => $router->user,
                'password' => $router->password,
                'port' => $router->port ?? 8728,
            ]);

            $logs = $mikrotik->getLogs();

            $output = '';
            foreach ($logs as $log) {
                $output .= '[' . ($log['time'] ?? '') . '] ' . ($log['message'] ?? '') . "\n";
            }

            return response()->json(['logs' => $output]);

        } catch (\Exception $e) {
            return response()->json(['logs' => 'Error: ' . $e->getMessage()], 500);
        }
    }

   public function analizarLogsConIA(Request $request)
{
    $logs = $request->input('logs');
    $analysisTypes = $request->input('analysis_types');
    $provider = $request->input('ia_provider', 'openrouter');
    $model = $request->input('ia_model', 'openai/gpt-4o');

    if (!$logs || !$analysisTypes || !$provider || !$model) {
        return response()->json(['error' => 'Faltan parámetros.'], 400);
    }

    $resultados = [];

    foreach ($analysisTypes as $id) {
        $analisis = \App\Models\Analysis::find($id);
        if (!$analisis) continue;

        $response = IAService::analizarConIA(
            $provider,
            $model,
            $logs,
            $analisis->analysis,
            $analisis->description
        );

        $content = match($provider) {
            'gemini' => $response['candidates'][0]['content']['parts'][0]['text'] ?? null,
            default => $response['choices'][0]['message']['content'] ?? null,
        };

        $decoded = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $decoded = ['severidad' => 'media', 'mensaje' => 'Respuesta inválida', 'recomendaciones' => [], 'raw' => $content];
        }

        $resultados[] = [
            'proveedor' => $provider,
            'modelo' => $model,
            'nombre' => $analisis->analysis,
            'descripcion' => $analisis->description,
            'resultado' => $decoded,
        ];
    }

    return response()->json(['resultados' => $resultados]);
}





    public function uploadLog(Request $request)
{
    $request->validate([
        'logfile' => 'required|file|mimes:txt|max:2048',
        'analysis_types' => 'required|string', // JSON desde JS
        'analysis_descriptions' => 'required|string',
    ]);

    try {
        $fileContent = file_get_contents($request->file('logfile')->getRealPath());

        $analysisTypes = json_decode($request->input('analysis_types'), true);
        $analysisDescriptions = json_decode($request->input('analysis_descriptions'), true);

        if (!is_array($analysisTypes) || !is_array($analysisDescriptions)) {
            return response()->json(['error' => 'Los tipos o descripciones no son válidos.'], 400);
        }

        $apiKey = env('OPENROUTER_API_KEY');
        $baseUrl = 'https://openrouter.ai/api/v1/chat/completions';

        $results = [];

        foreach ($analysisTypes as $index => $typeId) {
            $description = $analysisDescriptions[$index] ?? 'Sin descripción';

            $prompt = "Realiza un análisis del siguiente tipo: *{$typeId}*.\n" .
                      "Descripción del análisis: {$description}\n\n" .
                      "Logs del archivo:\n\n{$fileContent}\n\n" .
                      "Por favor, responde SOLO con un JSON con esta estructura:\n" .
                      "{\n" .
                      "  \"severidad\": \"alta|media|baja\",\n" .
                      "  \"mensaje\": \"Mensaje descriptivo del análisis.\",\n" .
                      "  \"recomendaciones\": [\"Recomendación 1\", \"Recomendación 2\", \"Recomendación 3\"]\n" .
                      "}\n" .
                      "No incluyas texto adicional fuera del JSON.";

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'HTTP-Referer' => 'http://localhost',
                'Content-Type' => 'application/json',
            ])->post($baseUrl, [
                'model' => 'openai/gpt-4.1-nano',
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un experto en redes que analiza logs de routers MikroTik.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.3,
            ]);

            $respuesta = $response['choices'][0]['message']['content'] ?? null;

            if (!$respuesta) {
                $results[] = [
                    'type' => $typeId,
                    'description' => $description,
                    'resultado' => ['severidad' => 'media', 'mensaje' => 'Sin respuesta del analizador.', 'recomendaciones' => []],
                ];
                continue;
            }

            $decoded = json_decode($respuesta, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $results[] = [
                    'type' => $typeId,
                    'description' => $description,
                    'resultado' => ['severidad' => 'media', 'mensaje' => 'Respuesta con formato inválido.', 'recomendaciones' => [], 'raw' => $respuesta],
                ];
                continue;
            }

            $results[] = [
                'type' => $typeId,
                'description' => $description,
                'resultado' => $decoded,
            ];
        }

        return response()->json(['analisis' => $results]);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al comunicarse con OpenRouter: ' . $e->getMessage()], 500);
    }
}








}
