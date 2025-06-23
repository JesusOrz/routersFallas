<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtificialIntelligence extends Model
{
    protected $table = 'artificial_intelligence';

    protected $fillable = [
        'id',
        'ia',
        'model',
    ];

    public function ia()
    {
        return $this->belongsTo(ArtificialIntelligence::class, 'ia_id');
    }
}
