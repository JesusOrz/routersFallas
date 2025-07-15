<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Router extends Model
{
    protected $table = 'routers';

    protected $fillable = [
        'id',
        'host',
        'user',
        'password',
        'state',
        'port',
        'userSystem_id',
    ];

    public function user()
{
    return $this->belongsTo(User::class, 'userSystem_id');
}

}


