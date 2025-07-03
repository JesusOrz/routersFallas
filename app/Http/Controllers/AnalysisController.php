<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Analysis;

class AnalysisController extends Controller
{

    public function index()
    {
        return view('dashboard.tables.analysisTable');
    }
    public function getAnalysisTypes()
    {
        $analysisTypes = Analysis::all()->map(function ($analysis) {
            return [
                'id' => $analysis->id,
                'analysis' => $analysis->analysis,
                'description' => $analysis->description,

            ];
        });

        return response()->json(['data' => $analysisTypes]);
    }
    public function create(Request $request)
    {
        $validated = $request->validate([
            'analysis' => 'required|string',
            'description' => 'required|string',
        ]);

        $Analysis = Analysis::create($validated);

        return response()->json(['success' => true, 'analysis' => $Analysis]);
    }
}
