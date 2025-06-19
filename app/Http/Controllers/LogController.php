<?php

namespace App\Http\Controllers;
use OpenAI;

use Illuminate\Support\Facades\Http;
use App\Services\MikrotikService;
use App\Models\Router;

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
    $analysisTypes = $request->input('analysis_types'); // array de IDs de análisis

    if (!$logs || !is_array($analysisTypes) || count($analysisTypes) === 0) {
        return response()->json(['error' => 'Faltan datos para el análisis.'], 400);
    }

    try {
        $apiKey = env('OPENROUTER_API_KEY');

        $resultados = [];

        foreach ($analysisTypes as $id) {
            $analisis = \App\Models\Analysis::find($id); // Asegúrate que usas el modelo correcto

            if (!$analisis) {
                continue; // Ignorar análisis inválido
            }

            $tipo = $analisis->analysis;
            $descripcion = $analisis->description;

            // Petición a OpenRouter
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'openai/gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Eres un experto en redes que analiza logs de routers MikroTik.',
                    ],
                    [
                        'role' => 'user',
                        'content' => "Realiza un análisis del siguiente tipo: *{$tipo}*.\nDescripción del análisis: {$descripcion}\n\nLogs:\n\n{$logs}\n\nPor favor, responde SOLO con un JSON con esta estructura:\n{\n  \"severidad\": \"alta|media|baja\",\n  \"mensaje\": \"Mensaje descriptivo del análisis.\",\n  \"recomendaciones\": [\"Recomendación 1\", \"Recomendación 2\", \"Recomendación 3\"]\n}\nNo incluyas texto adicional fuera del JSON."
                    ],
                ],
                'temperature' => 0.3,
            ]);

            $content = $response['choices'][0]['message']['content'] ?? null;

            if (!$content) {
                $resultados[] = [
                    'nombre' => $tipo,
                    'descripcion' => $descripcion,
                    'severidad' => 'desconocida',
                    'mensaje' => 'No se recibió respuesta válida del modelo.',
                ];
                continue;
            }

            $decoded = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $resultados[] = [
                    'nombre' => $tipo,
                    'descripcion' => $descripcion,
                    'severidad' => 'desconocida',
                    'mensaje' => 'El modelo devolvió una respuesta inválida.',
                ];
                continue;
            }

            // Agregar resultado
            $resultados[] = [
                'nombre' => $tipo,
                'descripcion' => $descripcion,
                'severidad' => $decoded['severidad'] ?? 'desconocida',
                'mensaje' => $decoded['mensaje'] ?? '',
                'recomendaciones' => $decoded['recomendaciones'] ?? [],
            ];
        }

        return response()->json(['resultados' => $resultados]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error al comunicarse con OpenRouter: ' . $e->getMessage(),
        ], 500);
    }
}





    public function uploadLog(Request $request)
{
    $request->validate([
        'logfile' => 'required|file|mimes:txt|max:2048',
        'analysis_type' => 'required|string',
        'analysis_description' => 'required|string',
    ]);

    try {
        $fileContent = file_get_contents($request->file('logfile')->getRealPath());
        $analysisType = $request->input('analysis_type');
        $analysisDescription = $request->input('analysis_description');

        $apiKey = env('OPENROUTER_API_KEY');
        $baseUrl = 'https://openrouter.ai/api/v1/chat/completions';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'HTTP-Referer' => 'http://localhost',
            'Content-Type' => 'application/json',
        ])->post($baseUrl, [
            'model' => 'openai/gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Eres un experto en redes que analiza logs de routers MikroTik.'],
                ['role' => 'user', 'content' => 
                    "Realiza un análisis del siguiente tipo: *{$analysisType}*.\n" .
                    "Descripción del análisis: {$analysisDescription}\n\n" .
                    "Logs del archivo:\n\n{$fileContent}\n\n" .
                    "Por favor, responde SOLO con un JSON con esta estructura:\n" .
                    "{\n" .
                    "  \"severidad\": \"alta|media|baja\",\n" .
                    "  \"mensaje\": \"Mensaje descriptivo del análisis.\",\n" .
                    "  \"recomendaciones\": [\"Recomendación 1\", \"Recomendación 2\", \"Recomendación 3\"]\n" .
                    "}\n" .
                    "No incluyas texto adicional fuera del JSON."
                ],
            ],
            'temperature' => 0.3,
        ]);

        $respuesta = $response['choices'][0]['message']['content'] ?? null;

        if (!$respuesta) {
            return response()->json(['error' => 'Respuesta inválida de OpenRouter'], 500);
        }

        // Intentar decodificar JSON
        $decoded = json_decode($respuesta, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'El formato de respuesta no es válido.', 'raw' => $respuesta], 500);
        }

        return response()->json($decoded);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al comunicarse con OpenRouter: ' . $e->getMessage()], 500);
    }
}







}
