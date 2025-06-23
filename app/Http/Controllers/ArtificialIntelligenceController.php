<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArtificialIntelligence;
class ArtificialIntelligenceController extends Controller
{
    public function getIA()
    {
        $ias = ArtificialIntelligence::all()->map(function ($ia) {
            return [
                'id' => $ia->id,
                'ia' => $ia->ia,
                'model' =>$ia->model,
            ];
        });

        return response()->json(['data' => $ias]);
    }
        public function create(Request $request)
    {
        $validated = $request->validate([
            'ia' => 'required|string',
            'model' => 'required|string',
        ]);

        $ia = ArtificialIntelligence::create($validated);

        return response()->json(['success' => true, 'ia' => $ia]);
    }
}
