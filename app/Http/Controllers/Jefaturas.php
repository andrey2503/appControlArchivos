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
class Jefaturas extends Controller
{
    /**
     * Muentra un formularion para la creación de un nuevo expediente o finca
     * dentro del sistema
     * @return type
     */
    public function vistaCrearExpediente(){
        $distritos= Distrito::all();
        return view('jefatura.nuevoExpediente')->with(['distritos'=>$distritos]);
    }
    /**
     * Retorna una vista con una tabla donde se listan todos los distritos
     * @return view
     */
    public function listaDistritos(){
        $distritos= Distrito::all();
        return view('jefatura.distritos')->with(['distritos'=>$distritos]);
    }// fin de listaDIstritos
     /**
      * Retorna una vista con una tabla donde se listan todos las fincas
      * @return type
      */
    public function expedientes()
    {
        $expedientes= Expediente::all();
        return view('jefatura.listaExpedientes')->with(['expedientes'=>$expedientes]);
    }// Expedientes
    /**
     * Retorna una vista con una tabla donde se listan los expedientes asociados 
     * a un distrito
     * @param int $id 
     * @return view
     */
    public function listaExpedientes($id)
    {
        $expedientes=Expediente::all()->where('distrito_id', '=', $id)->all();
        return view('jefatura.listaExpedientes')->with(['expedientes'=>$expedientes]);
    }// listaExpedientes
    /**
     * Valida y recibe los datos para crear un nuevo expediente o finca en el sistema
     * @param Request $request 
     * @return devuelve a la vista un mensaje de existoso o de error
     */
    public function nuevoExpediente(Request $request)
    {
        $this->validate($request,[
            'finca'=>'required|min:6|max:6|unique:expedientes',
            'distrito'=>'required',]);
        $expediente = new Expediente();
        $expediente->finca = $request->finca;
        $expediente->estado=1;
        $expediente->distrito_id=$request->distrito;
        $idUsuario=\Auth::user()->id;
        $expediente->user_id=$idUsuario;
        if($expediente->save()){
            return redirect()->back()->with('message','Expediente '.$request->expediente.' creado correctamente');
        }else{
            return redirect()->back()->with('error_expediente','Expediente '.$request->expediente.' creado correctamente');
        }
    }// fin de nuevoExpediente
    /**
     * devuelve una vista con las subcarpetas donde se guardan los archivos del sistema
     * envia a la vista los datos del expediente
     * @param int $id 
     * @return vista
     */
    public function detalleExpediente($id)
    {
        $subcarpetas= SubExpediente::all();
        $expediente=Expediente::find($id);
        dd($expediente->distrito);
        return view('jefatura.detalleExpediente')
                ->with(['expediente'=>$expediente,
            'subcarpetas'=>$subcarpetas]);
    }// fin de detalleExpediente
    /**
     * Permite crear nuevas subcarpetas dentro de los expedientes para guardar nuevos archivos
     * @param Request $request 
     * @return responde a una peticion ajax con jquery
     */
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
    /**
     * Devuelve una vista con una tabla donde se listan los archivos asociados a cada 
     * subcarpeta dentro del sistema, verifica los permisos del usuario quien esta consultando 
     * los archivos y determinar si se muestra o no se muestra el formulario para cargar nuevos arhcivo
     * @param int $id 
     * @param String $expediente 
     * @return view
     */
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
            $archivos=Clausura_notificacion::all()->where('idFinca','=',$expediente)->all();
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
    /**
     * Valida el tipo de archivo y recibe los datos y el archivo y lo guarda en un disco de laravel
     * @param Request $request 
     * @return view back
     */
    public function subirArchivo(Request $request){
        $this->validate($request,[
            'archivo'=>'required|mimes:jpeg,bmp,png,pdf',
            'tipo'=>'required',
            'id'=>'required',
            'expediente'=>'required'
            ]);
        $archivo= $request->file('archivo');
        $ruta_archivo= time().'_'.$archivo->getClientOriginalName();
        $archivo_expediente = new archivos_expediente();
        $archivo_expediente->carpeta_id = $request->id;
        $archivo_expediente->idFinca= $request->expediente;
        $archivo_expediente->ruta_archivo=$ruta_archivo;
        $archivo_expediente->tipo_id= $request->tipo;
        Storage::disk('public')->put($ruta_archivo,file_get_contents($archivo->getRealPath()));
        if($archivo_expediente->save()){
            return redirect()->back()->with('message','Archivo '.$ruta_archivo.' cargado correctamente');
        }else{
            return redirect()->back()->with('error','Error al cargar archivo');
        }
    }// fin de subir archivo
    /**
     * Valida y recibe los datos y el archivo para la carpeta de clausuaras y notificaciones
     * Verifica si hay clausura o notificacion abiertas y las cierran dejanco activa la ultima
     * clausura o notificaion cargada
     * @param Request $request 
     * @return type
     */
    public function subirClausura(Request $request){
         $this->validate($request,[
                'checkbox'=>'required',
                'fecha'=>'required',
                'archivo'=>'required|mimes:jpeg,bmp,png,pdf',
                ]);
            $archivo= $request->file('archivo');
            $ruta_archivo= time().'_'.$archivo->getClientOriginalName();
            $tipo_documento= $request->checkbox;
            Storage::disk('public')->put($ruta_archivo,file_get_contents($archivo->getRealPath()));
            if($request->checkbox==1){
                        $notificacion = Clausura_notificacion::where('idFinca','=',$request->expediente)->where('estado','=',1)->where('tipo_archivo','=',3)->first();
                        if($notificacion!=null){
                            $notificacion->estado=0;
                            $notificacion->save();
                        }
                         $clausura_notificacion= Clausura_notificacion::where('idFinca','=',$request->expediente)->where('estado','=',1)->where('tipo_archivo','=',2)->first();
                        if($clausura_notificacion!=null){
                            $clausura_notificacion->estado=0;
                            $clausura_notificacion->save();
                        }
                        $clausura_notificacion=new Clausura_notificacion();
                        $clausura_notificacion->fecha_inicio=$request->fecha;
                        $clausura_notificacion->fecha_revicion=$request->fecha;
                        $clausura_notificacion->idFinca=$request->expediente;
                        $clausura_notificacion->rutaArchivo=$ruta_archivo;
                        $clausura_notificacion->estado=0;
                        $clausura_notificacion->tipo_archivo=$request->checkbox;
                        $clausura_notificacion->lista=1;
                        $clausura_notificacion->save();

            } else if($request->checkbox==2){
                     $clausura_notificacion= Clausura_notificacion::where('idFinca','=',$request->expediente)->where('estado','=',1)->where('tipo_archivo','=',2)->first();
                     $notificacion = Clausura_notificacion::where('idFinca','=',$request->expediente)->where('estado','=',1)->where('tipo_archivo','=',3)->first();
                    if($clausura_notificacion!=null){
                        $clausura_notificacion->estado=0;
                        $clausura_notificacion->save();
                    }
                    if($notificacion!=null){
                            $notificacion->estado=0;
                            $notificacion->save();
                    }
                     $clausura_notificacion= new Clausura_notificacion();
                     $clausura_notificacion->fecha_inicio=$request->fecha;
                     $clausura_notificacion->fecha_revicion=$this->sumarMes($request->fecha,1);
                     $clausura_notificacion->idFinca=$request->expediente;
                     $clausura_notificacion->rutaArchivo=$ruta_archivo;
                     $clausura_notificacion->estado=1;
                     $clausura_notificacion->tipo_archivo=$request->checkbox;
                     $clausura_notificacion->lista=1;
                     $clausura_notificacion->save();
                                     // si es una notificacion
            }else if($request->checkbox==3){
                     $clausura_notificacion= Clausura_notificacion::where('idFinca','=',$request->expediente)->where('estado','=',1)->where('tipo_archivo','=',2)->first();
                     $notificacion = Clausura_notificacion::where('idFinca','=',$request->expediente)->where('estado','=',1)->where('tipo_archivo','=',3)->first();
                    if($clausura_notificacion!=null){
                        $clausura_notificacion->estado=0;
                        $clausura_notificacion->save();
                    }
                    if($notificacion!=null){
                            $notificacion->estado=0;
                            $notificacion->save();
                    }
                     $clausura_notificacion= new Clausura_notificacion();
                     $clausura_notificacion->fecha_inicio=$request->fecha;
                     $clausura_notificacion->fecha_revicion=$this->sumarMes($request->fecha,2);
                     $clausura_notificacion->idFinca=$request->expediente;
                     $clausura_notificacion->rutaArchivo=$ruta_archivo;
                     $clausura_notificacion->estado=1;
                     $clausura_notificacion->tipo_archivo=$request->checkbox;
                     $clausura_notificacion->lista=2;
                     $clausura_notificacion->save();
            }// fin del if de 3 
            else   if($request->checkbox==4){
                    $notificacion = Clausura_notificacion::where('idFinca','=',$request->expediente)->where('estado','=',1)->where('tipo_archivo','=',3)->first();
                    $clausura_notificacion= Clausura_notificacion::where('idFinca','=',$request->expediente)->where('estado','=',1)->where('tipo_archivo','=',2)->first();
                    if($notificacion!=null){
                        $notificacion->estado=0;
                        $notificacion->save();
                    }
                    if($clausura_notificacion!=null){
                        $clausura_notificacion->estado=0;
                        $clausura_notificacion->save();
                    }
                        $clausura_notificacion=new Clausura_notificacion();
                        $clausura_notificacion->fecha_inicio=$request->fecha;
                        $clausura_notificacion->fecha_revicion=$request->fecha;
                        $clausura_notificacion->idFinca=$request->expediente;
                        $clausura_notificacion->rutaArchivo=$ruta_archivo;
                        $clausura_notificacion->estado=0;
                        $clausura_notificacion->tipo_archivo=$request->checkbox;
                        $clausura_notificacion->lista=1;
                        $clausura_notificacion->save();
            }
            $expediente = Expediente::where('finca', '=', $request->expediente)->first();
            $expediente->estado=$request->checkbox;
            $expediente->save();
            return redirect()->back()->with('message','Archivo '.$ruta_archivo.' cargado correctamente');
    }// fin de subirClausura
    /**
     * Permite crear nuevos tipos de archivos en las subcarpetas para asocialor a los archivos
     * @param Request $request 
     * @return respuesta de una peticion ajax
     */
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
    /**
     * Retorna una vista con una tabla donde se lista los distritos y una lista de 
     * los usuarios jefatura e inspectores para asociarlos a un distrito
     * @return type
     */
    public function administrarDistritos(){
        $distritos= Distrito::all();
        $usuarios= User::all();
        $distribucion = Distribucion_distritos::all();
        return view('jefatura.administrarDistritos')
                ->with(['distritos'=>$distritos,'usuarios'=>$usuarios,'distribucion'=>$distribucion]);
    }// fin de listaDIstritos
    /**
     * Asigna los distritos a los usuarios para poder darle los permiso de subir archivos
     * para los expedientes dentro de los distritos
     * @param Request $request 
     * @return view
     */
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
        return redirect()->back()->with('message','Distritos asignados');
    }// fin de listaDIstritos
    /**
     * Retorna una vista con las subcarpetas para poder filtrar los archivos
     * de todos los expedientes
     * @return view
     */
    public function buscar(){
        $subcarpetas= SubExpediente::all();
        return view('jefatura.buscar')->with(['subcarpetas'=>$subcarpetas]);
    }// fin de buscar
    /**
     * Retorna el listado de archivos asociados a una subcarpeta para realizar el filtrado
     * @param Request $request 
     * @return json respuesta a una peticion ajax
     */
     public function buscarFiltrado(Request $request){
        if($request->carpeta!=2){
            $archivos=archivos_expediente::all()->where('carpeta_id', '=',$request->carpeta)->all();
            return json_encode($archivos);    
        }else{
            $archivos=Clausura_notificacion::all();
            return json_encode($archivos);
        }
    }// fin buscarFiltrado
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
     * Muestra un formulario para actualizar la contraseña del usuario
     * @return view
     */
    public function formActualizarContrasena(){
        return view('jefatura.actualizarContraseña');
    }// fin de formActualizarContrasena
    /**
     * Descarga un archivo seleccionado al dispositivo fisico
     * @param Request $request 
     * @return file
     */
    public function descargarArchivo(Request $request){
        $headers = ['Content-Type: application/pdf'];
        return response()->download(storage_path("app/public/".$request->archivo,$request->archivo, $headers));
    }// fin de descargarArchivo
    /**
     * Envia un archivo al navegador para ser previsualizado
     * @param Request $request 
     * @return file
     */
    public function verArchivo($file){
      return response()->file(storage_path("app/public/".$file));
    }//fin de verArchivo
    /**
     * Verifica en el sistema las clausuras o notificaciones que han pasado el mes de revision
     * para ser enviadas como una alerta de inspeccion a los usuarios
     * @param type $id 
     * @return type
     */
    public function lista_clausuras_notificaciones($id){
         $fecha = date('Y-m-j');
         $clausura_notificacion=Clausura_notificacion::all()->where('estado','=',1)->where('lista','=',$id)->where('fecha_revicion','<',$fecha)->where('tipo_archivo','!=',1)->where('tipo_archivo','!=',4);
        return view('jefatura.listaNotificaciones')->with(['clausura_notificacion'=>$clausura_notificacion]);
    }// fin de lista_clausuras_notificaciones
    /**
     * Genera a partir de una fecha dada, una nueva fecha que es un mes mayor que la dada
     * @param String $fecha 
     * @return String
     */
    public function sumarMes($fecha,$mes){
        $valores = explode ("/", $fecha); 
        $diaPrimera    = $valores[2];  
        $mesPrimera  = $valores[1];  
        $anyoPrimera   = $valores[0]; 
        $nuevafecha = strtotime ( '+'.$mes.' month' , strtotime ( implode("-", $valores) ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        return $nuevafecha;
    }// fin de sumar mes
    /**
     * Description
     * @return type
     */
    public function misExpedientes(){
        $distritosAsignados=Distribucion_distritos::all()->where('id_usuario','=',\Auth::user()->id)->all();
        $expedientes=[];
        foreach ($distritosAsignados as $distrito) {
        $expedientesNuevoDistrito=Expediente::all()->where('distrito_id', '=', $distrito->id_distrito)->all();
        $expedientes=array_merge($expedientes,$expedientesNuevoDistrito);
        }
        return view('jefatura.listaExpedientes')->with(['expedientes'=>$expedientes]);
    }// fin de misExpedientes
}