@extends('jefatura.escritorio')

@section('content')
<div class="container row col-md-12 " style="padding: 15px;">
  <form class="form-inline" action="{{ url('jefat/buscar')}}" method="post" id="form_filtro">
   {{ csrf_field() }}
    <div class="form-group">
    <label for="buscar">Filtrar por..</label>
      <select class="form-control" id="carpeta" name="carpeta">
        @if(isset($subcarpetas))
          @foreach($subcarpetas as $s)
            <option value="{{$s->id}}">{{ $s->carpeta }}</option>
          @endforeach
        @endif
      </select>
    </div>
    <button type="button" class="btn btn-default" onclick="cargarLista()"> <span class="glyphicon glyphicon-search"></span> Buscar</button>
  </form>
</div>
<div class="container row col-md-12 contenedor-usuario">
          <!-- tabla principal de usuarios -->
          <div class="row tabla-usuarios">
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered tabla-dinamica" cellspacing="0" width="100%">
                <thead>
                  <th>Expediente</th>
                  <th>Archivo</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
</div>
@section('scripts')
<script type="text/javascript">
    function cargarLista(){
        var form=$("#form_filtro");
        var url= form.attr('action');
        var data= form.serialize();
        $.post(url,data,success,'json').fail(function(e){
          console.log(e);
          alert(e);
        }); 
    }
    /**
     * Limpia la tabla en cada peticion ajax
     * @return type
     */
    function limpiarTabla(){
      console.log("limpiando tabla");
      var table = $('.tabla-dinamica').DataTable();
      table.rows().remove().draw(false);
    }// fin de limpiar tabla
    /**
     * Envia una peticion ajax para traer el listado de archivos asociados
     * a una carpeta y listarlos en una tabla
     * @param type result 
     * @return type
     */
    function success(result){
      limpiarTabla();
          $.each(result, function(valor) {
            var ruta=result[valor].ruta_archivo;
            if (ruta==null) {
              ruta=result[valor].rutaArchivo;
            }
            var botones='<a style="margin-right:5px;" class="btn btn-success btn-xs" href="{{ url("jefat/verExpediente")}}/'+result[valor].idFinca+'">ver expediente </a>'+
            '<a target="_black" href="{{ url('jefat/verArchivo') }}/'+ruta+'" class="btn btn-primary btn-xs" > ver archivo</a>'
            var tabla = $('#example').DataTable();
             tabla.row.add( [
            result[valor].idFinca,
            ruta,
            botones
        ] ).draw( false );
              console.log(result[valor].ruta_archivo);
          });
    }// fin de success
</script>
@endsection
@endsection