@extends('jefatura.escritorio')

@section('content')
<div class="container row col-md-12 contenedor-usuario">
  
          @if($permiso)
          <div class="row tabla-usuarios">
          @include('jefatura.subirClausura')
          </div>
          @endif

          <!-- tabla principal de usuarios -->
          <div class="row tabla-usuarios">
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <th>Clausura</th>
                  <th>Notificacion</th>
                  <th>Permiso</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                 <tr>
                   <td><input type="file" name="" ></td>
                   <td><input type="file" name="" disabled="true"></td>
                   <td><input type="file" name="" disabled="true"></td>
                   <td><button class="btn">Cerrar</button></td>
                 </tr>
                </tbody>
              </table>
            </div>
          </div>
</div>

@endsection