<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Router;
use App\Services\MikrotikService;

class RouterController extends Controller
{

    public function index()
    {
        return view('dashboard.tables.routersTable');
    }


    public function getRouters()
    {
        $routers = Router::all()->map(function ($router) {
            return [
                'id' => $router->id,
                'host' => $router->host,
                'user' => $router->user,
                'state' => $router->state ?? 'inactivo',
                'port' => $router->port ?? 8728,
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
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'host' => 'required|string|max:255',
            'user' => 'required|string|max:255',
            'password' => 'nullable|string|max:255',
            'port' => 'required|integer|min:1|max:65535',
        ]);

        $router = Router::find($id);

        if (!$router) {
            return response()->json([
                'success' => false,
                'message' => 'Router no encontrado.'
            ], 404);
        }

        $router->host = $validated['host'];
        $router->user = $validated['user'];
        $router->port = $validated['port'];

        if (!empty($validated['password'])) {
            $router->password = bcrypt($validated['password']);
        }

        $router->save();

        return response()->json([
            'success' => true,
            'message' => 'Router actualizado correctamente.'
        ]);
    }






}
