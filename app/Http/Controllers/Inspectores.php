<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Distrito;
use App\Expediente;
use App\SubExpediente;
use App\archivos_expediente;
use App\Distribucion_distritos;
use App\tipo_documento;
use App\Clausura_notificacion;
use App\User;
use Hash;
use Storage;
class Inspectores extends Controller
{
    /**
     * Retorna una vista con una tabla donde se listan todos los distritos
     * @return view
     */
    public function listaDistritos(){
        $distritos= Distrito::all();
        return view('inspector.distritos')->with(['distritos'=>$distritos]);
    }// fin de listaDIstritos
    /**
     * Retorna una vista con una tabla donde se listan los expedientes asociados 
     * a un distrito
     * @param int $id 
     * @return view
     */
    public function listaExpedientes($id)
    {
        $expedientes=Expediente::all()->where('distrito_id', '=', $id)->all();
        return view('inspector.listaExpedientes')->with(['expedientes'=>$expedientes]);

    }// listaExpedientes
    /**
     * devuelve una vista con las subcarpetas donde se guardan los archivos del sistema
     * envia a la vista los datos del expediente
     * @param int $id 
     * @return vista
     */
    public function detalleExpediente($id)
    {
        $subcarpetas= SubExpediente::all();
        $expediente=Expediente::where('finca', '=', $id)->first();
        return view('inspector.detalleExpediente')
                ->with(['expediente'=>$expediente,
            'subcarpetas'=>$subcarpetas]);
    }// fin de detalleExpediente
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
        }else{
            $archivos=Clausura_notificacion::all()->where('idFinca','=',$expediente)->all();
            $editar=false;
            $expedienteID=Expediente::where('finca', '=', $expediente)->first();
            $permisos=Distribucion_distritos::where('id_distrito ','=', $expedienteID->distrito_id,' and ')->where('id_usuario','=', \Auth::user()->id)->first();
            if($permisos!=null){
                $editar=true;
            }

            $tipo_documento= tipo_documento::all();
            return view('inspector.listadoClausuras')
                        ->with(['tipo_documento'=>$tipo_documento,
                            'carpeta'=>$id,
                            'expediente'=>$expediente,
                            'archivos'=>$archivos,
                            'permiso'=>$editar,
                            'distrito'=>$expedienteID->distrito_id]);
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
        Storage::disk('public')->put($ruta_archivo,
            file_get_contents($archivo->getRealPath()));
        $archivo_expediente->save();
        return back();
    }// fin de subir archivo
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
     * Muentra un formularion para la creación de un nuevo expediente o finca
     * dentro del sistema
     * @return type
     */
    public function vistaCrearExpediente(){
        $distritos= Distrito::all();
        return view('inspector.nuevoExpediente')->with(['distritos'=>$distritos]);
    }//fin de vistaCrearExpediente
    /**
     * Valida y recibe los datos para crear un nuevo expediente o finca en el sistema
     * @param Request $request 
     * @return devuelve a la vista un mensaje de existoso o de error
     */
    public function nuevoExpediente(Request $request)
    {
        $this->validate($request,[
            'finca'=>'required|min:6|unique:expedientes',
            'distrito'=>'required',]);
        $expediente = new Expediente();
        $expediente->finca = $request->finca;
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
    /**
      * Retorna una vista con una tabla donde se listan todos las fincas
      * @return type
      */
     public function expedientes()
    {
        $expedientes= Expediente::all();
        return view('inspector.listaExpedientes')->with(['expedientes'=>$expedientes]);
    }// Expedientes
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
        return view('inspector.actualizarContraseña');
    }// fin de formActualizarContrasena
    /**
     * Retorna una vista con las subcarpetas para poder filtrar los archivos
     * de todos los expedientes
     * @return view
     */
    public function buscar(){
        $subcarpetas= SubExpediente::all();
        return view('inspector.buscar')->with(['subcarpetas'=>$subcarpetas]);
    }// fin de buscar
    /**
     * Retorna el listado de archivos asociados a una subcarpeta para realizar el filtrado
     * @param Request $request 
     * @return json respuesta a una peticion ajax
     */
    public function buscarFiltrado(Request $request){
        $archivos=archivos_expediente::all()->where('carpeta_id', '=',$request->carpeta)->all();
        return json_encode($archivos);
    }// fin buscarFiltrado
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
    protected function verArchivo(Request $request){
      return response()->file(storage_path("app/public/".$request->archivo));
    }//fin de verArchivo
}// fin de la clase
