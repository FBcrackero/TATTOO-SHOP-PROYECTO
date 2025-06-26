<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    public $timestamps = false;
    protected $primaryKey = 'codProducto';

    protected $fillable = [
        'nombreProducto',
        'descripcionProducto',
        'nomenclaturaProducto',
        'imagenProducto',
        'precioCompra',
        'stockMax',
        'stockMin',
        'cantidadDisponible',
        'idCategoria',
        'idUnidadMedida',
        'idEstado',
    ];

    // Relación con Estado
    public function estado()
    {
        return $this->belongsTo(\App\Models\Estado::class, 'idEstado', 'idEstado');
    }
}