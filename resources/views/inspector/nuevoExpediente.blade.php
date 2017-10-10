@extends('inspector.escritorio')

@section('content')

<div class="container row col-md-8 col-md-offset-2 ">
  <div class=" col-md-12 box box-primary">
    <div class="box-header with-border">
                  <h3 class="box-title"> Nuevo Expediente</h3>
      </div><!-- /.box-header -->
      <form  role="form"   method="post"  action="{{ url('inspec/nuevoExpediente') }}" class="form-horizontal form_entrada" >
       {{ csrf_field() }}
      <div class="box-body">
            <div class="form-group">
                <label for="expediente">Numero finca</label>
                <input type="number" class="form-control" name="expediente" placeholder="finca">
                @if($errors->has('expediente'))
                  <span style="color: red;">{{ $errors->first('expediente') }}</span>
                @endif
            </div>

            <div class="form-group">
              <select class="form-control" name="distrito">
            @if(isset($distritos))
              @foreach($distritos as $d)
                <option value="{{ $d->id }}">{{ $d->distrito }}</option>
              @endforeach
            @endif
              </select>
            </div>

        </div>
        <button style="margin-bottom: 15px;" type="submit" class="btn btn-default btn-info">Crear Expediente</button>
      </form>
      </div><!-- /.box -->
</div>
@endsection
