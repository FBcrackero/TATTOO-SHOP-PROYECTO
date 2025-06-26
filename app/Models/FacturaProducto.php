<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacturaProducto extends Model

{
    protected $table = 'facturaproducto';
    protected $fillable = [
        'codFacturaProducto',
        'codProducto',
        'fechaFacturaProducto',
        'Cantidad',
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'codFacturaProducto', 'codFacturaProducto');
    }

    public function producto()
    {
        return $this->belongsTo(\App\Models\Producto::class, 'codProducto', 'codProducto');
    }
}
