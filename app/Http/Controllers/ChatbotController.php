<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FaqRespuesta;
use App\Mail\SugerenciaMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

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


    public function enviarSugerencia(Request $request)
{
    $request->validate([
        'mensaje' => 'required|string|max:2000',
    ]);

    $usuario = Auth::user();
    $mensaje = $request->mensaje;

    $destinatario = 'jor2131100709@gmail.com';

    Mail::to($destinatario)->send(new SugerenciaMail($usuario, $mensaje));

    return response()->json(['success' => true, 'message' => 'Sugerencia enviada con éxito']);
}

}

