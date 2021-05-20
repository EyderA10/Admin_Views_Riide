<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';

    public function usuarios(){
     return $this->hasMany('App\User');
    }
}
