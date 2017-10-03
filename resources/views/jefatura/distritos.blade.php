@extends('jefatura.escritorio')

@section('content')
<div class="container row col-md-12 contenedor-usuario">
  

          <!-- tabla principal de usuarios -->
          <div class="row tabla-usuarios">
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <th>ID</th>
                  <th>Distrito</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                  @if(isset($distritos))
                    @foreach($distritos as $d)
                      <tr>
                        <td>{{ $d->id }}</td>
                        <td>{{ $d->distrito}}</td>

                        <td> <a class="btn btn-info btn-xs" href="{{ url('jefat/expedientes') }}/{{$d->id}}">Ver expedientes</a> </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
</div>

@endsection