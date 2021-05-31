<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $guarded = [];

    protected $fillable = [
        'producto', 'descripcion', 'precio_a', 'precio_b', 'imagen', 'user_id', 'state'
    ];
}
