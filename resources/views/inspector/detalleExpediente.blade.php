@extends('inspector.escritorio')

@section('content')
@if(isset($expediente))
	@include('inspector.menuNavegacion')
	
<div class="container row col-md-12 contenedor-usuario">
<div>
	<table class="table table-striped table-bordered" id="tabla-carpetas">
		<thead>
			<th>Carpeta</th>
			<th>Accion</th>
		</thead>
		<tbody>
		@if(isset($subcarpetas))
			@foreach($subcarpetas as $sc)
				<tr>
					<td>{{ $sc->carpeta }}</td>
					<td>

					<a href=" {{ url('inspec/verArchivos')}}/{{ $sc->id }}/{{ $expediente->finca }}" type="button" class="btn btn-info btn-xs btn-modal-inspeccion"> <span class="glyphicon glyphicon-eye-open"></span> Entrar</a></td>
				</tr>
			@endforeach
		@endif
			
		</tbody>
	</table>
</div>

</div>





<!-- Trigger the modal with a button -->



<!-- Modal -->
<div id="modalNotificacion" class="modal fade" role="dialog" >
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="padding: 10px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body" >
        
        	<form id="form_nuevaInspeccion" role="form"   method="post"  action="{{ url('inspec/crearSubcarpeta') }}" class="form-horizontal form_entrada" >        
        		{{ csrf_field() }}
        		<input type="hidden" name="expediente" value="{{ $expediente->finca }}">
        		<input type="hidden" name="expediente" value="{{ $expediente->finca }}">
			  <div class="form-group">
			    <label for="direccion">Carpeta</label>
			    <input type="text" class="form-control" id="carpeta" name="carpeta" placeholder="Carpeta" required>
			  </div>
			 
				<button onclick="crearSubcarpeta()" type="button" class="btn btn-default btn-success">Crear carpeta</button>
			</form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar ventana</button>
      </div>
    </div>

  </div>
</div>




@endif
@endsection

@section('scripts')
<script type="text/javascript">
  
 function crearSubcarpeta(){

	var form=$("#form_nuevaInspeccion");
	var url= form.attr('action');
	var data= form.serialize();
	$.post(url,data,function(result){
		console.log(result);

		$('#tabla-carpetas tr:last').after('<tr>'+
			'<td>'+result.carpeta+'</td>'+
			'<td><a href=" {{ url("inspec/verArchivos")}}/'+result.id+'/'+ result.expediente+  '" type="button" class="btn btn-info btn-xs btn-modal-inspeccion"> <span class="glyphicon glyphicon-eye-open"></span> Entrar</a></td>'+
			'</tr>');

	}).fail(function(e){
		console.log(e);
		alert(e);
	});	
}//fin de solicitar inspeccion
</script>

@endsection