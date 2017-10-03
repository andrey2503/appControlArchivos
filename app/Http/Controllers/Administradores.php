<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\User;
class Administradores extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $usuarios= User::all();
        return view('administrador.index')->with(['usuarios'=>$usuarios]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function nuevoUsuario(){
        return view("administrador.nuevoUsuario");
    }

    /**
     * Store a newly created resource in storage.
     *
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
            return redirect('/');
        }else{
            return redirect('/');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario= User::find($id);
        return view("administrador.modificarUsuarios")->with(['editar'=>true,'usuario'=>$usuario]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
         //
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
        // $user->user = $request->usuario;
        $user->idrol = $request->idrol;
        if($user->password!=$request->contrasena){
            $contrasena=$request->contrasena;
            $user->password = Hash::make($contrasena);    
        }
        $user->state=$request->estado;

        if($user->save()){
            return redirect('/');
        }else{
            return redirect('/');
        }
        // dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
