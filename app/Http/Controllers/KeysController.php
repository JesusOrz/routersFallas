<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keys;

class KeysController extends Controller
{
    public function getKeys()
    {
        $keys = Keys::with('ia')->get()->map(function ($key) {
            return [
                'id' => $key->id,
                'key' => $key->key,
                'ia_id' => $key->ia_id,
                'user_id' => $key->user_id,
                'ia_name' => $key->ia ? $key->ia->ia : 'IA no asignada',
                'ia_model' => $key->ia ? $key->ia->model : 'Modelo no asignado',
            ];
        });

        return response()->json(['data' => $keys]);
    }


    public function create(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string',
            'ia_id' => 'required|string',
            'user_id' => 'required|string',
        ]);

        $ia = Keys::create($validated);

        return response()->json(['success' => true, 'IA' => $ia]);
    }

}
