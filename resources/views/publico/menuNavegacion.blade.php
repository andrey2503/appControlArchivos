<div class="container row col-md-12 contenedor-usuario">
	<div>
		<a href="{{ url('jefat/') }}"> <span class="glyphicon glyphicon-chevron-left"></span> Distritos  </a>
		@if(isset($expediente->distrito_id))
			<a href="{{ url('jefat/') }}/expedientes/{{$expediente->distrito_id}}"> <span class="glyphicon glyphicon-chevron-left"></span>Expedientes  </a> 
		@else
			@if(isset($expediente))
			<a href="{{ url('jefat/') }}/expedientes/{{$distrito}}"> <span class="glyphicon glyphicon-chevron-left"></span>Expedientes  </a> 
			<a href="{{ url('jefat/verExpediente') }}/{{$expediente}}"> <span class="glyphicon glyphicon-chevron-left"></span>Carpetas  </a>
			@endif
		@endif
	</div>
</div>