<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class archivos_expediente extends Model
{
    //
    public function tipo()
    {
        return $this->belongsTo('App\tipo_documento');
    }
    
}
