@extends('inspector.escritorio')

@section('content')

<div class="container row col-md-12 contenedor-usuario">
    <div class="row tabla-usuarios">
        <div class="table-responsive">

		<table class="table">
			<th>todos los expedientes</th>
			<th>Expedientes bien</th>
			<th>Expedientes Clausurados</th>
			<th>Expedientes Notificados</th>
			<th>Expedientes Trasladados</th>
			<tbody>
				<tr>
					<td><a target="_blank" class="btn btn-default " href="{{url('inspec/reporte/0')}}"><span class="glyphicon glyphicon-cloud-download"></span>Reporte</a></td>
					<td><a target="_blank" class="btn btn-default " href="{{url('inspec/reporte/1')}}"><span class="glyphicon glyphicon-cloud-download"></span>Reporte</a></td>
					<td><a target="_blank" class="btn btn-default " href="{{url('inspec/reporte/2')}}"><span class="glyphicon glyphicon-cloud-download"></span>Reporte</a></td>
					<td><a target="_blank" class="btn btn-default " href="{{url('inspec/reporte/3')}}"><span class="glyphicon glyphicon-cloud-download"></span>Reporte</a></td>
					<td><a target="_blank" class="btn btn-default " href="{{url('inspec/reporte/4')}}"><span class="glyphicon glyphicon-cloud-download"></span>Reporte</a></td>
				</tr>
			</tbody>
		</table>
		</div>
	</div>
</div>
@endsection
