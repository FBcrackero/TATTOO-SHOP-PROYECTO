<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'pais'; // Nombre exacto de la tabla en tu base de datos
    public $timestamps = false;  // Si tu tabla no tiene created_at/updated_at
}
