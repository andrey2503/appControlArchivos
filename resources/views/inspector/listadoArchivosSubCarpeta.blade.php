@extends('inspector.escritorio')

@section('content')
  @include('inspector.menuNavegacion')
<div class="container row col-md-12 contenedor-usuario">
  

          <!-- tabla principal de usuarios -->
          @if($permiso)
          <div class="row tabla-usuarios">
          @include('inspector.subirArchivo')
          </div>
          @endif

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
                        <td> <a target="_black" href="../../..{{ Storage::url($a->ruta_archivo) }}" class="btn btn-info"> ver </a>
                        <a href="#"  class="btn btn-success"> descargar </a>
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