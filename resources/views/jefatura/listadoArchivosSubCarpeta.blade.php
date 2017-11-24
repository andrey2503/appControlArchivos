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
             @include('jefatura.subirArchivo')
          </div>
          @endif

          <div class="row tabla-usuarios">
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <th>Documento</th>
                  <th>Tipo</th>
                  <th>Fecha subida</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                 @if(isset($archivos))
                    @foreach($archivos as $a)
                      <tr>
                        <td>  {{ $a->ruta_archivo}}  </td>
                        <td>  {{ $a->tipo_id}} </td>
                        <td>  {{ $a->created_at}} </td>
                        <td>
                        <div class="row">
                          <a class="col-md-2 btn btn-info " target="_black" href="{{ url('jefat/verArchivo') }}/{{$a->ruta_archivo}}">Ver</a>
                          <form class="col-md-3 " action="{{ url('jefat/descargarArchivo') }}" method="get" id="form_{{ $a->id }}">
                            <input type="hidden" name="archivo" value="{{$a->ruta_archivo}}"/>
                            <button type="submit" class="btn btn-success "> descargar </button>
                        </form>
                        @if($permiso)
                        <button type="button" class="btn btn-danger col-md-3" onclick="confirmarEliminar('{{$a->id }}','{{$a->ruta_archivo}}')" data-toggle="modal" data-target="#exampleModal">Eliminar</button>

                          
                        @endif
                        
                        </div>
                        </td>
                      </tr>
                    @endforeach
                 @endif
                </tbody>
              </table>
            </div>
          </div>
</div>




<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <p>Eliminar archivo</p>
          <form class="form-group " action="{{ url('jefat/eliminar') }}" method="post">
                        {{ csrf_field() }}
                         <input class="form-control" disabled name="archivo" value="" id="eliminarArchivoRuta"/>
                         <input type="hidden" name="id" value="" id="eliminarArchivoId"/>
                         <input type="hidden" name="carpeta" value="1"/>
                            
          </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-danger "> Confirimar eliminar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
       </form>

    </div>
  </div>
</div>
<script type="text/javascript">
  function confirmarEliminar(id,archivo){
    alert("eliminar "+id);
    $('#eliminarArchivoRuta').val(archivo);
    $('#eliminarArchivoId').val(id);
  }// fin de confirmar eliminar
</script>


@endsection

