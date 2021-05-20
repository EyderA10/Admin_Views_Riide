<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';

    protected $fillable = [
        'dia', 'inicio', 'fin', 'tienda_id', 'state'
    ];

    public function tiendas()
    {
        return $this->hasMany('App\Models\Tienda');
    }
}
