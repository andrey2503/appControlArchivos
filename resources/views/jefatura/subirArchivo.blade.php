  @if(isset($tipo_documento))
  <form class="form-inline" action="{{ url('jefat/subirArchivo')}}" method="post" enctype="multipart/form-data">
         {{ csrf_field() }}
    <div class="form-group">
      <label for="archivo">Archivo</label>
      <input type="file" class="form-control" name="archivo" placeholder="Archivo">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail2">Tipo de documento</label>
      <select class="form-control" name="tipo">
  	  @foreach($tipo_documento as $t)
        <option  value="{{ $t->id }}">{{ $t->tipo }}</option>
      @endforeach
  	</select>
    </div>
    <button type="submit" class="btn btn-success">Subir</button>
  </form>
  @endif