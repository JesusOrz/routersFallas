<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Router;
use App\Services\MikrotikService;

class MikrotikController extends Controller
{

    public function index()
    {
        return view('dashboard.routers');
    }


    public function getRouters()
    {
        $routers = Router::all()->map(function ($router) {
            return [
                'id'     => $router->id,
                'host'   => $router->host,
                'user'   => $router->user,
                'state'  => $router->state ?? 'inactivo',
                'port'   => $router->port ?? 8728,
            ];
        });

        return response()->json(['data' => $routers]);
    }
     public function create(Request $request)
    {
        $validated = $request->validate([
            'host' => 'required|string',
            'user' => 'required|string',
            'password' => 'required|string',
            'port' => 'required|integer',
        ]);

        $router = Router::create($validated);

        try {
            $mikrotik = new MikrotikService([
                'host' => $router->host,
                'user' => $router->user,
                'password' => $router->password,
                'port' => $router->port ?? 8728,
            ]);

            if ($mikrotik->testConnection()) {
                $router->state = 'activo';
                $router->save();
            }
        } catch (\Exception $e) {

        }

        return response()->json(['success' => true, 'router' => $router]);
    }



    

    
}
