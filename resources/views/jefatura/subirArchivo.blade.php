  @if(isset($tipo_documento))
  <div class="container row" style="margin:15px;">
    <a class="btn btn-info " href="{{ url('jefat/verExpediente') }}/{{ $expediente }}">
    <span class="glyphicon glyphicon-circle-arrow-left"></span> regresar</a>
  </div>
  <form class="form-inline" action="{{ url('jefat/subirArchivo')}}" method="post" enctype="multipart/form-data">
         {{ csrf_field() }}
         <input type="hidden" name="id" value="{{ $carpeta }}">
         <input type="hidden" name="expediente" value="{{ $expediente }}">
    <div class="form-group">
      <label for="archivo">Archivo</label>
      <input type="file" class="form-control" name="archivo" placeholder="Archivo">
    </div>
    <div class="form-group">
      <label for="tipo">Tipo de documento</label>
      <select class="form-control" name="tipo" id="selectTipos">
  	  @foreach($tipo_documento as $t)
        @if($t->carpeta_id == $carpeta)
        <option  value="{{ $t->id }}">{{ $t->tipo }}</option>
        @endif
      @endforeach

  	</select>

    </div>
    <button type="submit" class="btn btn-success">Subir</button>
    <a class="btn btn-warning pull-right"  data-toggle="modal" data-target="#nuevoTipoArcivoModal"><span class="glyphicon glyphicon-plus"></span> Nuevo tipo</a>
  </form>



<!-- Modal -->
<div id="nuevoTipoArcivoModal" class="modal fade" role="dialog" >
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="padding: 10px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
        <div id="mensajeTipoDiv"  style="display: none;">
          <div  class="alert alert-success" role="alert">
              <p id="mensajeTipo">Success</p>
          </div>
        </div>
      </div>
      <div class="modal-body" >
        
          <form id="nuevoTipoArchivo" role="form"   method="post"  action="{{ url('jefat/tipoDocumento') }}" class="form-horizontal form_entrada" >        
            {{ csrf_field() }}
         <input type="hidden" name="id" value="{{ $carpeta }}">
        <div class="form-group">
          <label for="direccion">Tipo documento</label>
          <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Tipo" required>
        </div>
       
        <button onclick="crearTipoDocumento()" type="button" class="btn btn-default btn-success">Crear Tipo documento</button>
      </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar ventana</button>
      </div>
    </div>

  </div>
</div>

@section('scripts')
<script type="text/javascript">
  
 function crearTipoDocumento(){

  var form=$("#nuevoTipoArchivo");
  var url= form.attr('action');
  var data= form.serialize();
  $.post(url,data,function(result){
    console.log(result.id);

    $("#selectTipos").append("<option value= '" +result.id+"' >"+result.tipo+"</option>");
    $("#mensajeTipo").text("Documento "+result.tipo+ " creado exitosamente");
    $("#mensajeTipoDiv").css("display","initial");

    setTimeout( function() {
        $("#mensajeTipoDiv").fadeOut();
       }, 3000);
 
  }).fail(function(e){
    console.log(e);
    alert(e);
  }); 
}//fin de solicitar inspeccion
</script>

@endsection


  @endif

