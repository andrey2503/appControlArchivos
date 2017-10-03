@extends('jefatura.escritorio')

@section('content')

<div class="container row col-md-12 contenedor-usuario">

	<div class="container row col-md-8 col-md-offset-2 ">
  <div class=" col-md-12 box box-primary">
    <div class="box-header with-border">
                  <h3 class="box-title"> Solicitud de inspeccion</h3>
      </div><!-- /.box-header -->
      <form  role="form"   method="post"  action="{{ url('jefat/nuevoExpediente') }}" class="form-horizontal form_entrada" >
       {{ csrf_field() }}
      <div class="box-body">
            <div class="form-group">
                <label for="expediente">Numero expediente</label>
                <input type="text" class="form-control" name="expediente" placeholder="Nombre">
                @if($errors->has('expediente'))
                  <span style="color: red;">{{ $errors->first('expediente') }}</span>
                @endif
              </div>


        </div>
        <button style="margin-bottom: 15px;" type="submit" class="btn btn-default btn-info">Crear Expediente</button>
      </form>
      </div><!-- /.box -->
</div>

</div>


@endsection