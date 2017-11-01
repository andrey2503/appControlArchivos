<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expediente;
use Carbon\Carbon;
use App\Distrito;
use App\SubExpediente;
use App\tipo_documento;
use App\archivos_expediente;
use App\User;
use App\Distribucion_distritos;
use App\Clausura_notificacion;
use Hash;
use Storage;
use Intervention\Image\Facades\Image;
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

    public function detalleExpediente($id)
    {
        //
        $subcarpetas= SubExpediente::all();
        $expediente=Expediente::find($id);
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
            $expedienteID=Expediente::find($expediente);
            $permisos=Distribucion_distritos::where('id_distrito ','=', $expedienteID->distrito_id,' and ')->where('id_usuario','=', \Auth::user()->id)->first();
            if($permisos!=null){
                $editar=true;
            }

            $tipo_documento= tipo_documento::all();
            $datosVista=['tipo_documento'=>$tipo_documento,
                            'carpeta'=>$id,
                            'expediente'=>$expediente,
                            'archivos'=>$archivos,
                            'permiso'=>$editar,
                            'distrito'=>$expedienteID->distrito_id];
            return view('jefatura.listadoArchivosSubCarpeta')
                    ->with($datosVista);

        }else{
            $archivos=archivos_expediente::all()->where('carpeta_id', '=', $id)->where('idFinca','=',$expediente)->all();
            $editar=false;
            $expedienteID=Expediente::find($expediente);
            $permisos=Distribucion_distritos::where('id_distrito ','=', $expedienteID->distrito_id,' and ')->where('id_usuario','=', \Auth::user()->id)->first();
            if($permisos!=null){
                $editar=true;
            }

            $tipo_documento= tipo_documento::all();
            $datosVista=['tipo_documento'=>$tipo_documento,
                            'carpeta'=>$id,
                            'expediente'=>$expediente,
                            'archivos'=>$archivos,
                            'permiso'=>$editar,
                            'distrito'=>$expedienteID->distrito_id];
            return view('jefatura.listadoClausuras')
                    ->with($datosVista);

        }// fin del else
        
        
       
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
        $archivo_expediente->save();
        return back();
    }// fin de subir archivo

    public function subirClausura(Request $request){
         $this->validate($request,[
                'checkbox'=>'required',
                'fecha'=>'required',
                'archivo'=>'required|mimes:jpeg,bmp,png,pdf',
                ]);
         
            $archivo= $request->file('archivo');
            $ruta_archivo= time().'_'.$archivo->getClientOriginalName();
            $tipo_documento= tipo_documento::where('carpeta_id', '=',2)->first();
            $id_tipo_documento=0;
            if($tipo_documento===null){
                $tipo_documento= new tipo_documento();
                $tipo_documento->tipo="Clausura";
                $tipo_documento->carpeta_id=2;
                $tipo_documento->save();
                $id_tipo_documento=$tipo_documento->id;
            }
            
            Storage::disk('public')->put($ruta_archivo,file_get_contents($archivo->getRealPath()));
            //si es una clausura
            if($request->checkbox==1){
                 $notificacion = Clausura_notificacion::where('idFinca','=',$request->expediente)->where('estado','=',1)->where('tipo_archivo','=',3)->first();
                    // dd($notificacion);
                    if($notificacion!=null){
                        $notificacion->estado=0;
                        $notificacion->save();
                    }

                     $clausura_notificacion= Clausura_notificacion::where('idFinca','=',$request->expediente)->where('estado','=',1)->where('tipo_archivo','=',2)->first();
                    if($clausura_notificacion!=null){
                        $clausura_notificacion->estado=0;
                        $clausura_notificacion->save();
                    }
            } else if($request->checkbox==2){
                 $clausura_notificacion= Clausura_notificacion::where('idFinca','=',$request->expediente)->where('estado','=',1)->where('tipo_archivo','=',2)->first();
                 // dd($clausura_notificacion);
                 if($clausura_notificacion==null){
                        // crear nueva clausura y cerrar toda las notificaciones
                    $notificacion = Clausura_notificacion::where('idFinca','=',$request->expediente)->where('estado','=',1)->where('tipo_archivo','=',3)->first();
                    // dd($notificacion);
                    if($notificacion!=null){
                        $notificacion->estado=0;
                        $notificacion->save();
                    }
                     $clausura_notificacion= new Clausura_notificacion();
                     $clausura_notificacion->fecha_inicio=$request->fecha;
                     $clausura_notificacion->fecha_revicion=$this->sumarMes($request->fecha);
                     $clausura_notificacion->idFinca=$request->expediente;
                     $clausura_notificacion->rutaArchivo=$ruta_archivo;
                     $clausura_notificacion->estado=1;
                     $clausura_notificacion->tipo_archivo=2;
                     $clausura_notificacion->lista=1;
                     $clausura_notificacion->save();
                 }else{
                    //poner todas las clausuras y notificacione inactivas las que se encontradon en activas
                    // poner una nueva clausura activa
                    $clausura_notificacion->estado=0;
                    $clausura_notificacion->save();
                    $clausura_notificacion= new Clausura_notificacion();
                    $clausura_notificacion->fecha_inicio=$request->fecha;
                    $clausura_notificacion->fecha_revicion=$this->sumarMes($request->fecha);
                    $clausura_notificacion->idFinca=$request->expediente;
                    $clausura_notificacion->rutaArchivo=$ruta_archivo;
                    $clausura_notificacion->estado=1;
                    $clausura_notificacion->tipo_archivo=2;
                    $clausura_notificacion->lista=1;
                    $clausura_notificacion->save();
                 }
                 // si es una notificacion
            }else if($request->checkbox==3){
                $notificacion = Clausura_notificacion::where('idFinca','=',$request->expediente)->where('estado','=',1)->where('tipo_archivo','=',3)->first();
                    $clausura_notificacion= Clausura_notificacion::where('idFinca','=',$request->expediente)->where('estado','=',1)->where('tipo_archivo','=',2)->first();
                    if($clausura_notificacion!=null){
                        $clausura_notificacion->estado=0;
                        $clausura_notificacion->save();
                    }
                    // dd($notificacion);
                    if($notificacion==null){
                        //poner la notificacion en lista uno
                        $clausura_notificacion=new Clausura_notificacion();
                        $clausura_notificacion->fecha_inicio=$request->fecha;
                        $clausura_notificacion->fecha_revicion=$this->sumarMes($request->fecha);
                        $clausura_notificacion->idFinca=$request->expediente;
                        $clausura_notificacion->rutaArchivo=$ruta_archivo;
                        $clausura_notificacion->estado=1;
                        $clausura_notificacion->tipo_archivo=3;
                        $clausura_notificacion->lista=1;
                        $clausura_notificacion->save();
                    }else{
                        //poner la notificacion que hay en inactiva o 0
                        $notificacion->estado=0;
                        $notificacion->save();
                        // poner la notificacion en lista #
                        $clausura_notificacion=new Clausura_notificacion();
                        $clausura_notificacion->fecha_inicio=$request->fecha;
                        $clausura_notificacion->fecha_revicion=$this->sumarMes($request->fecha);
                        $clausura_notificacion->idFinca=$request->expediente;
                        $clausura_notificacion->rutaArchivo=$ruta_archivo;
                        $clausura_notificacion->estado=1;
                        $clausura_notificacion->tipo_archivo=3;
                        $clausura_notificacion->lista=2;
                        $clausura_notificacion->save();

                    }
     

            }// fin del if de 3 
            else   if($request->checkbox==4){
                 $notificacion = Clausura_notificacion::where('idFinca','=',$request->expediente)->where('estado','=',1)->where('tipo_archivo','=',3)->first();
                    // dd($notificacion);
                    if($notificacion!=null){
                        $notificacion->estado=0;
                        $notificacion->save();
                    }
                    
                     $clausura_notificacion= Clausura_notificacion::where('idFinca','=',$request->expediente)->where('estado','=',1)->where('tipo_archivo','=',2)->first();
                    if($clausura_notificacion!=null){
                        $clausura_notificacion->estado=0;
                        $clausura_notificacion->save();
                    }
            }
           

            $expediente = Expediente::where('finca', '=', $request->expediente)->first();
            $expediente->estado=$request->checkbox;
            $expediente->save();
            // dd($expediente);
            return back();
    }// fin de subirClausura

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
                $distribucion= new Distribucion_distritos();
                $distribucion->id_distrito = $opcion;
                $distribucion->id_usuario=$request->usuario[$num];
                $distribucion->save();
            }else{
                $distribucion->id_distrito = $opcion;
                $distribucion->id_usuario=$request->usuario[$num];
                $distribucion->save();
            }
            
        }
        // retornar con mensaje
        return back();
        
    }// fin de listaDIstritos

    public function buscar(){
        $subcarpetas= SubExpediente::all();
        return view('jefatura.buscar')->with(['subcarpetas'=>$subcarpetas]);
    }// fin de buscar

     public function buscarFiltrado(Request $request){
        $archivos=archivos_expediente::all()->where('carpeta_id', '=',$request->carpeta)->all();
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

    public function descargarArchivo(Request $request){
        $headers = ['Content-Type: application/pdf'];
        return response()->download(storage_path("app/public/".$request->archivo,$request->archivo, $headers));
    }// fin de descargarArchivo

    protected function verArchivo(Request $request){
      return response()->file(storage_path("app/public/".$request->archivo));
    }//fin de verArchivo

    public function lista_clausuras_notificaciones($id){
         $fecha = date('Y-m-j');
         $clausura_notificacion=Clausura_notificacion::all()->where('estado','=',1)->where('lista','=',$id)->where('fecha_revicion','<',$fecha);
        return view('jefatura.listaNotificaciones')->with(['clausura_notificacion'=>$clausura_notificacion]);
    }// fin de lista_clausuras_notificaciones

    public function sumarMes($fecha){
        // $fecha = date('Y-m-j');
        $valores = explode ("-", $fecha); 
        $diaPrimera    = $valores[2];  
        $mesPrimera  = $valores[1];  
        $anyoPrimera   = $valores[0]; 
        // return implode("-", $valores);         
         // $fecha = date('Y-m-j');
$nuevafecha = strtotime ( '+1 month' , strtotime ( implode("-", $valores) ) ) ;
$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        return $nuevafecha;
    }// fin de sumar mes
}
