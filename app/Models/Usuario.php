<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario'; // Nombre real de tu tabla
    protected $primaryKey = 'idUsuario'; // Tu clave primaria

    public $timestamps = false; // Si tu tabla no tiene created_at/updated_at

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

    // Laravel espera 'password' como campo de contraseña
    public function getAuthPassword()
    {
        return $this->Contrasena;
    }

    // Si quieres que el login use 'emailUsu' en vez de 'email'
    public function getAuthIdentifierName()
    {
        return 'emailUsu';
    }
}