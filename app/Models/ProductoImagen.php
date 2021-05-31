<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoImagen extends Model
{
    protected $table = "producto_imagen";

    protected $fillable = [
        'producto_id', 'imagen', 'orden'
    ];

    public function producto()
    {
        return $this->belongsTo('App\Models\Producto', 'producto_id');
    }
}
