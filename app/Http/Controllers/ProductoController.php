<?php

namespace App\Http\Controllers;

use App\Models\Adicional;
use App\Models\CategoriaProducto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Category;
use App\Models\Tienda;
use App\Models\UserStore;
use App\Models\Producto;
use App\Models\ProductQuantity;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = \Auth::user();
        $name = 'Productos';
        $icon = 'fa fa-shopping-cart mr-1';
        if ($user->roles->id === 7) {
            $productos = Producto::where('user_id', $user->id)->get();
        } elseif ($user->roles->id === 3) {
            $getUser = User::find($user->id);
            $productos = Producto::where('user_id', $getUser->user_id)->get();
        }
        return view('productos.index', compact('name', 'icon', 'productos'));
    }

    public function create()
    {
        $user = \Auth::user();
        $name = 'Productos';
        $sub = 'Crear';
        $icon = 'fa fa-shopping-cart mr-1';
        if ($user->roles->id === 7) {
            $tiendas = Tienda::where('user_id', $user->id)->get();
        } elseif ($user->roles->id === 3) {
            $tiendas = UserStore::where('user_id', $user->id)->get();
            if (count($tiendas) === 0) {
                return redirect()->route('all.productos');
            }
        }
        $categories = Category::all();
        return view('productos.create', compact('name', 'icon', 'sub', 'categories', 'tiendas'));
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $name = 'Productos';
        $sub = 'Editar';
        $icon = 'fa fa-shopping-cart mr-1';
        $categories = Category::all();
        $producto = Producto::find($id);
        $adicionales = Adicional::where('producto_id', $id)->get();
        $product_quantity = ProductQuantity::where('producto_id', $id)->get();
        if ($user->roles->id === 7) {
            $tiendas = Tienda::where('user_id', $user->id)->get();
        } elseif ($user->roles->id === 3) {
            $tiendas = UserStore::where('user_id', $user->id)->get();
            if (count($tiendas) === 0) {
                return redirect()->route('all.productos');
            }
        }
        return view('productos.edit', compact('name', 'sub', 'icon', 'categories', 'producto', 'tiendas', 'adicionales', 'product_quantity'));
    }

    public function editProducto($id, Request $request)
    {
        //dd($request->input("adicionales"));
        // dd($request->all());
        $producto = Producto::find($id);
        $imagen = $request->file('imagen');

        if ($imagen) {
            $image_name = time() . $imagen->getClientOriginalName();
            Storage::disk('productos')->put($image_name, File::get($imagen));
            $producto->imagen = $image_name;
        }
        $producto->producto = $request->input('producto');
        $producto->descripcion = $request->input('descripcion');
        $producto->precio_a = $request->input('precio_a');
        $producto->precio_b = $request->input('precio_b');
        $producto->update();

        if (count(json_decode($request->input("adicionales"))) > 0) {

            Adicional::where('producto_id', $id)->delete();

            $adicionales = json_decode($request->input("adicionales"));
            foreach ($adicionales as $key) {
                if ($key->adicional !== "" && $key->precio !== "") {
                    $adicional = new Adicional;
                    $adicional->adicional = $key->adicional;
                    $adicional->precio = $key->precio;
                    $adicional->producto_id = $producto->id;
                    $adicional->save();
                }
            }
        }

        if( $request->input("categorias") != null ){
            CategoriaProducto::where("producto_id",$producto->id)->delete();
            foreach($request->input("categorias") as $c){
                $categoria_tienda = new CategoriaProducto;
                $categoria_tienda->producto_id = $producto->id;
                $categoria_tienda->categoria_id = $c;
                $categoria_tienda->save();
            }
        }

        if ($request->input('tienda_id') !== null && $request->input('cantidad') !== null && $request->input('inventariable') !== null) {
            ProductQuantity::where('producto_id', $producto->id)->delete();
            foreach ($request->input('tienda_id') as $key => $tienda) {
                $product_quantity = new ProductQuantity();
                $product_quantity->producto_id = $producto->id;
                $product_quantity->tienda_id = $tienda;
                $product_quantity->cantidad = $request->input('cantidad')[$key];
                $product_quantity->inventariable = $request->input('inventariable')[$key];
                $product_quantity->save();
            }
        }
        return redirect()->route('all.productos');
    }

    public function store(Request $request)
    {
        $image_path = $request->file('imagen');
        $user_auth = \Auth::user();
        $user = User::find($user_auth->id);

        if ($image_path) {
            $image_name = time() . $image_path->getClientOriginalName();
            Storage::disk('productos')->put($image_name, File::get($image_path));

            $producto = Producto::create([
                'producto' => $request->input('producto'),
                'descripcion' => $request->input('descripcion'),
                'precio_a' => $request->input('precio_a'),
                'precio_b' => $request->input('precio_b'),
                'imagen' => $image_name,
                'user_id' => $user->user_id
            ]);
        }else {
            return redirect()->route('create.producto');
        }


        if (count(json_decode($request->input("adicionales"))) > 0) {
            $adicionales = json_decode($request->input("adicionales"));
            foreach ($adicionales as $key) {
                if ($key->adicional !== "" && $key->precio !== "") {
                    $adicional = new Adicional();
                    $adicional->adicional = $key->adicional;
                    $adicional->precio = $key->precio;
                    $adicional->producto_id = $producto->id;
                    $adicional->save();
                }
            }
        }

        if ($request->input("categoria_id") != null) {
            foreach ($request->input("categoria_id") as $c) {
                $categoria_tienda = new CategoriaProducto();
                $categoria_tienda->producto_id = $producto->id;
                $categoria_tienda->categoria_id = $c;
                $categoria_tienda->save();
            }
        }

        if ($request->input('tienda_id') !== null && $request->input('cantidad') !== null && $request->input('inventariable') !== null) {
            foreach ($request->input('tienda_id') as $key => $tienda) {
                $product_quantity = new ProductQuantity();
                $product_quantity->producto_id = $producto->id;
                $product_quantity->tienda_id = $tienda;
                $product_quantity->cantidad = $request->input('cantidad')[$key];
                $product_quantity->inventariable = $request->input('inventariable')[$key];
                $product_quantity->save();
            }
        }
        return redirect()->route('all.productos');
    }

    public function getImagenProd($imagen)
    {
        $file = Storage::disk('productos')->get($imagen);
        return new Response($file, 200);
    }

    public function deleteProduct($id)
    {
        if ($this->isFranquiciado()) {

            Producto::where('id', $id)->delete();
            return redirect()->route('all.productos');
        } else {
            return redirect()->route('all.productos');
        }
    }

    private function isFranquiciado()
    {
        if (\Auth::user()->roles->id === 7) {
            return true;
        } elseif (\Auth::user()->roles->id === 3) {
            return false;
        }
    }
}
