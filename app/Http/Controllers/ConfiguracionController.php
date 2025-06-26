<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controlador ConfiguracionController
 *
 * Este controlador gestiona las vistas y la lógica relacionada con la configuración
 * de la aplicación, incluyendo empleados, cargos, categorías, estados y tipos de documento.
 *
 * Métodos:
 * - index(): Muestra la vista principal de configuración.
 * - empleado(): Muestra la vista y lógica para la gestión de empleados.
 * - cargo(): Muestra la vista y lógica para la gestión de cargos.
 * - categoria(): Muestra la vista y lógica para la gestión de categorías.
 * - estado(): Muestra la vista y lógica para la gestión de estados.
 * - tipodocumento(): Muestra la vista y lógica para la gestión de tipos de documento.
 */


class ConfiguracionController extends Controller
{
    public function index() {
        return view('configuración.configuracion');
    }

    public function empleado() {
        // lógica y vista para empleados
        return view('configuración.empleado');
    }

    public function cargo() {
        // lógica y vista para cargos
        return view('configuración.cargo');
    }

    public function categoria() {
        // lógica y vista para categorías
        return view('configuración.categoria');
    }

    public function estado() {
        // lógica y vista para estados
        return view('configuración.estado');
    }

    public function tipodocumento() {
        // lógica y vista para tipos de documento
        return view('configuración.tipodocumento');
    }
}
