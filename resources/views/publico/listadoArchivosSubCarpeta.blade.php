@extends('publico.escritorio')

@section('content')
  @include('publico.menuNavegacion')
<div class="container row col-md-12 contenedor-usuario">
  
          <div class="row tabla-usuarios">
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <th>Documento</th>
                  <th>Tipo</th>
                  <th>Fecha</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                 @if(isset($archivos))
                    @foreach($archivos as $a)
                      <tr>
                        <td>  
                          {{ $a->ruta_archivo}} 
                        </td>
                        <td>  {{ $a->tipo_id}} </td>
                        <td>  {{ $a->created_at}} </td>
                        <td> 
                            <a class="btn btn-info" target="_black" href="{{ url('public/verArchivo') }}/{{$a->ruta_archivo}}">Ver</a>
                            <form style="float: right;" action="{{ url('public/descargarArchivo') }}" method="get" id="form_{{ $a->id }}">
                                <input type="hidden" name="archivo" value="{{$a->ruta_archivo}}"/>
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