<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Router; 
use App\Models\Keys; 
use \Auth; 

class DashboardController extends Controller
{
    public function index()
    {

        $userId = Auth::id();

    // Routers asignados al usuario (por userSystem_id)
    $routerCount = Router::where('userSystem_id', $userId)->count();

    // Keys asignadas al usuario (por user_id)
    $keyCount = Keys::where('user_id', $userId)->count();

        return view('dashboard.dashboard', compact('routerCount', 'keyCount'));
    }

    
public function getStats()
{
    $userId = Auth::id();

    $routerCount = Router::where('userSystem_id', $userId)->count();
    $keyCount = Keys::where('user_id', $userId)->count();

    return response()->json([
        'routers' => $routerCount,
        'keys' => $keyCount,
    ]);
}
}

