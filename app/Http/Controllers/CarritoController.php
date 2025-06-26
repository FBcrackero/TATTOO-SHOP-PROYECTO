<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\FormaPago;
use App\Models\Factura;
use App\Models\Kardex;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session('carrito', []);
        return view('carrito.carrito', compact('carrito'));
    }

        /**
     * Controlador para gestionar las operaciones del carrito de compras.
     *
     * Métodos:
     * - agregar(Request $request, $codProducto): Agrega un producto al carrito o incrementa su cantidad si ya existe.
     * - quitar($codProducto): Elimina un producto específico del carrito.
     * - vaciar(): Vacía completamente el carrito de compras.
     * - actualizar(Request $request, $codProducto): Actualiza la cantidad de un producto en el carrito, respetando el stock disponible.
     *
     * El carrito se almacena en la sesión del usuario como un array asociativo donde la clave es el código del producto.
     */

    public function agregar(Request $request, $codProducto)
    {
        $producto = Producto::findOrFail($codProducto);
        $carrito = session('carrito', []);
        $cantidad = $request->input('cantidad', 1);

        if(isset($carrito[$codProducto])){
            $carrito[$codProducto]['cantidad'] += $cantidad;
        } else {
            $carrito[$codProducto] = [
                'codProducto' => $producto->codProducto,
                'nombreProducto' => $producto->nombreProducto,
                'precioCompra' => $producto->precioCompra,
                'cantidad' => $cantidad,
            ];
        }

        session(['carrito' => $carrito]);
        $carritoCount = collect($carrito)->sum('cantidad');
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'carritoCount' => $carritoCount]);
        }
        return redirect()->route('carrito.index')->with('success', 'Producto agregado al carrito');
    }

    public function quitar($codProducto)
    {
        $carrito = session('carrito', []);
        unset($carrito[$codProducto]);
        session(['carrito' => $carrito]);
        return redirect()->route('carrito.index');
    }

    public function vaciar()
    {
        session()->forget('carrito');
        return redirect()->route('carrito.index');
    }

    public function actualizar(Request $request, $codProducto)
    {
        $carrito = session('carrito', []);
        $producto = Producto::findOrFail($codProducto);
        $cantidad = intval($request->input('cantidad', 1));
        $max = $producto->cantidadDisponible;

        if ($cantidad < 1) $cantidad = 1;
        if ($cantidad > $max) $cantidad = $max;

        if(isset($carrito[$codProducto])){
            $carrito[$codProducto]['cantidad'] = $cantidad;
            session(['carrito' => $carrito]);
        }

        return redirect()->route('carrito.index');
    }

    /**
     * Muestra la vista de checkout del carrito de compras.
     *
     * - Obtiene el carrito de la sesión.
     * - Si el carrito está vacío, redirige al índice del carrito con un mensaje.
     * - Obtiene todas las formas de pago disponibles.
     * - Retorna la vista 'carrito.checkout' con los datos necesarios.
     *
     */

    /**
     * Procesa el checkout del carrito de compras.
     *
     * - Valida los datos del formulario de pago.
     * - Si el carrito está vacío, redirige al índice del carrito con un mensaje.
     * - Inicia una transacción de base de datos.
     * - Crea una nueva factura con los datos del usuario y forma de pago.
     * - Por cada producto en el carrito:
     *   - Registra el producto en la tabla facturaproducto.
     *   - Actualiza el stock disponible del producto.
     *   - Registra la salida en el kardex.
     * - Si todo es exitoso, confirma la transacción y limpia el carrito de la sesión.
     * - Si ocurre un error, revierte la transacción y muestra un mensaje de error.
     *

     */
    
    public function checkout()
    {
        $carrito = session('carrito', []);
        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('success', 'El carrito está vacío.');
        }
        $formasPago = FormaPago::all();
        return view('carrito.checkout', compact('carrito', 'formasPago'));
    }

    public function procesarCheckout(Request $request)
    {

        \Log::info('Procesando checkout', $request->all());

        $request->validate([
            'idFormaPago' => 'required|exists:formapago,idFormaPago',
            'numero_tarjeta' => 'required|digits_between:16,19',
            'nombre_tarjeta' => 'required|string|max:50',
            'vencimiento' => 'required|regex:/^\d{2}\/\d{2}$/',
            'cvv' => 'required|digits_between:3,4',
        ]);

        $carrito = session('carrito', []);
        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('success', 'El carrito está vacío.');
        }

        DB::beginTransaction();
        try {
            // 1. Crear la factura
            $factura = new Factura();
            $factura->idUsuario = auth()->user()->idUsuario;
            $factura->idFormaPago = $request->idFormaPago;
            $factura->fechaFactura = now()->toDateString();
            $factura->idEstado = 1; 
            $factura->ultimosTarjeta = substr($request->numero_tarjeta, -4);
            $factura->save();
            \Log::info('Factura guardada', ['codFacturaProducto' => $factura->codFacturaProducto]);

            // 2. Registrar los productos en facturaproducto y actualizar stock/kardex
            foreach ($carrito as $item) {
                \Log::info('Insertando en facturaproducto', [
                    'codFacturaProducto' => $factura->codFacturaProducto,
                    'codProducto' => $item['codProducto'],
                    'Cantidad' => $item['cantidad'],
                ]);
                // a) Registrar en facturaproducto
                DB::table('facturaproducto')->insert([
                    'codFacturaProducto' => $factura->codFacturaProducto,
                    'codProducto' => $item['codProducto'],
                    'fechaFacturaProducto' => now()->toDateString(),
                    'Cantidad' => $item['cantidad'],
                ]);

                // b) Actualizar stock del producto
                $producto = Producto::find($item['codProducto']);
                if ($producto) {
                    $producto->cantidadDisponible = max(0, $producto->cantidadDisponible - $item['cantidad']);
                    $producto->save();
                }

                // c) Registrar salida en kardex
                Kardex::create([
                    'cantKardEntrada' => 0,
                    'cantKardSalida' => $item['cantidad'],
                    'precioVenta' => $item['precioCompra'],
                    'fechaInventario' => now()->toDateString(),
                    'codProducto' => $item['codProducto'],
                ]);
            }

            DB::commit();
            session()->forget('carrito');
            return redirect()->route('carrito.index')->with('success', '¡Compra realizada con éxito!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al procesar la compra', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('checkout')->with('error', 'Error al procesar la compra: ' . $e->getMessage());
        }
    }
}