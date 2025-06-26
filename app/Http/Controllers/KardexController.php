<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KardexController extends Controller
{
    protected $fillable = [
    'cantKardEntrada',
    'cantKardSalida',
    'precioVenta',
    'fechaInventario',
    'codProducto',
];
}
