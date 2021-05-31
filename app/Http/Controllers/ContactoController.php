<?php

namespace App\Http\Controllers;

use App\Models\Comunicate;
use Illuminate\Http\Request;

class ContactoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if($this->isAdmin()) {
            $name = 'Contactos';
            $icon = 'fa fa-address-book mr-1';
            $contactos = Comunicate::with('user')->get();
            return view('contactos.contacto', compact('name', 'icon', 'contactos'));
        }
    }

    private function isAdmin()
    {
        if(\Auth::user()->roles->id === 2) {
            return true;
        }else {
            return redirect()->route('admin-welcm');
        }
    }
}
