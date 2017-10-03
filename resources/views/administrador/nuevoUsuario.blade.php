@extends('administrador.escritorio')

@section('content')

<div class="container row col-md-8 col-md-offset-2 ">
  <div class=" col-md-12 box box-primary">
    <div class="box-header with-border">
                  <h3 class="box-title"> Nuevo usuario</h3>
      </div><!-- /.box-header -->
      <form  role="form"   method="post"  action="{{ url('admin/nuevoUsuario') }}" class="form-horizontal form_entrada" >
       {{ csrf_field() }}
      <div class="box-body">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" placeholder="Nombre">
                @if($errors->has('nombre'))
                  <span style="color: red;">{{ $errors->first('nombre') }}</span>
                @endif
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="mail" placeholder="Email">
                @if($errors->has('mail'))
                  <span style="color: red;">{{ $errors->first('mail') }}</span>
                @endif
              </div>

               <div class="form-group">
                <label for="usuario">usuario</label>
                <input type="text" class="form-control" name="usuario" placeholder="usuario">
                @if($errors->has('usuario'))
                  <span style="color: red;">{{ $errors->first('usuario') }}</span>
                @endif
              </div>

              <div class="form-group">
                <label for="contrasena">Password</label>
                <input type="password" class="form-control" name="contrasena" placeholder="Password">
                @if($errors->has('contrasena'))
                  <span style="color: red;">{{ $errors->first('contrasena') }}</span>
                @endif
              </div>


              <select name="idrol"class="form-control">
                  <option value="3">Inspector</option>
                  <option value="2">Jefatura</option>
                  <option value="1">Administrador</option>
              </select>
              @if($errors->has('idrol'))
                  <span style="color: red;">{{ $errors->first('idrol') }}</span>
                @endif

               <select name="estado"class="form-control">
                  <option value="0">Inactivo</option>
                  <option value="1">Activo</option>
              </select>
              @if($errors->has('estado'))
                  <span style="color: red;">{{ $errors->first('estado') }}</span>
                @endif

        </div>
        <button style="margin-bottom: 15px;" type="submit" class="btn btn-default btn-info">Crear usuario</button>
      </form>
      </div><!-- /.box -->
</div>
@endsection
