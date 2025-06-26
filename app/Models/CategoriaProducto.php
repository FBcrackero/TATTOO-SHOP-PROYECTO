<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaProducto extends Model
{
    protected $table = 'categoriaProductos'; // Nombre exacto de la tabla

    protected $primaryKey = 'idCategoriaProducto'; // Llave primaria personalizada

    public $timestamps = false; // Si la tabla no tiene created_at y updated_at

    protected $fillable = [
        'nombreCategoriaProducto',
        'descripcionCategoriaProducto',
        'nomenclaturaCategoriaProducto',
        'idEstado'
    ];

    // Relación con productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'idCategoria', 'idCategoriaProducto');
    }

    public function estado()
    {
        return $this->belongsTo(\App\Models\Estado::class, 'idEstado', 'idEstado');
    }
}