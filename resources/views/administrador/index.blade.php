@extends('administrador.escritorio')

@section('content')
<div class="container row col-md-12 contenedor-usuario">
  

          <!-- tabla principal de usuarios -->
          <div class="row tabla-usuarios">
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <th>Nombre</th>
                  <th>Usuario</th>
                  <th>Email</th>
                  <th>Rol</th>
                  <th>Estado</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                  @if(isset($usuarios))
                    @foreach($usuarios as $u)
                      <tr>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->user }}</td>
                        <td>{{ $u->email }}</td>

                         @if($u->idrol==1)
                        <td>Administrador</td>
                        @elseif($u->idrol==2)
                        <td>Jefatura</td>
                        @elseif($u->idrol==3)
                        <td>Inspector</td>
                        @endif



                        @if($u->state==1)
                        <td>activo</td>
                        @else
                        <td>inactivo</td>
                        @endif
                        <td> <a class="btn btn-warning btn-xs" href="{{ url('admin/modificarUsuario') }}/{{$u->id}}">Modificar</a> </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
</div>

@endsection