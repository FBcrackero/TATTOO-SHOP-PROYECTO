<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class InventarioController
 *
 * Controlador para la gestión del inventario en la aplicación.
 * Proporciona funcionalidades para visualizar el inventario, registrar entradas y salidas,
 * consultar y generar reportes del kardex.
 *
 * Métodos:
 * - index(): Muestra la vista principal del inventario.
 * - entrada(): Muestra la vista para registrar una entrada de inventario.
 * - registrarEntrada(Request $request): Valida y registra una entrada de inventario, actualiza el stock y el kardex.
 * - salida(): Muestra la vista para registrar una salida de inventario.
 * - consultarKardex(Request $request): Consulta los movimientos del kardex con filtros por tipo, producto y fecha.
 * - reporteKardex(Request $request): Genera un reporte del kardex con filtros por tipo, producto y fecha.
 *
 */

class InventarioController extends Controller
{
    // Vista principal del inventario
    public function index()
    {
        return view('inventario.inventario');
    }


    public function entrada()
    {
        return view('inventario.entrada');
    }
    // Vista para registrar una entrada de inventario

    public function registrarEntrada(Request $request)
    {
        $request->validate([
            'codProducto' => 'required|exists:producto,codProducto',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'nullable|numeric|min:0',
        ]);

        // Actualizar stock del producto
        $producto = \App\Models\Producto::findOrFail($request->codProducto);
        $producto->cantidadDisponible += $request->cantidad;
        $producto->save();

        // Registrar entrada en kardex
        \App\Models\Kardex::create([
            'cantKardEntrada' => $request->cantidad,
            'cantKardSalida' => 0,
            'precioVenta' => $request->precio ?? $producto->precioCompra,
            'fechaInventario' => now()->toDateString(),
            'codProducto' => $producto->codProducto,
        ]);

        return redirect()->route('inventario.index')->with('success', '¡Entrada registrada en el inventario!');
    }

    // Vista para registrar una salida de inventario
    public function salida()
    {
        // Aquí puedes retornar una vista para registrar salidas
        return view('inventario.salida');
    }

    public function consultarKardex(Request $request)
    {
        $query = \App\Models\Kardex::with('producto');

        // Filtro por tipo de movimiento
        if ($request->filled('tipo')) {
            if ($request->tipo == 'entrada') {
                $query->where('cantKardEntrada', '>', 0);
            } elseif ($request->tipo == 'salida') {
                $query->where('cantKardSalida', '>', 0);
            }
        }

        // Filtro por producto
        if ($request->filled('producto')) {
            $query->where('codProducto', $request->producto);
        }

        // Filtro por fecha
        if ($request->filled('fecha')) {
            $query->where('fechaInventario', $request->fecha);
        }

        $kardex = $query->orderBy('fechaInventario', 'desc')->get();
        $productos = \App\Models\Producto::all();

        return view('inventario.consultarKardex', compact('kardex', 'productos'));
    }

    public function reporteKardex(Request $request)
    {
        $query = \App\Models\Kardex::with('producto');

        if ($request->filled('tipo')) {
            if ($request->tipo == 'entrada') {
                $query->where('cantKardEntrada', '>', 0);
            } elseif ($request->tipo == 'salida') {
                $query->where('cantKardSalida', '>', 0);
            }
        }
        if ($request->filled('producto')) {
            $query->where('codProducto', $request->producto);
        }
        if ($request->filled('fecha')) {
            $query->where('fechaInventario', $request->fecha);
        }

        $kardex = $query->orderBy('fechaInventario', 'desc')->get();

        return view('inventario.reporteKardex', compact('kardex'));
    }

}