<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['loginAdmin']]);
    }

    public function getRegisterView()
    {
        if ($this->isFranquiciado()) {
            $roles = Rol::all();
            $name = 'Usuarios';
            $sub = 'Crear';
            $icon = 'fas fa-user';
            return view('usuarios.register', compact('roles', 'name', 'sub', 'icon'));
        } else {
            return redirect()->route('admin-welcm');
        }
    }

    public function registerUsers(Request $request)
    {

        if ($this->isFranquiciado()) {

            $franquiciado_id = \Auth::user();

            $validate = $this->validate($request, [
                'name' => 'required|alpha',
                'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|unique:users',
                'password' => 'required|string',
                'role_id' => 'required',
                'avatar' => 'required|image|mimes:png,jpg,jpeg,gif'
            ]);

            $user = new User();

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->role_id = $request->input('role_id');
            $user->user_id = $franquiciado_id->id;

            $image_path = $request->file('avatar');

            if ($image_path) {
                $image_path_name = time() . $image_path->getClientOriginalName();
                Storage::disk('user')->put($image_path_name, File::get($image_path));
                $user->avatar = $image_path_name;
            }

            $user->save();

            return redirect()->route('user.register')->with('message', 'Se ha Registrado Exitosamente');
        } else {
            return redirect()->route('admin-welcm');
        }
    }

    public function allUsers()
    {
        if ($this->isFranquiciado()) {
            $users = User::all();
            $name = 'Usuarios';
            $icon = 'fas fa-user';
            return view('usuarios.all_users', compact('users', 'name', 'icon'));
        } else {
            return redirect()->route('admin-welcm');
        }
    }

    public function getImage($image)
    {
        if ($this->isFranquiciado()) {
            $file = Storage::disk('user')->get($image);
            return new Response($file, 200);
        } else {
            return redirect()->route('admin-welcm');
        }
    }

    public function getUserForEdit($id)
    {
        if ($this->isFranquiciado()) {
            $user = User::find($id);
            $name = 'Usuarios';
            $sub = 'Editar';
            $icon = 'fas fa-user';
            return view('usuarios.edit_user', compact('user', 'name', 'sub', 'icon'));
        } else {
            return redirect()->route('admin-welcm');
        }
    }

    public function editUser($id, Request $request)
    {
        if ($this->isFranquiciado()) {
            $franquiciado_id = \Auth::user();

            $validate = $this->validate($request, [
                'name' => 'required|alpha',
                'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|unique:users,email,' . $id,
                'role_id' => 'required',
                'avatar' => 'image|mimes:png,jpg,jpeg,gif'
            ]);

            $user = User::find($id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->role_id = $request->input('role_id');
            $user->user_id = $franquiciado_id->id;

            $image_path = $request->file('avatar');
            if ($image_path) {
                $filename = time() . $image_path->getClientOriginalName();
                Storage::disk('user')->put($filename, File::get($image_path));
                $user->avatar = $filename;
            }

            $user->update();
            return redirect()->route('edit.user', ['id' => $id])->with('message', 'Se ha Editado Correctamente!');
        } else {
            return redirect()->route('admin-welcm');
        }
    }

    public function deleteUser($id)
    {
        if ($this->isFranquiciado()) {
            $user_deleted = User::where('id', $id)->delete();

            if ($user_deleted) {
                return redirect()->route('all.users')->with('deleted', 'Usuario Borrado!!');
            } else {
                return redirect()->route('all.users');
            }
        } else {
            return redirect()->route('admin-welcm');
        }
    }

    public function loginAdmin()
    {
        return view('admin.login');
    }

    public function welcomeAdmin()
    {
        return view('admin.welcome');
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
