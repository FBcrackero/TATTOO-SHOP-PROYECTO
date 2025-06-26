<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'factura';
    public $timestamps = false;
    protected $primaryKey = 'codFacturaProducto';
    protected $fillable = [
        'idUsuario', 'idFormaPago', 'fechaFactura', 'idEstado', 'ultimosTarjeta'
    ];

    public function productos()
    {
        return $this->hasMany(FacturaProducto::class, 'codFacturaProducto', 'codFacturaProducto');
    }

    public function usuario()
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'idUsuario', 'idUsuario');
    }
}
