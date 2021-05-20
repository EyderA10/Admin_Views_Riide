<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adicional extends Model
{
    protected $table = 'adicionales';

    protected $fillable = [
        'producto_id', 'adicional', 'precio'
    ];
}
