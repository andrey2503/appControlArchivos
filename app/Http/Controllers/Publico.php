<?php

namespace App\Http\Controllers;
use App\Expediente;
use App\Distrito;
use App\SubExpediente;
use App\archivos_expediente;
use Illuminate\Http\Request;

class Publico extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('publico.index');
    }

    public function listaDistritos(){
        $distritos= Distrito::all();
        return view('publico.distritos')->with(['distritos'=>$distritos]);
    }// fin de listaDIstritos

     public function expedientes()
    {
        $expedientes= Expediente::all();
        return view('publico.listaExpedientes')->with(['expedientes'=>$expedientes]);
    }// Expedientes

    public function listaExpedientes($id)
    {
        $expedientes=Expediente::all()->where('distrito_id', '=', $id)->all();
        return view('publico.listaExpedientes')->with(['expedientes'=>$expedientes]);
    }// listaExpedientes

    public function detalleExpediente($id)
    {
        //
        $subcarpetas= SubExpediente::all();
        $expediente=Expediente::where('finca', '=', $id)->first();
        return view('publico.detalleExpediente')
                ->with(['expediente'=>$expediente,
            'subcarpetas'=>$subcarpetas]);
    }// fin de detalleExpediente

    public function verArchivos($id,$expediente){
        $archivos=archivos_expediente::all()->where('carpeta_id', '=', $id)->where('idFinca','=',$expediente)->all();
        $expedienteID=Expediente::where('finca', '=', $expediente)->first();
       
        return view('publico.listadoArchivosSubCarpeta')
                    ->with(['carpeta'=>$id,
                        'expediente'=>$expediente,
                        'archivos'=>$archivos,,
                        'distrito'=>$expedienteID->distrito_id]);
    }// fin de verArchivos
}
