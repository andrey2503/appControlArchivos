<?php

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
//     return view('login');
// });

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
  Route::get('/out', 'Auth\AuthController@getLogout');

  //rutas accessibles slo si el usuario no se ha logueado



  // Route::get('/home', 'Administradores@index');
//rutas accessibles slo si el usuario no se ha logueado
  Route::group(['middleware' => 'guest'], function () {
  Route::get('/', 'Auth\AuthController@getLogin');
  Route::post('login', ['as' =>'login', 'uses' => 'Auth\AuthController@postLogin']);
});


//rutas accessibles solo si el usuario administrador de usuarios y ha ingresado al sistema
Route::group(['middleware' => ['auth','administrador'],'prefix'=>'admin'], function () {
  // Route::get('/home','Administradores@index');
  Route::get('/','Administradores@index');
  Route::get('/nuevoUsuario','Administradores@nuevoUsuario');
  Route::post('/nuevoUsuario','Administradores@store');
  Route::get('/modificarUsuario/{id}','Administradores@edit');
  Route::post('/modificarUsuario','Administradores@update');
});


 //rutas accessibles solo si el usuario jefatura de usuarios y ha ingresado al sistema
  Route::group(['middleware' => ['auth','jefatura'],'prefix'=>'jefat'], function () {
    // Route::get('/home','Jefaturas@index');
    Route::get('/','Jefaturas@listaDistritos');
    Route::get('/nuevoExpediente','Jefaturas@crearExpediente');
    Route::post('/nuevoExpediente','Jefaturas@nuevoExpediente');
    Route::get('/listaExpedientes','Jefaturas@expedientes');
    Route::get('/verExpediente/{id}','Jefaturas@show');
    Route::post('/crearSubcarpeta','Jefaturas@crearSubcarpeta');
    Route::get('/expedientes/{id}','Jefaturas@listaExpedientes');
    Route::get('/verArchivos/{id}/{expediente}','Jefaturas@verArchivos');
    Route::post('/subirArchivo','Jefaturas@subirArchivo');

    });




 

  //rutas accessibles solo si el usuario inspector de usuarios y ha ingresado al sistema
  Route::group(['middleware' => ['auth','inspector'],'prefix'=>'inspec'], function () {
    // Route::get('/home','Inspectores@index');
    Route::get('/','Inspectores@index');
    });
