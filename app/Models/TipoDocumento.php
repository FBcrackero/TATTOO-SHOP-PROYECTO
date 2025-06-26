<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipoDocumento'; 
    protected $primaryKey = 'idTipoDocumento'; 
    public $timestamps = false; 

   public function estado()
    {
        return $this->belongsTo(\App\Models\Estado::class, 'idEstado', 'idEstado');
    }
}
