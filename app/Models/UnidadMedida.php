<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    protected $table = 'unidadMedida'; 

    protected $primaryKey = 'idUnidadMedida'; 

    public $timestamps = false;

    protected $fillable = [
        'nombreUnidadMedida',
        'descripcionUnidadMedida',
        'nomenclaturaUnidadMedida',
        'idEstado'
    ];


    public function productos()
    {
        return $this->hasMany(Producto::class, 'idUnidadMedida', 'idUnidadMedida');
    }
}