@extends('jefatura.escritorio')

@section('content')
  @include('jefatura.menuNavegacion')
<div class="container row col-md-12 contenedor-usuario">
  

          <!-- tabla principal de usuarios -->
          <div class="row tabla-usuarios">
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <th>#Expediente</th>
                  <th>Estado</th>
                  <th>Distrito</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @if(isset($expedientes))
                    @foreach($expedientes as $exp)
                      <tr>
                        <td>{{ $exp->finca }}</td>

                         @if($exp->estado==1)
                        <td >
                        <div class="bg-green" style="text-align: center;width: 30%;height: 30%">
                          <span class="glyphicon glyphicon-folder-open"></span>
                        </div>
                        </td>
                        @elseif($exp->estado==2)
                          <td >
                            <div class="bg-yellow" style="text-align: center;width: 30%;height: 30%">
                              <span class="glyphicon glyphicon-folder-open"></span>
                            </div>
                        </td>
                        @elseif($exp->estado==3)
                          <td >
                            <div class="bg-red" style="text-align: center;width: 30%;height: 30%">
                              <span class="glyphicon glyphicon-folder-open"></span>
                            </div>
                        </td>
                        @elseif($exp->estado==4)
                          <td >
                            <div class="bg-black" style="text-align: center;width: 30%;height: 30%">
                              <span class="glyphicon glyphicon-folder-open"></span>
                            </div>
                        </td>
                        @endif
                        <td>{{ $exp->distrito->distrito }}</td>
                        <td> <a class="btn btn-warning btn-xs" href="{{ url('jefat/verExpediente') }}/{{$exp->finca}}">Ver expediente</a> </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
</div>

@endsection