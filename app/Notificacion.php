<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Notificacion extends Model
{
    //
     use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'idFinca', 'fecha','archivo_id','user_id','tipo_archivo',
    ];

    public function expedientes(){
        return $this->hasMany('App\Expediente');
    }
}
