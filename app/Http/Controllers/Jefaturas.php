<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expediente;
use Carbon\Carbon;
use App\Notificacion;
use App\Distrito;
use App\SubExpediente;
use App\tipo_documento;
use App\archivos_expediente;
use App\User;
use App\Distribucion_distritos;
use Hash;
use Storage;
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

    public function vistaCrearExpediente(){
        $distritos= Distrito::all();
        return view('jefatura.nuevoExpediente')->with(['distritos'=>$distritos]);
    }

    public function listaDistritos(){
        $distritos= Distrito::all();
        return view('jefatura.distritos')->with(['distritos'=>$distritos]);
    }// fin de listaDIstritos
     
    public function expedientes()
    {
        $expedientes= Expediente::all();
        return view('jefatura.listaExpedientes')->with(['expedientes'=>$expedientes]);

    }// Expedientes

    public function listaExpedientes($id)
    {
        $expedientes=Expediente::all()->where('distrito_id', '=', $id)->all();
        return view('jefatura.listaExpedientes')->with(['expedientes'=>$expedientes]);

    }// listaExpedientes

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

    public function detalleExpediente($id)
    {
        //
        $subcarpetas= SubExpediente::all();
        $expediente=Expediente::where('finca', '=', $id)->first();
        return view('jefatura.detalleExpediente')
                ->with(['expediente'=>$expediente,
            'subcarpetas'=>$subcarpetas]);
    }// fin de detalleExpediente

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
                    'expediente'=>$request->expediente,
                    ]);
            }else{
                return "Error de respuesta";
            }//

        
    }//fin de crearSubcarpeta

    public function verArchivos($id,$expediente){
        if($id!=2){
        $archivos=archivos_expediente::all()->where('carpeta_id', '=', $id)->where('idFinca','=',$expediente)->all();
        $editar=false;
        $expedienteID=Expediente::where('finca', '=', $expediente)->first();
        $permisos=Distribucion_distritos::where('id_distrito ','=', $expedienteID->distrito_id,' and ')->where('id_usuario','=', \Auth::user()->id)->first();
        if($permisos!=null){
            $editar=true;
        }

        $tipo_documento= tipo_documento::all();
        return view('jefatura.listadoArchivosSubCarpeta')
                    ->with(['tipo_documento'=>$tipo_documento,
                        'carpeta'=>$id,
                        'expediente'=>$expediente,
                        'archivos'=>$archivos,
                        'permiso'=>$editar]);
        }else{
            $editar=false;
            $expedienteID=Expediente::where('finca', '=', $expediente)->first();
            $permisos=Distribucion_distritos::where('id_distrito ','=', $expedienteID->distrito_id,' and ')->where('id_usuario','=', \Auth::user()->id)->first();
            if($permisos!=null){
                $editar=true;
            }
            return view('jefatura.archivosClausurasNotificaciones')->with([
                'permiso'=>$editar,
                'expediente'=>$expediente,
                'carpeta'=>$id]);
        }
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

    public function administrarDistritos(){
        $distritos= Distrito::all();
        $usuarios= User::all();
        $distribucion = Distribucion_distritos::all();
        return view('jefatura.administrarDistritos')
                ->with(['distritos'=>$distritos,'usuarios'=>$usuarios,'distribucion'=>$distribucion]);
    }// fin de listaDIstritos

    public function asignarDistritos(Request $request){

        foreach ($request->distrito as $num => $opcion) {
            
            $distribucion = Distribucion_distritos::where('id_distrito', '=', $opcion)->first();
            if($distribucion==null){
                // dd("null".);
                $distribucion= new Distribucion_distritos();
                $distribucion->id_distrito = $opcion;
                $distribucion->id_usuario=$request->usuario[$num];
                $distribucion->save();
                // dd("se creo nuevo registro porque no dio null");
            }else{
                $distribucion->id_distrito = $opcion;
                $distribucion->id_usuario=$request->usuario[$num];
                $distribucion->save();
                // dd("se actualizo registro no se creo");
            }
            
        }
        return back();
        
    }// fin de listaDIstritos

    public function buscar(){
        $subcarpetas= SubExpediente::all();
        return view('jefatura.buscar')->with(['subcarpetas'=>$subcarpetas]);
    }// fin de buscar

     public function buscarFiltrado(Request $request){
        // $archivosLista=archivos_expediente::all()->where('carpeta_id', '=',$request->carpeta)->toArray();
        $archivos=archivos_expediente::all()->where('carpeta_id', '=',$request->carpeta)->all();
        // $archivos=archivos_expediente::all()->toArray();
        return json_encode($archivos);
    }// fin buscarFiltrado

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
        return view('jefatura.actualizarContraseña');
    }// fin de formActualizarContrasena
}
