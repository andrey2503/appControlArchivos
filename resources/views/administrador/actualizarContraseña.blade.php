@extends('administrador.escritorio')

@section('content')

<div class="container row col-md-8 col-md-offset-2 ">
  <div class=" col-md-12 box box-primary">
    <div class="box-header with-border">
                  <h3 class="box-title"> Actualziar contraseña</h3>
                  @if(session()->has('message'))
                      <div class="alert alert-success">
                          {{ session()->get('message') }}
                      </div>
                  @endif
      </div><!-- /.box-header -->
      <form  role="form"   method="post"  action="{{ url('admin/actualizarContrasena') }}" class="form-horizontal form_entrada" >
       {{ csrf_field() }}
      <div class="box-body">
            <div class="form-group">
                <label for="contraseñaActual">Contraseña actual</label>
                <input type="password" class="form-control" name="contraseñaActual" placeholder="Contraseña actual...">
                @if($errors->has('errorContrasena'))
                  <span style="color: red;">{{ $errors->first('errorContrasena') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="contrasenaNueva">Nueva contraseña</label>
                <input type="password" class="form-control" name="contraseñaNueva" placeholder="Nueva contraseña...">
                @if($errors->has('contraseñaNueva'))
                  <span style="color: red;">{{ $errors->first('contraseñaNueva') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="contraseñaConfirmar">Confirmar contraseña</label>
                <input type="password" class="form-control" name="contraseñaConfirmar" placeholder="Confirmar contraseña...">
                @if($errors->has('contraseñaConfirmar'))
                  <span style="color: red;">{{ $errors->first('contraseñaConfirmar') }}</span>
                @endif
            </div>
            

        </div>
        <button style="margin-bottom: 15px;" type="submit" class="btn btn-success">Actualizar contraseña</button>
      </form>
      </div><!-- /.box -->
</div>
@endsection
