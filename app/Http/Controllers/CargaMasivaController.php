<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use Illuminate\Http\Request;
use App\Imports\ProductoImport;
use App\Models\Producto;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class CargaMasivaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $name = 'Carga masiva';
        $icon = 'fa fa-cloud-upload-alt mr-1';
        return view('carga_masiva.carga_masiva', compact('name', 'icon'));
    }

    public function cargaMasiva(Request $request)
    {
        try {

            if (!$request->hasFile('carga_masiva_productos')) {
                throw new \Exception('File does not exist');
            }

            $file = $request->file('carga_masiva_productos');
            Excel::import(new ProductoImport, $file);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            dd($e);
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $failure->row();
                $failure->attribute();
                $failure->errors();
                $failure->values();
            }
        } catch (\Exception $e) {
            dd($e);
        }

        $user = \Auth::user();
        $imagenes = $request->file('imagen');
        foreach ($imagenes as $imagen) {
            $file_name = $imagen->getClientOriginalName();
            Storage::disk('productos')->put($file_name, File::get($imagen));
            Producto::where(['imagen' => $file_name, 'user_id' => $user->id])->update(['imagen' => $file_name]);
        }


        return redirect()->route('index.cargam');
    }

    public function export()
    {
        return Excel::download(new ProductsExport, 'carga_masiva.xlsx');
    }
}
