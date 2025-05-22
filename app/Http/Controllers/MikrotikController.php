<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MikrotikService;


class MikrotikController extends Controller
{
    public function conectar(MikrotikService $mikrotik)
    {
        $mensaje = $mikrotik->testConnection();
        return view('dashboard.routers', compact('mensaje'));
    }
    public function mostrarLogs(MikrotikService $mikrotik)
{
    $logs = $mikrotik->getLogs();
    return view('dashboard.logs', compact('logs'));
}

}
