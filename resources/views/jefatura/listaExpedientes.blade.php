@extends('jefatura.escritorio')

@section('content')
<div class="container row col-md-12 contenedor-usuario">
  

          <!-- tabla principal de usuarios -->
          <div class="row tabla-usuarios">
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <th>#Expediente</th>
                  <th>Estado</th>
                  <th>Distrito</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                  @if(isset($expedientes))
                    @foreach($expedientes as $u)
                      <tr>
                        <td>{{ $u->finca }}</td>

                         @if($u->estado==1)
                        <td>Abierto</td>
                        @elseif($u->estado==0)
                        <td>Cerrado</td>
                        @endif
                        <td>{{ $u->distrito_id }}</td>

                        <td> <a class="btn btn-warning btn-xs" href="{{ url('jefat/verExpediente') }}/{{$u->finca}}">Ver expediente</a> </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
</div>

@endsection