<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expediente;
use Carbon\Carbon;
use App\Notificacion;
use App\Distrito;
use App\SubExpediente;
use App\tipo_documento;

class Jefaturas extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('jefatura.nuevoExpediente');
    }

    public function crearExpediente(){
        $distritos= Distrito::all();
        return view('jefatura.nuevoExpediente')->with(['distritos'=>$distritos]);
    }

    public function listaDistritos(){
        $distritos= Distrito::all();
        return view('jefatura.distritos')->with(['distritos'=>$distritos]);
    }// fin de listaDIstritos
     
    public function create()
    {
        //
    }

    public function expedientes()
    {
        $expedientes= Expediente::all();
        return view('jefatura.listaExpedientes')->with(['expedientes'=>$expedientes]);

    }// listaExpedientes

    public function listaExpedientes($id)
    {
        $expedientes=Expediente::all()->where('distrito_id', '=', $id)->all();
        return view('jefatura.listaExpedientes')->with(['expedientes'=>$expedientes]);

    }// listaExpedientes

    public function store(Request $request)
    {
        //
    }

    public function nuevoExpediente(Request $request)
    {
        $this->validate($request,[
            'expediente'=>'required',
            'distrito'=>'required',]);
        
        $expediente = new Expediente();
        $expediente->finca = $request->expediente;
        $expediente->estado=1;
        $expediente->distrito_id=$request->distrito;
        $idUsuario=\Auth::user()->id;
        $expediente->user_id=$idUsuario;
        if($expediente->save()){
            return redirect('/');
        }else{
             return redirect('/');
        }
    }// fin de nuevoExpediente

    public function show($id)
    {
        //
        $subcarpetas= SubExpediente::all();
        $expediente=Expediente::where('finca', '=', $id)->first();
        return view('jefatura.detalleExpediente')
                ->with(['expediente'=>$expediente,
            'subcarpetas'=>$subcarpetas]);
    }// fin de show

    public function crearSubcarpeta(Request $request){
            
            $this->validate($request,[
            'carpeta'=>'required',]);

            $subcarpeta =new SubExpediente();
            $subcarpeta->carpeta=$request->carpeta;
            $subcarpeta->save();
            if($request->ajax()){
              $lastId =  SubExpediente::orderBy('created_at', 'desc')->first();
                return response()->json([
                    'id'=>$lastId->id,
                    'carpeta'=> $request->carpeta,
                    ]);
            }else{
                return "Error de respuesta";
            }//

        
    }//fin de solicitar inspeccion

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function verArchivos($id,$expediente){
        $tipo_documento= tipo_documento::all();
        return view('jefatura.listadoArchivosSubCarpeta')
                    ->with(['tipo_documento'=>$tipo_documento]);
    }// fin de verArchivos

    public function subirArchivo(Request $request){
        // dd($request);
        return back();
    }// fin de subir archivo

}
