<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfil';
    protected $primaryKey = 'idPerfil';
    public $timestamps = false;

    protected $fillable = [
        'nombrePerfil',
        'descripcionPerfil',
        'nomenclaturaPerfil',
        'idEstado'
    ];
}