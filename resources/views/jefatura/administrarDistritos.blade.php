@extends('jefatura.escritorio')

@section('content')
<div class="container row col-md-12 contenedor-usuario">
                  @if(session()->has('message'))
                      <div class="alert alert-success">
                          {{ session()->get('message') }}
                      </div>
                  @endif
 <form action="{{ url('jefat/administrarDistritos')}}" method="post">
 {{ csrf_field() }}
          <!-- tabla principal de usuarios -->
          <div class="row tabla-usuarios">
            <div class="table-responsive">
              <table  class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <th>ID</th>
                  <th>Distrito</th>
                  <th>Acción</th>
                </thead>
                <tbody>
               
                  @if(isset($distritos))
                    @foreach($distritos as $d)
                      <tr>
                        <input type="hidden" name="distrito[{{ $d->id }}]" value="{{ $d->id }}">
                        <td>{{ $d->id }}</td>
                        <td>{{ $d->distrito}}</td>

                        <td> 
                            <select class="form-control" name="usuario[{{ $d->id }}]">
                              @if(isset($usuarios))
                                @foreach($usuarios as $u)
                                  @if($u->idrol ==2 || $u->idrol ==3)
                                   
                                   @if(isset($distribucion) && count($distribucion) > 0 )
                                          <option
                                          @foreach($distribucion as $dt)
                                          
                                          @if($dt->id_usuario == $u->id && $d->id == $dt->id_distrito)
                                           selected
                                          @endif
                                          @endforeach
                                          value="{{$u->id}}" > {{ $u->user }}  </option>
                                     <!-- <option value="{{$u->id}}">{{ $u->user }}</option> -->
                                    @else
                                    <option value="{{$u->id}}">{{ $u->user }}</option>
                                   @endif

                                   
                                  @endif
                                @endforeach
                              @endif
                            </select> 
                        </td>
                      </tr>
                    @endforeach
                  @endif

                </tbody>
              </table>
              <button class="btn btn-success">Asignar distritos</button>
            </div>
          </div>
  </form>
</div>

@endsection