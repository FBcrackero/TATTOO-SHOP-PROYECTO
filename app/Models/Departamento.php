<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Eloquent para la tabla 'departamento'.
 *
 * Esta clase representa el modelo de la tabla 'departamento' en la base de datos.
 * No utiliza las marcas de tiempo (created_at, updated_at).
 *
 */
class Departamento extends Model
{
    protected $table = 'departamento'; 
    public $timestamps = false;        
}