<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', function () {
//     return view('layout.app');
// });

Auth::routes();

Route::prefix('admin')->group(function () {
    Route::get('/login','UserController@loginAdmin')->name('login.admin');
    Route::get('/welcome','UserController@welcomeAdmin')->name('admin-welcm');

    //usuarios
    Route::get('/crear-usuario', 'UserController@getRegisterView')->name('user.register');
    Route::post('/register-user', 'UserController@registerUsers')->name('user.newr');
    Route::get('/usuarios', 'UserController@allUsers')->name('all.users');
    Route::get('/get-image/{image}', 'UserController@getImage')->name('my.image');
    Route::get('/edit-user/{id}', 'UserController@getUserForEdit')->name('edit.user');
    Route::post('/edit-asociado/{id}','UserController@editUser')->name('edit.asoc');
    Route::get('/delete-user/{id}','UserController@deleteUser')->name('delete.user');
    
    //tiendas
    Route::get('/tiendas','TiendaController@index')->name('all.tiendas');
    Route::get('/create-tienda','TiendaController@createTienda')->name('create.tienda');
    Route::post('/save-store','TiendaController@save')->name('save.tienda');
    Route::get('/get-panel/{panel}', 'TiendaController@getPanel')->name('my.panel');
    Route::get('/get-imagen/{imagen}', 'TiendaController@getImagen')->name('my.imagen.tienda');
    Route::post('/edita-tienda', 'TiendaController@editaTienda')->name('edita.tiendas');
    Route::get('/delete-tienda/{id}', 'TiendaController@deleteTienda')->name('delete.tienda');
    Route::get('/tienda/{id}', 'TiendaController@getTiendaForEdit')->name('tienda.update');
    Route::post('/update-tienda/{id}', 'TiendaController@updateTienda')->name('update.store');

    //productos
    Route::get('/productos','ProductoController@index')->name('all.productos');
    Route::get('/create-producto','ProductoController@create')->name('create.producto');
    Route::get('/edit-producto/{id}', 'ProductoController@edit')->name('edit.producto');
    Route::post('/store-product', 'ProductoController@store')->name('save.producto');
    Route::get('/image-prod/{imagen}', 'ProductoController@getImagenProd')->name('imagen.prod');
    Route::get('/delete-producto/{id}', 'ProductoController@deleteProduct')->name('delete.prod');
    Route::post('/update-producto/{id}', 'ProductoController@editProducto')->name('update.producto');

    //banners
    Route::get('/banners','BannerController@index')->name('all.banners');

    //horarios
    Route::get('/horarios', 'HorarioController@index')->name('horarios');
    Route::post('/create-horarios','HorarioController@create')->name('create.horario');

    //cuenta
    Route::get('/estado-cuenta','CuentaController@index')->name('cuentas');
});
