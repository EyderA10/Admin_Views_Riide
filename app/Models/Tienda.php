<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    protected $table = 'tiendas';

    protected $fillable = [
        'tienda', 'imagen', 'panel', 'sector', 'user_id', 'tiempo', 'owner_id', 'state'
    ];

    public function users(){
        return $this->hasMany('App\User', 'user_id');
    }
    
}
