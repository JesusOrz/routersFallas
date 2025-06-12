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

        if (!$logs) {
            return response()->json(['error' => 'No se proporcionaron logs'], 400);
        }

        try {
            $apiKey = env('OPENROUTER_API_KEY'); 

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                        'model' => 'openai/gpt-3.5-turbo', 
                        'messages' => [
                            ['role' => 'system', 'content' => 'Eres un experto en redes que analiza logs de routers MikroTik.'],
                            ['role' => 'user', 'content' => "Analiza estos logs y dime si hay posibles fallas o configuraciones incorrectas, fallas hardware, ataques:\n\n" . $logs],
                        ],
                        'temperature' => 0.3,
                    ]);

            return response()->json(['respuesta' => $response['choices'][0]['message']['content']]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al comunicarse con OpenRouter: ' . $e->getMessage()], 500);
        }
    }
    public function uploadLog(Request $request)
{
    $request->validate([
        'logfile' => 'required|file|mimes:txt|max:2048',
    ]);

    try {
        $fileContent = file_get_contents($request->file('logfile')->getRealPath());

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
                ['role' => 'user', 'content' => "Analiza estos logs de archivo:\n\n" . $fileContent],
            ],
            'temperature' => 0.3,
        ]);

        if (!isset($response['choices'][0]['message']['content'])) {
            return response()->json(['error' => 'Respuesta inválida de OpenRouter'], 500);
        }

        $respuesta = $response['choices'][0]['message']['content'];

        return response()->json(['respuesta' => $respuesta]);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al comunicarse con OpenRouter: ' . $e->getMessage()], 500);
    }
}






}
