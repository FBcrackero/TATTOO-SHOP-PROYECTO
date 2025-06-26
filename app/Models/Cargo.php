<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\Estado;



class Cargo extends Model
{
    protected $table = 'cargo'; 
    public $timestamps = false;
    protected $primaryKey = 'idCargo';

    protected $fillable = [
    'nombreCargo',
    'descripcionCargo',
    'nomenclaturaCargo',
    'sueldo',
    'idEstado',
    ];

    public function usuario()
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'idUsuario', 'idUsuario');
    }

    public function cargo()
    {
        return $this->belongsTo(\App\Models\Cargo::class, 'idCargo', 'idCargo');

    }
    
    public function estado()
    {
        return $this->belongsTo(\App\Models\Estado::class, 'idEstado', 'idEstado');
    }
}
