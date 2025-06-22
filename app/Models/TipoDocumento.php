<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipoDocumento'; // Nombre exacto de la tabla en tu BD
    public $timestamps = false; // Si tu tabla no tiene created_at/updated_at
}
