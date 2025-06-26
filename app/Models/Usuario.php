<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'idUsuario'; 
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false; 

    protected $fillable = [
        'nombresUsu',
        'apellidosUsu',
        'celularUsu',
        'NidentificacionUsu',
        'fechaNacUsu',
        'emailUsu',
        'Contrasena',
        'idTipoDocumento',
        'idPerfil',
        'idCiudad',
        'idGenero',
        'idEstado'
    ];

 
    public function getAuthPassword()
    {
        return $this->Contrasena;
    }

    
    public function getAuthIdentifierName()
    {
        return 'idUsuario';
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(\App\Models\TipoDocumento::class, 'idTipoDocumento', 'idTipoDocumento');
    }

    public function perfil() {
        return $this->belongsTo(\App\Models\Perfil::class, 'idPerfil', 'idPerfil');
    }

    public function genero() { return $this->belongsTo(\App\Models\Genero::class, 'idGenero', 'idGenero'); }
    public function ciudad() { return $this->belongsTo(\App\Models\Ciudad::class, 'idCiudad', 'idCiudad'); }

}