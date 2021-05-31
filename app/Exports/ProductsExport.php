<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Tienda;
use App\Models\UserStore;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsExport implements FromView
{
    public function view(): View
    {
        $user = \Auth::user();
        if ($user->roles->id === 7) {
            $tiendas = Tienda::where('user_id', $user->id)->where('state', 1)->get();
        } elseif ($user->roles->id === 3) {
            $tiendas = UserStore::where('user_id', $user->id)->whereHas('tienda', function ($q) {
                $q->where('state', 1);
            })->get();
        }
        $pasos = ['1: los campos producto, descripcion, precio_a, precio_b e imagen se rellenan normalmente con su nombre', '2: en el campo imagen debe colocar el nombre exacto de la imagen
        junto con su extension exacta (.png, .jpg, .jpeg)', '3:Los campos con los nombres de las tiendas no se rellena', '4: los campos cantidad e inventariable se rellenan normalmente con su unico valor', '5: los campos categoria, adicional, precio se puede rellenar variadamente
        puede colocar nombre1,nombre2,nombre3...', '6: las categorias que estan de lado izquierdo son para que puedas
        guiarte y de ahi es donde tendras que copiar y pegar la categoria', 'NOTA: obligatoriamente copiar y pegar la categoria que quieres en el campo categoria'];
        return view('carga_masiva.export', [
            'categories' => Category::all(),
            'tiendas' => $tiendas,
            'pasos' => $pasos
        ]);
    }
}
