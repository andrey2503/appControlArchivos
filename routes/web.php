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
Auth::routes();

  Route::get('/out', 'Auth\AuthController@getLogout');
//rutas accessibles slo si el usuario no se ha logueado
  Route::group(['middleware' => 'guest'], function () {
  Route::get('/', 'Auth\AuthController@getLogin');
  Route::get('/instalacion', 'Auth\AuthController@instalacion');
  Route::post('login', ['as' =>'login', 'uses' => 'Auth\AuthController@postLogin']);
});
//rutas accessibles solo si el usuario administrador de usuarios y ha ingresado al sistema
Route::group(['middleware' => ['auth','administrador'],'prefix'=>'admin'], function () {
    Route::get('/','Administradores@index');
    Route::get('/nuevoUsuario','Administradores@nuevoUsuario');
    Route::post('/nuevoUsuario','Administradores@store');
    Route::get('/modificarUsuario/{id}','Administradores@edit');
    Route::post('/modificarUsuario','Administradores@update');
    Route::post('/actualizarContrasena','Administradores@actualizarContrasena');
    Route::post('/actualizarDatos','Administradores@actualizarDatos');
    Route::get('/formActualizarContrasena','Administradores@formActualizarContrasena');
    Route::get('/formActualizarDatos','Administradores@formActualizarDatos');
});
 //rutas accessibles solo si el usuario jefatura de usuarios y ha ingresado al sistema
  Route::group(['middleware' => ['auth','jefatura'],'prefix'=>'jefat'], function () {
    Route::get('/','Jefaturas@listaDistritos');
    Route::get('/nuevoExpediente','Jefaturas@vistaCrearExpediente');
    Route::post('/nuevoExpediente','Jefaturas@nuevoExpediente');
    Route::get('/listaExpedientes','Jefaturas@expedientes');
    Route::get('/verExpediente/{id}','Jefaturas@detalleExpediente');
    Route::get('/expedientes/{id}','Jefaturas@listaExpedientes');
    Route::get('/verArchivos/{id}/{expediente}','Jefaturas@verArchivos');
    Route::post('/subirArchivo','Jefaturas@subirArchivo');
    Route::post('/subirClausura','Jefaturas@subirClausura');
    Route::post('/tipoDocumento','Jefaturas@tipoDocumento');
    Route::get('/administrarDistritos','Jefaturas@administrarDistritos');
    Route::post('/administrarDistritos','Jefaturas@asignarDistritos');
    Route::get('/buscar','Jefaturas@buscar');
    Route::post('/buscar','Jefaturas@buscarFiltrado');
    Route::post('/actualizarContrasena','Jefaturas@actualizarContrasena');
    Route::post('/actualizarDatos','Jefaturas@actualizarDatos');
    Route::get('/formActualizarContrasena','Jefaturas@formActualizarContrasena');
    Route::get('/formActualizarDatos','Jefaturas@formActualizarDatos');
    Route::get('/descargarArchivo','Jefaturas@descargarArchivo');
    Route::get('/verNotificaciones/{id}','Jefaturas@lista_clausuras_notificaciones');
    Route::get('/verArchivo/{id}','Jefaturas@verArchivo');
    Route::get('/misExpedientes','Jefaturas@misExpedientes');
    Route::post('/eliminar','Jefaturas@eliminarArchivo');
    Route::get('/reportes','Jefaturas@getVistaReportes');
    Route::get('/reporte/{id}','Jefaturas@reporte');
    });
  //rutas accessibles solo si el usuario inspector de usuarios y ha ingresado al sistema
  Route::group(['middleware' => ['auth','inspector'],'prefix'=>'inspec'], function () {
    Route::get('/','Inspectores@listaDistritos');
    Route::get('/expedientes/{id}','Inspectores@listaExpedientes');
    Route::get('/verExpediente/{id}','Inspectores@detalleExpediente');
    Route::get('/verArchivos/{id}/{expediente}','Inspectores@verArchivos');
    Route::post('/subirArchivo','Inspectores@subirArchivo');
    Route::post('/subirClausura','Inspectores@subirClausura');
    Route::post('/tipoDocumento','Inspectores@tipoDocumento');
    Route::get('/nuevoExpediente','Inspectores@vistaCrearExpediente');
    Route::post('/nuevoExpediente','Inspectores@nuevoExpediente');
    Route::get('/listaExpedientes','Inspectores@expedientes');
    Route::get('/buscar','Inspectores@buscar');
    Route::post('/buscar','Inspectores@buscarFiltrado');
    Route::get('/descargarArchivo','Inspectores@descargarArchivo');
    Route::get('/verArchivo/{id}','Inspectores@verArchivo');
    Route::get('/verNotificaciones/{id}','Inspectores@lista_clausuras_notificaciones');
    Route::get('/misExpedientes','Inspectores@misExpedientes');
    Route::post('/eliminar','Jefaturas@eliminarArchivo');
    Route::get('/reportes','Inspectores@getVistaReportes');
    Route::get('/reporte/{id}','Inspectores@reporte');
    Route::post('/actualizarDatos','Inspectores@actualizarDatos');
    Route::post('/actualizarContrasena','Inspectores@actualizarContrasena');
    Route::get('/formActualizarContrasena','Inspectores@formActualizarContrasena');
    Route::get('/formActualizarDatos','Inspectores@formActualizarDatos');

    }); 
     //rutas accessibles solo si el usuario publico de usuarios y ha ingresado al sistema
  Route::group(['middleware' => ['auth','publico'],'prefix'=>'public'], function () {
    Route::get('/','Publico@listaDistritos');
    Route::get('/expedientes/{id}','Publico@listaExpedientes');
    Route::get('/listaExpedientes','Publico@expedientes');
    Route::get('/verExpediente/{id}','Publico@detalleExpediente');
    Route::get('/verArchivos/{id}/{expediente}','Publico@verArchivos');
    Route::get('/buscar','Publico@buscar');
    Route::post('/buscar','Publico@buscarFiltrado');
    Route::get('/descargarArchivo','Publico@descargarArchivo');
    Route::get('/verArchivo','Publico@verArchivo');
    Route::get('/descargarArchivo','Publico@descargarArchivo');
    Route::get('/verArchivo/{id}','Publico@verArchivo');
    Route::post('/actualizarDatos','Publico@actualizarDatos');
    Route::post('/actualizarContrasena','Publico@actualizarContrasena');
    Route::get('/formActualizarContrasena','Publico@formActualizarContrasena');
    Route::get('/formActualizarDatos','Publico@formActualizarDatos');
    });


    