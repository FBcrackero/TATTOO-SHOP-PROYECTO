<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    protected $table = 'genero'; // Nombre exacto de la tabla en tu base de datos
    public $timestamps = false;  // Si tu tabla no tiene created_at/updated_at
}