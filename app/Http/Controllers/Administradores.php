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
        $usuarios= User::all()->where('id','!=',\Auth::user()->id)->all();
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
            'email'=>'required|unique:users',
            'user'=>'required|unique:users',
            'idrol'=>'required',
            'contrasena'=>'required',
            'estado'=>'required',
            ]);

         $user = new User();
        $user->name=$request->nombre;
        $user->email = $request->email;
        $user->user = $request->user;
        $user->idrol = $request->idrol;
        $contrasena=$request->contrasena;
        $user->password = Hash::make($contrasena);
        $user->state=$request->estado;
      if($user->save()){
            return redirect()->back()->with('message','Usuario '.$request->user.' creado correctamente');
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
    }// fin de update

    /**
     * Muestra un formulario para actualizar la contraseña del usuario
     * @return view
     */
    public function formActualizarContrasena(){
        return view('administrador.actualizarContraseña');
    }// fin de formActualizarContrasena
    /**
     * Muestra un formulario para actualizar los datos del usuario
     * @return view
     */
    public function formActualizarDatos(){
        $usuario = User::find(\Auth::user()->id);
        return view('administrador.actualizarDatos')->with(['usuario'=>$usuario]);
    }// fin de formActualizarContrasena
    /**
     * Actualiza la contraseña de un usuario verificando su contraseña
     * actual y confirmando la nueva contraseña
     * @param Request $request 
     * @return view
     */
    public function actualizarContrasena(Request $request){
        $this->validate($request,[
            'contraseñaActual'=>'required',
            'contraseñaNueva'=>'required',
            'contraseñaConfirmar'=>'required|same:contraseñaNueva'
            ]);
        $user= User::find(\Auth::user()->id);
        if(!Hash::check($request->contraseñaActual, $user->password)){
          return back()->withErrors(['errorContrasena'=>'Contraseña no coincide']);
            }else{               
                $user->password=Hash::make($request->contraseñaNueva);
                if($user->save()){
                return redirect()->back()->with('message', 'Contraseña actualizada correctamente');
                }else{
                  return back()->withErrors(['errorContrasena'=>'Contraseña no coincide']);
                }
            }
    }// fin de actualizarContrasena
    /**
     * Metodo recibe los datos para actualizar el nombre y el correo del usuario
     * @param Request $request 
     * @return type
     */
    public function actualizarDatos(Request $request){
         $this->validate($request,[
            'name'=>'required',
            'email'=>'required',
            ]);
        $user= User::find(\Auth::user()->id);
        if($request->email==$user->email){
            $user->name=$request->name;
            $user->save();
        }else{
            $this->validate($request,[
            'email'=>'unique:users',
            ]);
            $user->name=$request->name;
            $user->email=$request->email;
            $user->save();
        }
        return redirect()->back()->with('message', 'Datos actualizados correctamente');
    }// fin de actualizarDatos
}
