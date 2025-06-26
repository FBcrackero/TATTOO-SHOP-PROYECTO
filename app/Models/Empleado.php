<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\Cargo;
use App\Models\Estado;

/**
 * Class Empleado
 *
 * Modelo Eloquent que representa la tabla 'empleado'.
 *
 * Propiedades:
 *  int $idEmpleado                Identificador primario del empleado.
 *  string $fechaVinculacionEmpleado Fecha de vinculación del empleado.
 *  string $numeroContrato         Número de contrato del empleado.
 *  int $idCargo                   Identificador del cargo asociado.
 *  int $idUsuario                 Identificador del usuario asociado.
 *  int $idEstado                  Identificador del estado asociado.
 *
 * Relaciones:
 *  \App\Models\Usuario $usuario   Usuario relacionado con el empleado.
 *  \App\Models\Cargo $cargo       Cargo relacionado con el empleado.
 *  \App\Models\Estado $estado     Estado relacionado con el empleado.
 *
 *  static \Illuminate\Database\Eloquent\Builder|Empleado newModelQuery()
 *  static \Illuminate\Database\Eloquent\Builder|Empleado newQuery()
 *  static \Illuminate\Database\Eloquent\Builder|Empleado query()
 */

class Empleado extends Model
{
    protected $table = 'empleado'; 
    public $timestamps = false;
    protected $primaryKey = 'idEmpleado';

    protected $fillable = [
    'fechaVinculacionEmpleado',
    'numeroContrato',
    'idCargo',
    'idUsuario',
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