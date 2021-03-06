<?php

namespace App\Http\Controllers;

use App\Models\CategoriaStore;
use Illuminate\Http\Request;
use App\Models\Category;
use App\User;
use App\Models\UserStore;
use App\Models\Tienda;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TiendaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = \Auth::user();
        if ($user->roles->id === 7) {
            $tiendas = Tienda::where('user_id', $user->id)->orderByDesc('id')->get();
        } elseif ($user->roles->id == 3) {
            $tiendas = UserStore::where('user_id', $user->id)->orderByDesc('id')->get();
        }
        $name = 'Tiendas';
        $icon = 'fa fa-store mr-1';
        return view('tiendas.index', compact('name', 'icon', 'tiendas'));
    }

    public function createTienda()
    {
        if ($this->isFranquiciado()) {
            $franquiciado = \Auth::user();
            $name = 'Tiendas';
            $sub = 'Crear';
            $icon = 'fa fa-store mr-1';
            $categories = Category::all();
            if ($franquiciado->roles->id === 7) {
                $tiendas = Tienda::where('user_id', $franquiciado->id)->limit(1)->get();
            } elseif ($franquiciado->roles->id == 3) {
                $tiendas = UserStore::where('user_id', $franquiciado->id)->get();
            }
            $users = User::where('user_id', $franquiciado->id)->get();
            return view('tiendas.create', compact('name', 'sub', 'icon', 'categories', 'users', 'tiendas'));
        } else {
            return redirect()->route('all.tiendas');
        }
    }

    public function save(Request $request)
    {
        if ($this->isFranquiciado()) {
            $user = \Auth::user();
            $panel_path = $request->file('panel');
            $imagen_path = $request->file('imagen');

            if ($panel_path && $imagen_path) {
                $panel_name = time() . $panel_path->getClientOriginalName();
                Storage::disk('tiendas')->put($panel_name, File::get($panel_path));

                $imagen_name = time() . $imagen_path->getClientOriginalName();
                Storage::disk('tiendas')->put($imagen_name, File::get($imagen_path));

                $tienda = Tienda::create([
                    'tienda' => $request->input('tienda'),
                    'sector' => $request->input('sector'),
                    'tiempo' => $request->input('tiempo'),
                    'user_id' => $user->id,
                    'owner_id' => null,
                    'panel' => $panel_name,
                    'imagen' => $imagen_name
                ]);
            } elseif ($imagen_path) {

                $imagen_name = time() . $imagen_path->getClientOriginalName();
                Storage::disk('tiendas')->put($imagen_name, File::get($imagen_path));

                $panel_tienda = Tienda::where('user_id', $user->id)->limit(1)->get();
                foreach ($panel_tienda as $panel) {
                    $store = $panel;
                }
                $tienda = Tienda::create([
                    'tienda' => $request->input('tienda'),
                    'sector' => $request->input('sector'),
                    'tiempo' => $request->input('tiempo'),
                    'user_id' => $user->id,
                    'owner_id' => null,
                    'panel' => $store->panel,
                    'imagen' => $imagen_name
                ]);
            } elseif ($panel_path) {
                $panel_name = time() . $panel_path->getClientOriginalName();
                Storage::disk('tiendas')->put($panel_name, File::get($panel_path));

                $panel_tienda = Tienda::where('user_id', $user->id)->limit(1)->get();
                foreach ($panel_tienda as $panel) {
                    $store = $panel;
                }
                $tienda = Tienda::create([
                    'tienda' => $request->input('tienda'),
                    'sector' => $request->input('sector'),
                    'tiempo' => $request->input('tiempo'),
                    'user_id' => $user->id,
                    'owner_id' => null,
                    'panel' => $panel_name,
                    'imagen' => $store->imagen
                ]);
            }

            if (!$panel_path && !$imagen_path) {
                $panel_tienda = Tienda::where('user_id', $user->id)->limit(1)->get();
                foreach ($panel_tienda as $panel) {
                    $store = $panel;
                }
                $tienda = Tienda::create([
                    'tienda' => $request->input('tienda'),
                    'sector' => $request->input('sector'),
                    'tiempo' => $request->input('tiempo'),
                    'user_id' => $user->id,
                    'owner_id' => null,
                    'panel' => $store->panel,
                    'imagen' => $store->imagen
                ]);
            }

            foreach ($request->input('categoria_id') as $categoria) {
                CategoriaStore::create([
                    'tienda_id' => $tienda->id,
                    'categoria_id' => $categoria
                ]);
            }
            foreach ($request->input('user_id') as $user) {
                UserStore::create([
                    'tienda_id' => $tienda->id,
                    'user_id' => $user,
                    'type' => 0
                ]);
            }

            return redirect()->route('all.tiendas');
        } else {
            return redirect()->route('all.tiendas');
        }
    }

    public function getTiendaForEdit($id)
    {
        $user = \Auth::user();
        $name = 'Tiendas';
        $sub = 'Editar';
        $icon = 'fa fa-store mr-1';
        $categories = Category::all();
        $tienda = Tienda::find($id);
        $users = User::where('user_id', $user->user_id)->get();
        return view('tiendas.edit', compact('name', 'sub', 'icon', 'categories', 'users', 'tienda'));
    }

    public function updateTienda($id, Request $request)
    {
        $panel_path = $request->file('panel');
        $imagen_path = $request->file('imagen');
        $panel_tienda = Tienda::find($id);

        if ($panel_path && $imagen_path) {
            $panel_name = time() . $panel_path->getClientOriginalName();
            Storage::disk('tiendas')->put($panel_name, File::get($panel_path));

            $imagen_name = time() . $imagen_path->getClientOriginalName();
            Storage::disk('tiendas')->put($imagen_name, File::get($imagen_path));

            Tienda::where('id', $id)->update([
                'tienda' => $request->input('tienda'),
                'sector' => $request->input('sector'),
                'tiempo' => $request->input('tiempo'),
                'panel' => $panel_name,
                'imagen' => $imagen_name
            ]);
        } elseif ($imagen_path) {

            $imagen_name = time() . $imagen_path->getClientOriginalName();
            Storage::disk('tiendas')->put($imagen_name, File::get($imagen_path));

            Tienda::where('id', $id)->update([
                'tienda' => $request->input('tienda'),
                'sector' => $request->input('sector'),
                'tiempo' => $request->input('tiempo'),
                'panel' => $panel_tienda->panel,
                'imagen' => $imagen_name
            ]);
        } elseif ($panel_path) {
            $panel_name = time() . $panel_path->getClientOriginalName();
            Storage::disk('tiendas')->put($panel_name, File::get($panel_path));

            Tienda::where('id', $id)->update([
                'tienda' => $request->input('tienda'),
                'sector' => $request->input('sector'),
                'tiempo' => $request->input('tiempo'),
                'panel' => $panel_name,
                'imagen' => $panel_tienda->imagen
            ]);
        }

        if (!$panel_path && !$imagen_path) {
            Tienda::where('id', $id)->update([
                'tienda' => $request->input('tienda'),
                'sector' => $request->input('sector'),
                'tiempo' => $request->input('tiempo'),
                'panel' => $panel_tienda->panel,
                'imagen' => $panel_tienda->imagen
            ]);
        }

        if ($request->input('categoria_id') !== null) {
            CategoriaStore::where('tienda_id', $id)->delete();
            foreach ($request->input('categoria_id') as $categoria) {
                CategoriaStore::create([
                    'tienda_id' => $panel_tienda->id,
                    'categoria_id' => $categoria
                ]);
            }
        }

        if ($request->input('user_id') !== null) {
            UserStore::where('tienda_id', $id)->delete();
        foreach ($request->input('user_id') as $user) {
            UserStore::create([
                'tienda_id' => $panel_tienda->id,
                'user_id' => $user,
                'type' => 0
            ]);
        }
    }

        return redirect()->route('all.tiendas');
    }

    public function getPanel($panel)
    {
        $file = Storage::disk('tiendas')->get($panel);
        return new Response($file, 200);
    }

    public function getImagen($imagen)
    {
        $file = Storage::disk('tiendas')->get($imagen);
        return new Response($file, 200);
    }

    public function editaTienda(Request $request)
    {
        $user = \Auth::user();
        $panel_tienda = $request->input('panel_tienda');
        $imagen_tienda = $request->input('imagen_tienda');
        $panel_path = $request->file('panel');
        $image_path = $request->file('imagen');
        $tienda = $request->input('tienda');
        $sector = $request->input('sector');

        if ($user->roles->id == 3) {
            if ($panel_path) {
                $panel_name = time() . $panel_path->getClientOriginalName();
                Storage::disk('tiendas')->put($panel_name, File::get($panel_path));
                $tienda_asoc = UserStore::whereHas('tienda', function ($q) use ($panel_tienda) {
                    $q->where('panel', $panel_tienda);
                })->get();
                if (count($tienda_asoc) >= 1) {
                    foreach ($tienda_asoc as  $nw_as) {
                        $nw_as->tienda->panel = $panel_name;
                        $nw_as->tienda->update();
                    }
                } else {
                    $tienda_asoc = UserStore::whereHas('tienda', function ($q) use ($imagen_tienda) {
                        $q->where('imagen', $imagen_tienda);
                    })->get();

                    foreach ($tienda_asoc as  $nw_as) {
                        $nw_as->tienda->panel = $panel_name;
                        $nw_as->tienda->update();
                    }
                }
            }

            if ($image_path) {
                $imagen_name = time() . $image_path->getClientOriginalName();
                Storage::disk('tiendas')->put($imagen_name, File::get($image_path));
                $tienda_asoc = UserStore::whereHas('tienda', function ($q) use ($imagen_tienda) {
                    $q->where('imagen', $imagen_tienda);
                })->get();
                if (count($tienda_asoc) >= 1) {
                    foreach ($tienda_asoc as  $nw_as) {
                        $nw_as->tienda->imagen = $imagen_name;
                        $nw_as->tienda->update();
                    }
                } else {
                    $tienda_asoc = UserStore::whereHas('tienda', function ($q) use ($panel_tienda) {
                        $q->where('panel', $panel_tienda);
                    })->get();
                    foreach ($tienda_asoc as  $nw_as) {
                        $nw_as->tienda->imagen = $imagen_name;
                        $nw_as->tienda->update();
                    }
                }
            }

            if ($tienda !== null || $sector !== null) {
                $tienda_asoc = UserStore::whereHas('tienda', function ($q) use ($tienda, $sector) {
                    $q->where(['tienda' => $tienda, 'sector' => $sector]);
                })->get();
                if (count($tienda_asoc) >= 1) {
                    foreach ($tienda_asoc as $up_new) {
                        $up_new->tienda->tienda = $tienda;
                        $up_new->tienda->sector = $sector;
                        $up_new->tienda->update();
                    }
                } else {
                    $tienda_asoc = UserStore::whereHas('tienda', function ($q) use ($panel_tienda, $imagen_tienda) {
                        $q->where(['panel' => $panel_tienda, 'imagen' => $imagen_tienda]);
                    })->get();
                    foreach ($tienda_asoc as $up_new) {
                        $up_new->tienda->tienda = $tienda;
                        $up_new->tienda->sector = $sector;
                        $up_new->tienda->update();
                    }
                }
            }
        } else {
            $new_panel = Tienda::where('panel', $panel_tienda)->get();
            $new_imagen = Tienda::where('imagen', $imagen_tienda)->get();
            if (count($new_panel) >= 1 || count($new_imagen) >= 1) {
                if ($tienda !== null || $sector !== null) {
                    $update_tienda = Tienda::where('tienda', $tienda)
                        ->orWhere('sector', $sector)->get();
                    if (count($update_tienda) >= 1) {
                        foreach ($update_tienda as $up_new) {
                            $up_new->tienda = $tienda;
                            $up_new->sector = $sector;
                            $up_new->update();
                        }
                    } else {
                        $update_tienda = Tienda::where(['panel' => $panel_tienda, 'imagen' => $imagen_tienda])->get();
                        foreach ($update_tienda as $up_new) {
                            $up_new->tienda = $tienda;
                            $up_new->sector = $sector;
                            $up_new->update();
                        }
                    }
                } else {
                    return redirect()->route('all.tiendas');
                }

                foreach ($new_panel as $new) {
                    // dd($new);
                    if ($panel_path) {
                        $panel_name = time() . $panel_path->getClientOriginalName();
                        Storage::disk('tiendas')->put($panel_name, File::get($panel_path));
                        $new->panel = $panel_name;
                        $new->update();
                    }
                }
                foreach ($new_imagen as  $new) {
                    if ($image_path) {
                        // dd($new_imagen);
                        $imagen_name = time() . $image_path->getClientOriginalName();
                        Storage::disk('tiendas')->put($imagen_name, File::get($image_path));
                        $new->imagen = $imagen_name;
                        $new->update();
                    }
                }
            } else {
                return redirect()->route('all.tiendas');
            }
        }

        return redirect()->route('all.tiendas');
    }

    public function deleteTienda($id)
    {
        if ($this->isFranquiciado()) {
            if (isset($id)) {
                Tienda::where('id', $id)->delete();
                CategoriaStore::where('tienda_id', $id)->delete();
                UserStore::where('tienda_id', $id)->delete();
            }
        }
        return redirect()->route('all.tiendas');
    }

    private function isFranquiciado()
    {
        if (\Auth::user()->roles->id === 7) {
            return true;
        } elseif (\Auth::user()->roles->id == 3) {
            return false;
        }
    }
}
