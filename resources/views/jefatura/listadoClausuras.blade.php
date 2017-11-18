@extends('jefatura.escritorio')

@section('content')
  @include('jefatura.menuNavegacion')
<div class="container row col-md-12 contenedor-usuario">
          @if(session()->has('message'))
                      <div class="alert alert-success">
                          {{ session()->get('message') }}
                      </div>
          @endif

          <!-- tabla principal de usuarios -->
          @if($permiso)
          <div class="row tabla-usuarios">
             @include('jefatura.subirClausura')
          </div>
          @endif

          <div class="row tabla-usuarios">
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <th>Documento</th>
                  <th>Fecha Inicio</th>
                  <th>Fecha Inspección</th>
                  <th>Estado</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                 @if(isset($archivos))
                    @foreach($archivos as $a)
                      <tr>
                        <td>  {{ $a->rutaArchivo}}  </td>
                        <td>  {{ $a->fecha_inicio}} </td>
                        <td>  {{ $a->fecha_revicion}} </td>
                        @if($a->estado==1)
                          <td> Activa </td>
                        @else
                          <td> Cerrada </td>
                        @endif
                        <td>
                        <a class="btn btn-info" target="_black" href="{{ url('jefat/verArchivo') }}/{{$a->rutaArchivo}}">Ver</a>
                        <form style="float: right;" action="{{ url('jefat/descargarArchivo') }}" method="get" id="form_{{ $a->id }}">
                            <input type="hidden" name="archivo" value="{{$a->rutaArchivo}}"/>
                            <button type="submit" class="btn btn-success"> descargar </button>
                        </form>
                        </td>
                      </tr>
                    @endforeach
                 @endif
                </tbody>
              </table>
            </div>
          </div>
</div>

@endsection

