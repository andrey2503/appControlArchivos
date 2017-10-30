  <form class="form-inline" action="{{ url('jefat/subirClausura')}}" method="post" enctype="multipart/form-data">
         {{ csrf_field() }}
         <input type="hidden" name="id" value="{{ $carpeta }}">
         <input type="hidden" name="expediente" value="{{ $expediente }}">
    <div class="form-group">
      <label for="archivo">Archivo</label>
      <input type="file" class="form-control" name="archivo" placeholder="Archivo">
    @if($errors->has('archivo'))
                  <span style="color: red;">{{ $errors->first('archivo') }}</span>
    @endif
    </div>
   <div class="form-group">
    <label for="fecha">Fecha</label>
    <input type="date" class="form-control" id="fecha" name="fecha" placeholder="Fecha">
    @if($errors->has('fecha'))
                  <span style="color: red;">{{ $errors->first('fecha') }}</span>
    @endif
   </div>

    <label class="checkbox-inline">
      <input checked="true" class="checkbox" type="checkbox" id="inlineCheckbox1" value="1" name="checkbox"> Bien
    </label>
    <label class="checkbox-inline">
      <input class="checkbox" type="checkbox" id="inlineCheckbox2" value="2"> Clausurado
    </label>
    <label class="checkbox-inline">
      <input class="checkbox" type="checkbox" id="inlineCheckbox3" value="3"> Notificado
    </label>
    <label class="checkbox-inline">
      <input class="checkbox" type="checkbox" id="inlineCheckbox4" value="4"> Transferido
    </label>

    
    <button type="submit" class="btn btn-success">Subir</button>
  </form>
@section('scripts')

  <script type="text/javascript">

     $('.checkbox').on('change', function() {
        $('.checkbox').prop('checked', false);
        $(".checkbox").attr('name','false');
        $("#"+this.id).attr('name','checkbox');
        $("#"+this.id).prop('checked', true);
       
      });
    
  </script>

@endsection