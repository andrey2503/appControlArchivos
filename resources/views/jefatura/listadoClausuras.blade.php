@extends('jefatura.escritorio')

@section('content')
  @include('jefatura.menuNavegacion')
<div class="container row col-md-12 contenedor-usuario">
          @if(session()->has('message'))
                      <div class="alert alert-success">
                          {{ session()->get('message') }}
                      </div>
          @endif

          <!-- tabla principal de usuarios -->
          @if($permiso)
          <div class="row tabla-usuarios">
             @include('jefatura.subirClausura')
          </div>
          @endif

          <div class="row tabla-usuarios">
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <th>Documento</th>
                  <th>Fecha Inicio</th>
                  <th>Fecha Inspeccion</th>
                  <th>Estado</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                 @if(isset($archivos))
                    @foreach($archivos as $a)
                      <tr>
                        <td>  {{ $a->rutaArchivo}}  </td>
                        <td>  {{ $a->fecha_inicio}} </td>
                        <td>  {{ $a->fecha_revicion}} </td>
                        <td>  {{ $a->estado}} </td>
                        <td>
                          <form style="float: left;" action="{{ url('jefat/verArchivo') }}" method="get" id="dosform_{{ $a->id }}">
                          <input type="hidden" name="archivo" value="{{$a->rutaArchivo}}">
                         <button  onclick="verArchivo('{{$a->id}}')" type="submit" class="btn btn-info"> ver </button>
                          </form>
                        <form style="float: right;" action="{{ url('jefat/descargarArchivo') }}" method="get" id="form_{{ $a->id }}">
                            <input type="hidden" name="archivo" value="{{$a->rutaArchivo}}"/>
                            <button type="submit" class="btn btn-success"> descargar </button>
                        </form>
                        </td>
                      </tr>
                    @endforeach
                 @endif
                </tbody>
              </table>
            </div>
          </div>
</div>


<script type="text/javascript">
  function descargarArchivo(archivo){
        // var form=document.getElementById(archivo);
        var form=$("#form_"+archivo);
        var url=form.attr('action');
        var data= form.serialize();
        $.get(url,data,function(result){
          console.log(result);
        },'json').fail(function(e){
          console.log(e);
        }); 

  }// fin de desvargarAchivo
  function verArchivo(archivo){
    // var form=$("#dosform_"+archivo);
    // var url=form.attr('action');
    // alert(url);
    // var data= form.serialize();
    //  $.get(url,data,function(result){
    //       console.log(result.algun);
    //       console.log(result.ruta);
    //       window.open(result.ruta);

    //     },'json').fail(function(e){
    //       console.log(e);
    //     }); 
  }// fin de ver archivo
</script>
<!-- fin de la seccion script -->


@endsection

