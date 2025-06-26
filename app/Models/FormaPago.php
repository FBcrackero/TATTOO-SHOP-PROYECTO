<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Estado;

class FormaPago extends Model
{
    protected $table = 'formapago';
    protected $primaryKey = 'idFormaPago';
    public $timestamps = false;

    protected $fillable = [
        'nombreFormaPago',
        'descripcionFormaPago',
        'nomenclaturaFormaPago',
    ];

    public function estado()
    {
        return $this->belongsTo(\App\Models\Estado::class, 'idEstado', 'idEstado');
    }
}
