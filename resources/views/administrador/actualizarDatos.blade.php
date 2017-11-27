@extends('administrador.escritorio')

@section('content')

<div class="container row col-md-8 col-md-offset-2 ">
  <div class=" col-md-12 box box-primary">
    <div class="box-header with-border">
                  <h3 class="box-title"> Actualziar Datos</h3>
                  @if(session()->has('message'))
                      <div class="alert alert-success">
                          {{ session()->get('message') }}
                      </div>
                  @endif
      </div><!-- /.box-header -->
      <form  role="form"   method="post"  action="{{ url('admin/actualizarDatos') }}" class="form-horizontal form_entrada" >
       {{ csrf_field() }}
      <div class="box-body">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="name" value="{{$usuario->name}}">
                @if($errors->has('nombre'))
                  <span style="color: red;">{{ $errors->first('nombre') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="mail" class="form-control" name="email" value="{{$usuario->email}}">
                @if($errors->has('email'))
                  <span style="color: red;">{{ $errors->first('email') }}</span>
                @endif
            </div>
        </div>
        <button style="margin-bottom: 15px;" type="submit" class="btn btn-success">Actualizar datos</button>
      </form>
      </div><!-- /.box -->
</div>
@endsection
