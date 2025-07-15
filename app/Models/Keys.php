<?php

namespace App\Models;
use App\Models\ArtificialIntelligence;
use Illuminate\Database\Eloquent\Model;
class Keys extends Model
{
    protected $table = 'api-keys';

    protected $fillable = [
        'id',
        'key',
        'ia_id',
        'user_id',
        
    ];


    public function ia()
    {
        return $this->belongsTo(ArtificialIntelligence::class, 'ia_id');
    }

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

}
