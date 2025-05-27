<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Router; 

class DashboardController extends Controller
{
    public function index()
    {
        $routers = Router::all();
        return view('dashboard.dashboard', compact('routers'));
    }
}

