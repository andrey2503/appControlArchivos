@extends('inspector.escritorio')

@section('content')
<div class="container row col-md-12 contenedor-usuario">
  

          <!-- tabla principal de usuarios -->
          <div class="row tabla-usuarios">
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <th>#Expediente</th>
                  <th>Fecha</th>
                  <th>Direccion</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                  @if(isset($notificaciones))
                    @foreach($notificaciones as $n)
                      <tr>
                        <td>{{ $n->idFinca }}</td>
                        <td>{{ $n->fecha }}</td>
                        <td>{{ $n->direccion }}</td>


                        <td> <button onclick="responder()" class="btn btn-success btn-xs">Responder</button> </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
  
  function responder(){
    alert("responder");
  }
</script>

@endsection