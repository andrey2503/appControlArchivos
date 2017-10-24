<div class="container row col-md-12 contenedor-usuario">
	<div>
		<a href="{{ url('inspec/') }}"> <span class="glyphicon glyphicon-chevron-left"></span> Distritos  </a>
		@if(isset($expediente->distrito_id))
			<a href="{{ url('inspec/') }}/expedientes/{{$expediente->distrito_id}}"> <span class="glyphicon glyphicon-chevron-left"></span>Expedientes  </a> 
		@else
			@if(isset($expediente))
			<a href="{{ url('inspec/') }}/expedientes/{{$distrito}}"> <span class="glyphicon glyphicon-chevron-left"></span>Expedientes  </a> 
			<a href="{{ url('inspec/verExpediente') }}/{{$expediente}}"> <span class="glyphicon glyphicon-chevron-left"></span>Carpetas  </a>
			@endif
		@endif
	</div>
</div>