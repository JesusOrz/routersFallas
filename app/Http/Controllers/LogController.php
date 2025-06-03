<?php

namespace App\Http\Controllers;
use App\Services\MikrotikService;
use App\Models\Router;

use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        $routers = \App\Models\Router::all(); 
        return view('dashboard.logs', compact('routers'));
    }

    public function show($id)
{
    $router = Router::findOrFail($id);

    $config = [
        'host' => $router->host,
        'user' => $router->user,
        'password' => $router->password,
        'port' => $router->port,
    ];

    try {
        $mikrotik = new MikrotikService($config);
        $logs = $mikrotik->getLogs(100); // puedes ajustar el número de logs

        return view('logs.show', [ // asegúrate de tener esta vista
            'router' => $router,
            'logs' => $logs,
        ]);
    } catch (\Exception $e) {
        return redirect()->route('routers')->with('error', 'Error al obtener logs: ' . $e->getMessage());
    }
}

   
}
