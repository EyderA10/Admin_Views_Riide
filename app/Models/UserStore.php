<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStore extends Model
{
    protected $table = 'user_stores';

    protected $fillable = [
        'tienda_id', 'user_id', 'type'
    ];

    public function tienda()
    {
        return $this->belongsTo('App\Models\Tienda', 'tienda_id');
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
