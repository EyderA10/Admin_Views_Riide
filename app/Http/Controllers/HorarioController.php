<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Tienda;
use App\Models\UserStore;
use Illuminate\Http\Request;

class HorarioController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = \Auth::user();
        $name = 'Horario de la Tienda';
        $icon = 'fa fa-clock mr-1';
        
        if ($user->roles->id === 7) {
            $tiendas = Tienda::where('user_id', $user->id)->get();
        } elseif ($user->roles->id === 3) {
            $tiendas = UserStore::where('user_id', $user->id)->get();
            if (count($tiendas) === 0) {
                return redirect()->route('all.productos');
            }
        }
        // $horarios = Horario::where("tienda_id",$tiendas[0]->id)->get();
        return view('horario.index', compact('name', 'icon', 'tiendas'));
    }

    public function create(Request $request)
    {
        $tienda_id = $request->input('tienda_id');
        $apertura = json_decode($request->input('apertura'));
        $cierre =  json_decode($request->input('cierre'));

        if (count($apertura) > 0) {
            foreach ($apertura as $apt) {
                foreach ($apt->dias as $dia) {
                    $horario = new Horario();
                    $horario->dia = $dia;
                    $horario->state = $apt->state;
                    $horario->inicio = $apt->hora;
                    $horario->tienda_id = $tienda_id;
                    $horario->save();
                }
            }
        }

        if (count($cierre) > 0) {
            foreach ($cierre as $close) {
                foreach ($close->dias as $dia) {
                    $horario = new Horario();
                    $horario->dia = $dia;
                    $horario->state = $close->state;
                    $horario->fin = $close->hora;
                    $horario->tienda_id = $tienda_id;
                    $horario->save();
                }
            }
        }

        return redirect()->route('horarios');
    }
}
