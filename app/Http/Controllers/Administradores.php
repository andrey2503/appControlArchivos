<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\User;
class Administradores extends Controller
{
    /**
     * Muentra una vista con todos los usuarios del sistema.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios= User::all();
        return view('administrador.index')->with(['usuarios'=>$usuarios]);
    }
    /**
     * Muestra un formulario para la creacion de nuevos usuarios
     * @return retorna una vista
     */
    public function nuevoUsuario(){
        return view("administrador.nuevoUsuario");
    }
    /**
     * Valida los datos enviados desde el formulario de nuevos usuarios y crear un nuevo usuario en el sistema
     * y devuelve la vista con un mensaje de usuario creado existosamente.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'nombre'=>'required',
            'mail'=>'required',
            'usuario'=>'required',
            'idrol'=>'required',
            'contrasena'=>'required',
            'estado'=>'required',
            ]);

         $user = new User();
        $user->name=$request->nombre;
        $user->email = $request->mail;
        $user->user = $request->usuario;
        $user->idrol = $request->idrol;
        $contrasena=$request->contrasena;
        $user->password = Hash::make($contrasena);
        $user->state=$request->estado;
      if($user->save()){
            return redirect()->back()->with('message','Usuario '.$request->usuario.' creado correctamente');
        }else{
            back()->withErrors(['errorUsuario'=>'Error al crear usuario']);
        }
    }
    /**
     * Muestra un formulario para editar un usuario en especifico
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario= User::find($id);
        return view("administrador.modificarUsuarios")->with(['editar'=>true,'usuario'=>$usuario]);
    }

    /**
     * Actualiza los datos de un usuario especifico
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'nombre'=>'required',
            'mail'=>'required',
            'idrol'=>'required',
            'contrasena'=>'required',
            'estado'=>'required',
            ]);
        $user = User::find($request->id);
        $user->name=$request->nombre;
        $user->email = $request->mail;
        $user->idrol = $request->idrol;
        if($user->password!=$request->contrasena){
            $contrasena=$request->contrasena;
            $user->password = Hash::make($contrasena);    
        }
        $user->state=$request->estado;

        if($user->save()){
            return redirect()->back()->with('message','Usuario '.$request->usuario.' actualizado correctamente');
        }else{
            return redirect('/');
        }
        // dd($request);
    }
}
