<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;

/**
 * Controlador FacturaController
 *
 * Este controlador gestiona las operaciones relacionadas con las facturas,
 * incluyendo el historial de compras del usuario autenticado, la visualización
 * e impresión de detalles de una factura, la consulta de facturas con filtros
 * y la generación de reportes.
 *
 * Métodos:
 * - historial(): Muestra el historial de compras del usuario autenticado, incluyendo productos y usuario relacionado.
 * - imprimir($id): Muestra la vista de impresión/detalle de una factura específica, validando la pertenencia al usuario autenticado.
 * - consultar(Request $request): Permite consultar facturas aplicando filtros por usuario, fecha, estado o búsqueda general.
 * - reporte(Request $request): Genera un reporte de facturas aplicando los mismos filtros que el método consultar.
 *
 * Relaciones cargadas:
 * - productos.producto: Productos asociados a la factura.
 * - usuario: Usuario asociado a la factura.
 *
 * Filtros disponibles en consultar y reporte:
 * - usuario: Filtra por nombre o apellido del usuario.
 * - fecha: Filtra por fecha de la factura.
 * - estado: Filtra por estado de la factura (pagada o pendiente).
 * - general: Búsqueda general por código de factura o datos del usuario.
 */

class FacturaController extends Controller
{
    // Historial de compras del usuario autenticado
    public function historial()
    {
        $facturas = Factura::where('idUsuario', auth()->user()->idUsuario)
            ->with(['productos.producto', 'usuario']) // <- Esto es correcto
            ->orderBy('fechaFactura', 'desc')
            ->get();

        return view('factura.historial', compact('facturas'));
    }

    // Vista de impresión/detalle de una factura
    public function imprimir($id)
    {
        $factura = Factura::with(['productos.producto', 'usuario'])->findOrFail($id);

        // Validar que la factura pertenezca al usuario autenticado
        if ($factura->idUsuario !== auth()->user()->idUsuario) {
            abort(403, 'No tienes permiso para ver esta factura.');
        }

        return view('factura.imprimir', compact('factura'));
    }

    public function consultar(Request $request)
    {
        $query = \App\Models\Factura::with(['productos.producto', 'usuario']);

        // Filtros
        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            switch ($request->filtro) {
                case 'usuario':
                    $query->whereHas('usuario', function($q) use ($busqueda) {
                        $q->where('nombresUsu', 'like', "%$busqueda%")
                        ->orWhere('apellidosUsu', 'like', "%$busqueda%");
                    });
                    break;
                case 'fecha':
                    $query->where('fechaFactura', 'like', "%$busqueda%");
                    break;
                case 'estado':
                    if (strtolower($busqueda) == 'pagada') {
                        $query->where('idEstado', 1);
                    } elseif (strtolower($busqueda) == 'pendiente') {
                        $query->where('idEstado', '!=', 1);
                    }
                    break;
                case 'general':
                    $query->where(function($q) use ($busqueda) {
                        $q->where('codFacturaProducto', 'like', "%$busqueda%")
                        ->orWhereHas('usuario', function($q2) use ($busqueda) {
                            $q2->where('nombresUsu', 'like', "%$busqueda%")
                                ->orWhere('apellidosUsu', 'like', "%$busqueda%");
                        });
                    });
                    break;
            }
        }

        $facturas = $query->orderBy('fechaFactura', 'desc')->get();

        return view('factura.consultarFacturas', compact('facturas'));
    }

    public function reporte(Request $request)
{
    $query = \App\Models\Factura::with(['productos.producto', 'usuario']);

    // Filtros (igual que en consultar)
    if ($request->filled('busqueda')) {
        $busqueda = $request->busqueda;
        switch ($request->filtro) {
            case 'usuario':
                $query->whereHas('usuario', function($q) use ($busqueda) {
                    $q->where('nombresUsu', 'like', "%$busqueda%")
                      ->orWhere('apellidosUsu', 'like', "%$busqueda%");
                });
                break;
            case 'fecha':
                $query->where('fechaFactura', 'like', "%$busqueda%");
                break;
            case 'estado':
                if (strtolower($busqueda) == 'pagada') {
                    $query->where('idEstado', 1);
                } elseif (strtolower($busqueda) == 'pendiente') {
                    $query->where('idEstado', '!=', 1);
                }
                break;
            case 'general':
                $query->where(function($q) use ($busqueda) {
                    $q->where('codFacturaProducto', 'like', "%$busqueda%")
                      ->orWhereHas('usuario', function($q2) use ($busqueda) {
                          $q2->where('nombresUsu', 'like', "%$busqueda%")
                             ->orWhere('apellidosUsu', 'like', "%$busqueda%");
                      });
                });
                break;
        }
    }

    $facturas = $query->orderBy('fechaFactura', 'desc')->get();

    return view('factura.reporteFactura', compact('facturas'));
}

    
}