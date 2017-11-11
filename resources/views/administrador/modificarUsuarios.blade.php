@extends('administrador.escritorio')

@section('content')
@if(isset($editar))
<div class="container row col-md-8 col-md-offset-2 ">
  <div class=" col-md-12 box box-primary">
    <div class="box-header with-border">
                  <h3 class="box-title"> Modificar usuario</h3>
                  @if(session()->has('message'))
                      <div class="alert alert-success">
                          {{ session()->get('message') }}
                      </div>
                  @endif
      </div><!-- /.box-header -->
      <form  role="form"   method="post"  action="{{ url('admin/modificarUsuario') }}" class="form-horizontal form_entrada" >

      <input type="hidden" name="id" value="{{ $usuario->id }}">
      
      {{ csrf_field() }}
      <div class="box-body">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="{{ $usuario->name }}">
                @if($errors->has('nombre'))
                  <span style="color: red;">{{ $errors->first('nombre') }}</span>
                @endif
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="mail" value="{{ $usuario->email }}">
                @if($errors->has('mail'))
                  <span style="color: red;">{{ $errors->first('mail') }}</span>
                @endif
              </div>

               <div class="form-group">
                <label for="usuario">usuario</label>
                <input type="text" class="form-control" name="usuario" value="{{ $usuario->user }}" disabled="true">
                 @if($errors->has('usuario'))
                  <span style="color: red;">{{ $errors->first('usuario') }}</span>
                @endif
              </div>

              <div class="form-group">
                <label for="contrasena">Password</label>
                <input type="password" class="form-control" name="contrasena" value="{{ $usuario->password }}">
                @if($errors->has('contrasena'))
                  <span style="color: red;">{{ $errors->first('contrasena') }}</span>
                @endif
              </div>


              <select name="idrol"class="form-control" >
                @if($usuario->idrol==4)
                  <option value="4" selected>Publico</option>
                  <option value="3" >Inspector</option>
                  <option value="2" >Jefatura</option>
                  <option value="1" >Administrador</option>
                @elseif($usuario->idrol==3)
                  <option value="4" >Publico</option>
                  <option value="3" selected>Inspector</option>
                  <option value="2" >Jefatura</option>
                  <option value="1" >Administrador</option>
                @elseif($usuario->idrol==2)
                  <option value="4" >Publico</option>
                  <option value="3" >Inspector</option>
                  <option value="2" selected>Jefatura</option>
                  <option value="1" >Administrador</option>
                @elseif($usuario->idrol==1) 
                  <option value="4" >Publico</option>
                  <option value="3" >Inspector</option>
                  <option value="2" >Jefatura</option>
                  <option value="1" selected>Administrador</option>
                @endif
              </select>

               <select name="estado"class="form-control">
               @if($usuario->state==1)
                  <option value="0">Inactivo</option>
                  <option value="1" selected>Activo</option>
                @elseif($usuario->state==0)
                  <option value="0" selected>Inactivo</option>
                  <option value="1" >Activo</option>
               @endif
              </select>

        </div>
        <button style="margin-bottom: 15px;" type="submit" class="btn btn-default btn-info">Actualizar usuario</button>
      </form>
      </div><!-- /.box -->
</div>
@endif
@endsection
