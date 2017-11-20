@extends('inspector.escritorio')

@section('content')
@if(isset($expediente))
	@include('inspector.menuNavegacion')
<div class="container row col-md-12 contenedor-usuario">
<div>
	<table class="table table-striped table-bordered" id="tabla-carpetas">
		<thead>
			<th>Carpeta</th>
			<th>Acción</th>
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
@endif
@endsection