<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Expediente extends Model
{
    //
     //
     use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $primaryKey = 'finca';
    public $incrementing = false;
    protected $fillable = [
        'finca', 'estado', 'user_id','distrito_id',
    ];

    public function notificacion(){
        return $this->belongsTo('App\Notificacion');
    }// fin de la reacion notificacion
}
