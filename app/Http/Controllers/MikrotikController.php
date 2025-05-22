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
}
