  <div class="" style="margin:15px;">
    <a class="btn btn-info " href="{{ url('jefat/verExpediente') }}/{{ $expediente }}">
    <span class="glyphicon glyphicon-circle-arrow-left"></span> regresar</a>
  </div>
  <form class="form-inline" action="{{ url('jefat/subirClausura')}}" method="post" enctype="multipart/form-data">
         {{ csrf_field() }}
         <input type="hidden" name="id" value="{{ $carpeta }}">
         <input type="hidden" name="expediente" value="{{ $expediente }}">
    <div class="form-group">
      <label for="archivo">Archivo</label>
      <input type="file" class="form-control" name="archivo" placeholder="Archivo">
    </div>
   <div class="form-group">
    <label for="fecha">Fecha de creacion</label>
    <input type="date" class="form-control" id="fecha" name="fecha" placeholder="Fecha">
   </div>
    
    <button type="submit" class="btn btn-success">Subir</button>
  </form>

