<?php

namespace App\Http\Controllers;
use App\Services\MikrotikService;
use App\Models\Router;

use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        return view('dashboard.logs');
    }


   
}
