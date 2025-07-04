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
                'type' =>$ia->type,
            ];
        });

        return response()->json(['data' => $ias]);
    }
}
