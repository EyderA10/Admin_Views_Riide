<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductQuantity extends Model
{
    protected $table = 'product_quantity';

    protected $fillable = [
        'producto_id', 'tienda_id', 'cantidad', 'inventariable'
    ];

    public function tiendas(){
     return $this->hasMany('App\Models\Tienda');
    }
}
