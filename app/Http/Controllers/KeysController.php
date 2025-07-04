<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keys;
use App\Models\ArtificialIntelligence;

class KeysController extends Controller
{

    public function index()
    {
        return view('dashboard.tables.keysTable');
    }


    public function getKeys()
    {
        $keys = Keys::with('ia')->get()->map(function ($key) {
            return [
                'id'         => $key->id,
                'key'        => $key->key,
                'ia_id'      => $key->ia_id,
                'user_id'    => $key->user_id,
                'ia_name'    => $key->ia ? $key->ia->ia : 'IA no asignada',
                'ia_model'   => $key->ia ? $key->ia->model : 'Modelo no asignado',
                'type'       => $key->ia ? $key->ia->type : 'Tipo no asignado',
                
            ];
        });

        return response()->json(['data' => $keys]);
    }


    public function create(Request $request)
{
    $validated = $request->validate([
        'key' => 'required|string',
        'ia' => 'required|string',
        'model' => 'required|string',
        'user_id' => 'required|integer',
    ]);

    $iaRow = ArtificialIntelligence::where('ia', $validated['ia'])
                                   ->where('model', $validated['model'])
                                   ->first();

    if (!$iaRow) {
        return response()->json(['success' => false, 'errors' => ['model' => ['Proveedor o modelo no válido.']]], 422);
    }

    $key = Keys::create([
        'key' => $validated['key'],
        'ia_id' => $iaRow->id,
        'user_id' => $validated['user_id'],
    ]);

    return response()->json(['success' => true, 'IA' => $key]);
}
}