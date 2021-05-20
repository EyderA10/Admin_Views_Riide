<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CuentaController extends Controller
{
    public function index()
    {
        $name = 'Estado de Cuenta';
        $icon = 'fa fa-dollar-sign mr-1';
        return view('cuenta.index', compact('name', 'icon'));
    }
}
