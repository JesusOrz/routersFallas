<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqRespuesta extends Model
{
    protected $table = 'faq_respuestas';

    protected $fillable = [
        'id',
        'pregunta_clave',
        'respuesta',
        
    ];
}
