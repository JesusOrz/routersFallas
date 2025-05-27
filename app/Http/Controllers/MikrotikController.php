<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Router;
use App\Services\MikrotikService;

class MikrotikController extends Controller
{
    public function conectar()
    {
        $routers = Router::all();
        $resultados = [];

        foreach ($routers as $router) {
            try {
                $mikrotik = new MikrotikService([
                    'host' => $router->host,
                    'user' => $router->user,
                    'password' => $router->password, // asegúrate que el campo es 'password'
                    'port' => $router->port ?? 8728,
                ]);

                $estado = $mikrotik->testConnection();
            } catch (\Exception $e) {
                $estado = 'Error: ' . $e->getMessage();
            }

            $resultados[] = [
                'id' => $router->id,
                'host' => $router->host,
                'user' => $router->user,
                'state' => $router->state,
                'port' => $router->port,
                
            ];
        }

        return view('dashboard.routers', compact('resultados'));
    }

    public function mostrarLogs()
    {
        $routers = Router::all();
        $logsPorRouter = [];

        foreach ($routers as $router) {
            try {
                $mikrotik = new MikrotikService([
                    'host' => $router->host,
                    'user' => $router->user,
                    'password' => $router->password,
                    'state' => $router->state,
                    'port' => $router->port ?? 8728,
                ]);

                $logs = $mikrotik->getLogs(20);
                $logsPorRouter[] = [
                    'host' => $router->host,
                    'logs' => $logs,
                ];
            } catch (\Exception $e) {
                $logsPorRouter[] = [
                    'host' => $router->host,
                    'logs' => [['message' => 'Error: ' . $e->getMessage()]],
                ];
            }
        }

        return view('dashboard.logs', compact('logsPorRouter'));
    }
}
