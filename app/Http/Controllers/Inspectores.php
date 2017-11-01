<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Distrito;
use App\Expediente;
use App\SubExpediente;
use App\archivos_expediente;
use App\Distribucion_distritos;
use App\tipo_documento;
use App\User;
use Hash;
use Storage;
class Inspectores extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //    public function index()
      return view('inspector.index');
    }

    public function listaDistritos(){
        $distritos= Distrito::all();
        return view('inspector.distritos')->with(['distritos'=>$distritos]);
    }// fin de listaDIstritos

    public function listaExpedientes($id)
    {
        $expedientes=Expediente::all()->where('distrito_id', '=', $id)->all();
        return view('inspector.listaExpedientes')->with(['expedientes'=>$expedientes]);

    }// listaExpedientes

    public function detalleExpediente($id)
    {
        //
        $subcarpetas= SubExpediente::all();
        $expediente=Expediente::where('finca', '=', $id)->first();
        return view('inspector.detalleExpediente')
                ->with(['expediente'=>$expediente,
            'subcarpetas'=>$subcarpetas]);
    }// fin de detalleExpediente

    public function verArchivos($id,$expediente){
        $archivos=archivos_expediente::all()->where('carpeta_id', '=', $id)->where('idFinca','=',$expediente)->all();
        $editar=false;
        $expedienteID=Expediente::where('finca', '=', $expediente)->first();
        $permisos=Distribucion_distritos::where('id_distrito ','=', $expedienteID->distrito_id,' and ')->where('id_usuario','=', \Auth::user()->id)->first();
        if($permisos!=null){
            $editar=true;
        }

        $tipo_documento= tipo_documento::all();
        return view('inspector.listadoArchivosSubCarpeta')
                    ->with(['tipo_documento'=>$tipo_documento,
                        'carpeta'=>$id,
                        'expediente'=>$expediente,
                        'archivos'=>$archivos,
                        'permiso'=>$editar,
                        'distrito'=>$expedienteID->distrito_id]);
    }// fin de verArchivos

     public function subirArchivo(Request $request){
        $this->validate($request,[
            'archivo'=>'required|mimes:jpeg,bmp,png,pdf',
            'tipo'=>'required',
            'id'=>'required',
            'expediente'=>'required'
            ]);
        // dd($request);
        // $request->file('archivo')->store('public');
        $archivo= $request->file('archivo');
        $ruta_archivo= time().'_'.$archivo->getClientOriginalName();

        $archivo_expediente = new archivos_expediente();
        $archivo_expediente->carpeta_id = $request->id;
        $archivo_expediente->idFinca= $request->expediente;
        $archivo_expediente->ruta_archivo=$ruta_archivo;
        $archivo_expediente->tipo_id= $request->tipo;
        
        Storage::disk('public')->put($ruta_archivo,
            file_get_contents($archivo->getRealPath()));
        // dd($archivo_expediente);
        $archivo_expediente->save();
        return back();
    }// fin de subir archivo

     public function tipoDocumento(Request $request){

        $this->validate($request,[
            'id'=>'required',
            'tipo'=>'required',
            ]);

        $nuevo_tipo= new tipo_documento();
        $nuevo_tipo->tipo=$request->tipo;
        $nuevo_tipo->carpeta_id= $request->id;
        if($nuevo_tipo->save()){
            if($request->ajax()){
                    $lastId =  tipo_documento::orderBy('created_at', 'desc')->first();
                    return response()->json([
                    'id'=>$lastId->id,
                    'tipo'=> $request->tipo,
                    ]);
            }else{
                return "Error de respuesta";
            }//
        }
    }// fin de public function tipoDocumento(Request $request)

    public function vistaCrearExpediente(){
        $distritos= Distrito::all();
        return view('inspector.nuevoExpediente')->with(['distritos'=>$distritos]);
    }//fin de vistaCrearExpediente

    public function nuevoExpediente(Request $request)
    {
        $this->validate($request,[
            'expediente'=>'required|min:6',
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

     public function expedientes()
    {
        $expedientes= Expediente::all();
        return view('inspector.listaExpedientes')->with(['expedientes'=>$expedientes]);

    }// Expedientes

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

    public function formActualizarContrasena(){
        return view('inspector.actualizarContraseña');
    }// fin de formActualizarContrasena

    public function buscar(){
        $subcarpetas= SubExpediente::all();
        return view('inspector.buscar')->with(['subcarpetas'=>$subcarpetas]);
    }// fin de buscar

    public function buscarFiltrado(Request $request){
        $archivos=archivos_expediente::all()->where('carpeta_id', '=',$request->carpeta)->all();
        return json_encode($archivos);
    }// fin buscarFiltrado
}// fin de la clase
