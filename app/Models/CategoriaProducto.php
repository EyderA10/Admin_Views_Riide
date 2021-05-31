<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaProducto extends Model
{
    protected $table = 'categoria_producto';

    protected $fillable = [
        'categoria_id', 'producto_id'
    ];

    public function producto()
    {
        return $this->belongsTo('App\Models\Producto', 'producto_id');
    }
}
