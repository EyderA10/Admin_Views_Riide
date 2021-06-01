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
use App\Models\ProductoImagen;
use App\Models\ProductQuantity;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['cargaMasiva']]);
    }

    public function index($category = null)
    {
        $user = \Auth::user();
        $name = 'Productos';
        $icon = 'fa fa-shopping-cart mr-1';
        $categories = Category::all();
        $producto_category = false;
        $productos_imagen = [];
        if ($category !== null) {
            $producto_category = true;
            if ($user->roles->id === 2) {
                //productos con categorias
                $productos = CategoriaProducto::where('categoria_id', $category)->whereHas('producto', function ($q) {
                    $q->where('state', 1);
                })->with('producto')->paginate(6);
                //productos con imagen
                $productos_imagen = ProductoImagen::groupBy('producto_id')->get();
                if(count($productos_imagen) === 0) {
                    dd($productos_imagen);
                }
            } else {
                //productos con categorias
                $productos = CategoriaProducto::where('categoria_id', $category)->whereHas('producto', function ($q) use ($user) {
                    $q->where('state', 1)->where('user_id', $user->id);
                })->with('producto')->paginate(6);

                //productos con imagen
                $productos_imagen = ProductoImagen::whereHas('producto', function ($q) use ($user) {
                    $q->where('user_id', $user->id)->where('state', 1);
                })->groupBy('producto_id')->get();
                if(count($productos_imagen) === 0) {
                    dd($productos_imagen );
                }
            }
        } else {
            if ($user->roles->id === 7) {
                $productos = ProductoImagen::whereHas('producto', function ($q) use ($user) {
                    $q->where('user_id', $user->id)->where('state', 1);
                })->with('producto')->groupBy('producto_id')->paginate(6);
                if(count($productos) === 0) {
                    $productos = Producto::where('user_id', $user->id)->where('state', 1)->paginate(6);
                }
            } elseif ($user->roles->id === 3) {
                $getUser = User::find($user->id);
                $productos = ProductoImagen::whereHas('producto', function ($q) use ($getUser) {
                    $q->where('user_id', $getUser->id)->where('state', 1);
                })->with('producto')->groupBy('producto_id')->paginate(6);
                if(count($productos) === 0) {
                    $productos = Producto::where('user_id', $getUser->user_id)->where('state', 1)->paginate(6);
                }
            } elseif ($user->roles->id === 2) {
                $productos = ProductoImagen::with('producto')->groupBy('producto_id')->paginate(6);
                if(count($productos) === 0) {
                    $productos = Producto::paginate(6);
                }
            }
        }
        return view('productos.index', compact('name', 'icon', 'productos', 'categories', 'producto_category', 'productos_imagen'));
    }

    public function getProductoByState($state = null)
    {
        $user = \Auth::user();
        if ($user->roles->id === 2) {
            if ($state !== null) {
                $productos = ProductoImagen::whereHas('producto', function ($q) use ($state) {
                    $q->where('state', $state);
                })->with('producto')->groupBy('producto_id')->paginate(6);
                $name = 'Productos';
                $icon = 'fa fa-shopping-cart mr-1';
                $categories = Category::all();
                $producto_category = false;
                return view('productos.index', compact('name', 'icon', 'productos', 'categories', 'producto_category'));
            }
        } else {
            return redirect()->route('admin-welcm');
        }
    }

    public function getProductoBySearch($search = null)
    {
        $user = \Auth::user();
        if ($this->isFranquiciado() || $user->roles->id === 2 || $user->roles->id === 3) {
            if ($search !== null) {

                $productos = ProductoImagen::whereHas('producto', function ($q) use ($search) {
                    $q->where('producto', 'LIKE', "%$search%")->where('state', 1);
                })->with('producto')->groupBy('producto_id')->paginate(6);
                $name = 'Productos';
                $icon = 'fa fa-shopping-cart mr-1';
                $categories = Category::all();
                $producto_category = false;
                return view('productos.index', compact('name', 'icon', 'productos', 'categories', 'producto_category'));
            }
        } else {
            return redirect()->route('all.productos');
        }
    }

    public function create()
    {
        $user = \Auth::user();
        $name = 'Productos';
        $sub = 'Crear';
        $icon = 'fa fa-shopping-cart mr-1';
        if ($user->roles->id === 7) {
            $tiendas = Tienda::where('user_id', $user->id)->where('state', 1)->get();
        } elseif ($user->roles->id === 3) {
            $tiendas = UserStore::where('user_id', $user->id)->whereHas('tienda', function ($q) {
                $q->where('state', 1);
            })->get();
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
        $producto = ProductoImagen::whereHas('producto', function ($q) use ($id) {
            $q->where('id', $id)->where('state', 1);
        })->with('producto')->get();
        $adicionales = Adicional::where('producto_id', $id)->get();
        $product_quantity = ProductQuantity::where('producto_id', $id)->get();
        $riide = false;
        if ($user->roles->id === 7) {
            $tiendas = Tienda::where('user_id', $user->id)->where('state', 1)->get();
        } elseif ($user->roles->id === 3) {
            $tiendas = UserStore::where('user_id', $user->id)->whereHas('tienda', function ($q) {
                $q->where('state', 1);
            })->get();
            if (count($tiendas) === 0) {
                return redirect()->route('all.productos');
            }
        } elseif ($user->roles->id === 2) {
            $riide = true;
            $tiendas = Tienda::all();
        }
        return view('productos.edit', compact('name', 'sub', 'icon', 'categories', 'producto', 'tiendas', 'adicionales', 'product_quantity', 'riide'));
    }

    public function editImageProd($id, Request $request)
    {
        $new_image = $request->file('new_image' . $id);
        $producto = ProductoImagen::where('id', $id)->first();
        if ($new_image) {
            $file_name = $new_image->getClientOriginalName();
            Storage::disk('productos')->put($file_name, File::get($new_image));
            $producto->imagen = $file_name;
            $producto->update();
        }
        return redirect()->route('edit.producto', ['id' => $producto->producto_id]);
    }

    public function eliminaImagenProd($id){
        $producto = ProductoImagen::where('id', $id)->first();
        $pr = Producto::where('id', $producto->producto_id)->first();
        ProductoImagen::where('id', $id)->delete();
        return redirect()->route('edit.producto', ['id' => $pr->id]);
    }

    public function editProducto($id, Request $request)
    {
        //dd($request->input("adicionales"));
        // dd($request->all());
        $producto = Producto::where('id', $id)->where('state', 1)->first();
        $imagen = $request->file('imagen');
        $user = \Auth::user();
        if ($user->roles->id === 2) {
            $producto->state = $request->input('state');
            $producto->update();
            return redirect()->route('all.productos');
        } else {
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

            if ($request->input("categorias") != null) {
                CategoriaProducto::where("producto_id", $producto->id)->delete();
                foreach ($request->input("categorias") as $c) {
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
    }

    public function store(Request $request)
    {
        $image_path = $request->file('imagen');
        $user_auth = \Auth::user();
        $user = User::find($user_auth->id);

        $producto = Producto::create([
            'producto' => $request->input('producto'),
            'descripcion' => $request->input('descripcion'),
            'precio_a' => $request->input('precio_a'),
            'precio_b' => $request->input('precio_b'),
            'state' => 1,
            'user_id' => $user->user_id
        ]);

        if ($image_path) {
            foreach ($image_path as $key =>  $imagen) {
                $file_name = $imagen->getClientOriginalName();
                Storage::disk('productos')->put($file_name, File::get($imagen));
                ProductoImagen::create([
                    'producto_id' => $producto->id,
                    'imagen' => $file_name,
                    'orden' => $key
                ]);
            }
        } else {
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

            Producto::where('id', $id)->where('state', 1)->delete();
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
