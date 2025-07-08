<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FaqRespuesta;

class ChatbotController extends Controller
{
    public function handle(Request $request)
    {
        $mensaje = strtolower(trim($request->input('message')));
        
        // Buscar una coincidencia parcial con la clave
        $respuesta = FaqRespuesta::whereRaw('? LIKE CONCAT("%", pregunta_clave, "%")', [$mensaje])
            ->value('respuesta');

        if (!$respuesta) {
            $respuesta = "Lo siento, no entendí tu pregunta. Intenta con otras palabras o revisa la sección de ayuda.";
        }

        return response()->json(['reply' => $respuesta]);
    }
}

