<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reserva'; 
    protected $primaryKey = 'idReserva'; 
    public $timestamps = false; 

    protected $fillable = [
        'idUsuario',
        'idArtista',
        'idServicio',
        'fechaReserva',
        'horaReserva',
        'descripcionReserva',
    ];

    public function servicio()
    {
        return $this->belongsTo(\App\Models\Servicio::class, 'idServicio', 'idServicio');
    }
    public function artista() 
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'idArtista', 'idUsuario');
    }
    public function usuario()
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'idUsuario', 'idUsuario');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(\App\Models\TipoDocumento::class, 'idTipoDocumento', 'idTipoDocumento');
    }

    public function estado()
    {
        return $this->belongsTo(\App\Models\Estado::class, 'idEstado', 'idEstado');
    }

}