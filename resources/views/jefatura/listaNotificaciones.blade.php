@extends('jefatura.escritorio')

@section('content')
<div class="container row col-md-12 contenedor-usuario">
  

          <!-- tabla principal de usuarios -->
          <div class="row tabla-usuarios">
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <th>Expediente</th>
                  <th>Fecha inicial</th>
                  <th>Fecha</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                  @if(isset($clausura_notificacion))
                    @foreach($clausura_notificacion as $cn)
                      <tr>
                        <td>{{ $cn->idFinca}}</td>
                        <td>{{ $cn->fecha_inicio}}</td>
                        <td>{{ $cn->fecha_revicion }}</td>
                        <td> <a class="btn btn-info btn-xs" href="{{ url('jefat/verExpediente') }}/{{$cn->idFinca}}">Ver expediente</a> </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
</div>

@endsection