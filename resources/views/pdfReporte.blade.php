<!DOCTYPE html>
<html lang="es">
<head>
	<title>Reporte</title>
	<style type="text/css">
		.table-encabezado{
			width: 100%;
			text-align: center;
		}
		.tabla-datos{
			width: 100%;
			text-align: center;
		}
		td{
			width: 50%;
			padding: 5px;
			/*border-top:1px black solid;*/
			border-bottom:1px black solid;
			border-left:1px black solid;

		}
		.left{
			border-right:1px black solid;
		}
		tr{
			border-radius: 2px;
		}
		.thead-dark{
			background-color: #454545;
			color: white;
		}
		.col{
			padding: 10px;
		}
		.titulo{
			text-align: center;
		}
		.right{
		}
		.escudo{
			width: 80px;
		}
		.header{
			text-align: center;
		}
	</style>
</head>
<body>
<div class="header">
	<img class="escudo" src="./img/escudoMuni.jpg">
	<h1 class="titulo">Municipalidad de Santo Domingo de Heredia</h1>
</div>
<div>
	<h3>Reporte de estados de fincas</h3>
	<p>Fecha del reporte: {{ date('Y-m-d')}} <br>
	Cantidad expedientes en el reporte: {{ count($expedientes) }}<br>
	Generado por: {{ Auth::user()->name }}</p>
</div>
<div class="container">
    <div class="row">
		    <table class="table-encabezado">
		    			<thead class="thead-dark">
							<th class="col">#Finca</th>
							<th class="col">Estado</th>
						</thead>
				
				<tbody>
				<tr></tr>
				@foreach($expedientes as $e)
					<tr>
						<td class="rigth">{{ $e->finca }}</td>
						@if($e->estado==1)
							<td class="left">Bien</td>
						@elseif($e->estado==2)
							<td class="left">Clausurdado</td>
						@elseif($e->estado==3)
							<td class="left">Notificado</td>
						@elseif($e->estado==4)
							<td class="left">Trasladado</td>
						@endif
					</tr>
				@endforeach
				</tbody>
			</table>
	</div>
</div>
</body>
</html>