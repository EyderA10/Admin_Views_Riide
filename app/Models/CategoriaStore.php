<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaStore extends Model
{
    protected $table = 'categoria_tienda';

    protected $fillable = [
        'tienda_id', 'categoria_id'
    ];

    public function tiendas()
    {
        return $this->belongsTo('App\Models\Tienda', 'tienda_id');
    }
    
    public function categorias()
    {
        return $this->belongsTo('App\Models\Category', 'categoria_id');
    }
}
