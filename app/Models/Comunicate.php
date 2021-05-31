<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comunicate extends Model
{
    protected $table = "comunicate";

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
