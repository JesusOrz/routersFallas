<?php

namespace App\Http\Controllers;
use OpenAI;

use Illuminate\Support\Facades\Http;
use App\Services\MikrotikService;
use App\Models\ArtificialIntelligence;
use App\Models\Analysis;
use App\Models\Keys;
use App\Models\Router;
use App\Services\IAService;

use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        return view('dashboard.logs.logs');
    }

    public function cargarLogsView()
    {
        return view('dashboard.logs.cargarLog');
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
        $provider = $request->input('ia_provider');
        $model = $request->input('ia_model');

        if (!$logs || !$analysisTypes || !$provider || !$model) {
            return response()->json(['error' => 'Faltan parámetros.'], 400);
        }


        $ia = ArtificialIntelligence::where('ia', $provider)
            ->where('model', $model)
            ->first();

        if (!$ia) {
            return response()->json([
                'error' => "El modelo '{$model}' del proveedor '{$provider}' no está registrado."
            ], 400);
        }

        $key = Keys::where('ia_id', $ia->id)
            ->where('user_id', auth()->id())
            ->whereNotNull('key')
            ->first();

        if (!$key) {
            return response()->json([
                'error' => "No tienes una clave válida asignada para el modelo '{$model}' de '{$provider}'."
            ], 400);
        }


        $resultados = [];

        foreach ($analysisTypes as $id) {
            $analisis = Analysis::find($id);
            if (!$analisis)
                continue;

            $response = IAService::analizarConIA(
                $provider,
                $model,
                $logs,
                $analisis->analysis,
                $analisis->description,
                auth()->id()
            );

            $content = match ($provider) {
                'Gemini' => $response['candidates'][0]['content']['parts'][0]['text'] ?? null,
                default => $response['choices'][0]['message']['content'] ?? null,
            };

            if ($provider === 'Gemini' && $content) {
                $content = trim($content);
                $content = preg_replace('/^```json|```$/m', '', $content);
                $content = preg_replace('/^```|```$/m', '', $content);
                $content = trim($content);

                if (!str_starts_with($content, '{')) {
                    if (preg_match('/\{(?:[^{}]|(?R))*\}/s', $content, $matches)) {
                        $content = $matches[0];
                    }
                }
            }

            $decoded = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $decoded = [
                    'severidad' => 'media',
                    'mensaje' => 'Respuesta inválida',
                    'recomendaciones' => [],
                    'raw' => $content,
                ];
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
        'analysis_types' => 'required|string',        
        'analysis_descriptions' => 'required|string', 
        'ia_provider' => 'required|string',
        'ia_model' => 'required|string',
    ]);

    try {
        $fileContent = file_get_contents($request->file('logfile')->getRealPath());
        $analysisTypes = json_decode($request->input('analysis_types'), true);
        $analysisDescriptions = json_decode($request->input('analysis_descriptions'), true);
        $provider = $request->input('ia_provider');
        $model = $request->input('ia_model');

        // Validar que los arrays sean válidos
        if (!is_array($analysisTypes) || !is_array($analysisDescriptions)) {
            return response()->json(['error' => 'Los tipos o descripciones no son válidos.'], 400);
        }

        // Validar existencia de modelo IA
        $ia = ArtificialIntelligence::where('ia', $provider)
            ->where('model', $model)
            ->first();

        if (!$ia) {
            return response()->json([
                'error' => "El modelo '{$model}' del proveedor '{$provider}' no está registrado."
            ], 400);
        }

        // Validar que el usuario tenga clave válida para ese IA
        $key = Keys::where('ia_id', $ia->id)
            ->where('user_id', auth()->id())
            ->whereNotNull('key')
            ->first();

        if (!$key) {
            return response()->json([
                'error' => "No tienes una clave válida para el modelo '{$model}' de '{$provider}'."
            ], 400);
        }

        $results = [];

        foreach ($analysisTypes as $index => $typeId) {
            $description = $analysisDescriptions[$index] ?? 'Sin descripción';

            $response = IAService::analizarConIA(
                $provider,
                $model,
                $fileContent,
                $typeId,
                $description,
                auth()->id()
            );

            $content = match ($provider) {
                'Gemini' => $response['candidates'][0]['content']['parts'][0]['text'] ?? null,
                default => $response['choices'][0]['message']['content'] ?? null,
            };

            if ($provider === 'Gemini' && $content) {
                $content = trim($content);
                $content = preg_replace('/^```json|```$/m', '', $content);
                $content = preg_replace('/^```|```$/m', '', $content);
                $content = trim($content);

                if (!str_starts_with($content, '{')) {
                    if (preg_match('/\{(?:[^{}]|(?R))*\}/s', $content, $matches)) {
                        $content = $matches[0];
                    }
                }
            }

            $decoded = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $results[] = [
                    'type' => $typeId,
                    'description' => $description,
                    'resultado' => [
                        'severidad' => 'media',
                        'mensaje' => 'Respuesta con formato inválido.',
                        'recomendaciones' => [],
                        'raw' => $content,
                    ]
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
        return response()->json(['error' => 'Error en el análisis: ' . $e->getMessage()], 500);
    }
}

}
