<?php

namespace App\Http\Controllers;
use App\Expediente;
use App\Distrito;
use App\SubExpediente;
use App\archivos_expediente;
use Illuminate\Http\Request;
use App\User;
use App\Clausura_notificacion;
use Hash;

class Publico extends Controller
{
    /**
     * Retorna una vista con una tabla donde se listan todos los distritos
     * @return view
     */
    public function listaDistritos(){
        $distritos= Distrito::all();
        return view('publico.distritos')->with(['distritos'=>$distritos]);
    }// fin de listaDIstritos
    /**
      * Retorna una vista con una tabla donde se listan todos las fincas
      * @return type
      */
     public function expedientes()
    {
        $expedientes= Expediente::all();
        return view('publico.listaExpedientes')->with(['expedientes'=>$expedientes]);
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
        return view('publico.listaExpedientes')->with(['expedientes'=>$expedientes]);
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
        return view('publico.detalleExpediente')
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
            $expedienteID=Expediente::where('finca', '=', $expediente)->first();
            return view('publico.listadoArchivosSubCarpeta')
                        ->with(['carpeta'=>$id,
                            'expediente'=>$expediente,
                            'archivos'=>$archivos,
                            'distrito'=>$expedienteID->distrito_id]);
        }else{
            $archivos=Clausura_notificacion::all()->where('idFinca','=',$expediente)->all();
            $expedienteID=Expediente::where('finca', '=', $expediente)->first();
            return view('publico.listadoClausuras')
                        ->with(['carpeta'=>$id,
                            'expediente'=>$expediente,
                            'archivos'=>$archivos,
                            'distrito'=>$expedienteID->distrito_id]);
        }

    }// fin de verArchivos
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
        return view('publico.actualizarContraseña');
    }// fin de formActualizarContrasena
    /**
     * Retorna una vista con las subcarpetas para poder filtrar los archivos
     * de todos los expedientes
     * @return view
     */
    public function buscar(){
        $subcarpetas= SubExpediente::all();
        return view('publico.buscar')->with(['subcarpetas'=>$subcarpetas]);
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
}
