<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\CategoriaProducto;
use App\Models\UnidadMedida;
use App\Models\Estado;

/**
 * Class ProductoController
 *
 * Controlador para la gestión de productos en la aplicación.
 * Proporciona funcionalidades para listar, crear, modificar, eliminar, consultar,
 * generar reportes y actualizar el estado de los productos.
 *
 * Métodos:
 * - index(Request $request): Muestra la lista de productos activos, con filtros opcionales por categoría y precio máximo.
 * - create(): Muestra el formulario para crear un nuevo producto.
 * - store(Request $request): Valida y almacena un nuevo producto en la base de datos, incluyendo la gestión de imágenes.
 * - modificar(Request $request): Muestra el formulario para modificar productos existentes, permitiendo seleccionar uno.
 * - update(Request $request, $id): Valida y actualiza los datos de un producto existente, incluyendo la gestión de imágenes.
 * - eliminar(Request $request): Muestra el formulario para eliminar productos, permitiendo seleccionar uno.
 * - destroy($id): Elimina un producto de la base de datos.
 * - consultar(Request $request): Permite consultar productos mediante diferentes filtros de búsqueda.
 * - reporte(Request $request): Genera un reporte de productos según filtros de búsqueda.
 * - estado(Request $request): Muestra el formulario para cambiar el estado de un producto.
 * - estadoUpdate(Request $request, $id): Actualiza el estado de un producto.
 * - cancelar($id): Cancela una reserva asociada a un producto si corresponde al usuario autenticado.
 *
 * Dependencias:
 * - Models: Producto, CategoriaProducto, UnidadMedida, Estado, Reserva
 * - Request: Illuminate\Http\Request
 * - Auth: Illuminate\Support\Facades\Auth
 *
 * Notas:
 * - Se maneja la carga y almacenamiento de imágenes para los productos.
 * - Se valida la existencia de relaciones foráneas antes de crear o actualizar productos.
 * - Se utilizan vistas específicas para cada funcionalidad relacionada con productos.
 */

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::where('idEstado', 1);

        if ($request->filled('categorias')) {
            $query->whereIn('idCategoria', $request->categorias);
        }
        if ($request->filled('precio_max')) {
            $query->where('precioCompra', '<=', $request->precio_max);
        }

        $productos = $query->get();
        $categorias = \App\Models\CategoriaProducto::all();

        return view('productos.productos', compact('productos', 'categorias'));
    }
    public function create()
    {
        $categorias = CategoriaProducto::all();
        $unidades = UnidadMedida::all();
        return view('productos.ingresarProductos', compact('categorias', 'unidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombreProducto' => 'required|max:40',
            'descripcionProducto' => 'required|max:60',
            'nomenclaturaProducto' => 'required|max:4',
            'stockMin' => 'required|integer|min:0',
            'stockMax' => 'required|integer|min:0',
            'cantidadDisponible' => 'required|integer|min:0',
            'idCategoria' => 'required|exists:categoriaProductos,idCategoriaProducto',
            'idUnidadMedida' => 'required|exists:unidadMedida,idUnidadMedida',
            'precioCompra' => 'required|numeric|min:0',
            'imagenProducto' => 'nullable|image|max:2048',
        ]);

        // Manejo de imagen
        $fileName = null;
        if ($request->hasFile('imagenProducto')) {
            $nombreImagen = $request->nombreImagen ?: uniqid('producto_');
            $file = $request->file('imagenProducto');
            $extension = $file->getClientOriginalExtension();
            $fileName = $nombreImagen . '.' . $extension;
            $file->move(public_path('imagenes/imgProductos'), $fileName);
        }

        Producto::create([
            'nombreProducto' => $request->nombreProducto,
            'descripcionProducto' => $request->descripcionProducto,
            'nomenclaturaProducto' => $request->nomenclaturaProducto,
            'stockMin' => $request->stockMin,
            'stockMax' => $request->stockMax,
            'cantidadDisponible' => $request->cantidadDisponible,
            'idCategoria' => $request->idCategoria,
            'idUnidadMedida' => $request->idUnidadMedida,
            'precioCompra' => $request->precioCompra,
            'imagenProducto' => $fileName,
            'idEstado' => $request->idEstado,
        ]);

        return redirect()->route('productos')->with('success', 'Producto ingresado correctamente.');
    }

    public function modificar(Request $request)
    {
        $productos = Producto::all();
        $categorias = CategoriaProducto::all();
        $unidades = UnidadMedida::all();
        $productoSeleccionado = null;

        if ($request->filled('producto_id')) {
            $productoSeleccionado = Producto::find($request->producto_id);
        }

        return view('productos.modificarProductos', compact('productos', 'categorias', 'unidades', 'productoSeleccionado'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombreProducto' => 'required|max:40',
            'descripcionProducto' => 'required|max:60',
            'nomenclaturaProducto' => 'required|max:4',
            'stockMin' => 'required|integer|min:0',
            'stockMax' => 'required|integer|min:0',
            'cantidadDisponible' => 'required|integer|min:0',
            'idCategoria' => 'required|exists:categoriaProductos,idCategoriaProducto',
            'idUnidadMedida' => 'required|exists:unidadMedida,idUnidadMedida',
            'precioCompra' => 'required|numeric|min:0',
            'imagenProducto' => 'nullable|image|max:2048',
        ]);

        $producto = Producto::findOrFail($id);

        // Manejo de imagen
        if ($request->hasFile('imagenProducto')) {
            $nombreImagen = $request->nombreImagen ?: uniqid('producto_');
            $file = $request->file('imagenProducto');
            $extension = $file->getClientOriginalExtension();
            $fileName = $nombreImagen . '.' . $extension;
            $file->move(public_path('imagenes/imgProductos'), $fileName);
            $producto->imagenProducto = $fileName;
        }

        $producto->update([
            'nombreProducto' => $request->nombreProducto,
            'descripcionProducto' => $request->descripcionProducto,
            'nomenclaturaProducto' => $request->nomenclaturaProducto,
            'stockMin' => $request->stockMin,
            'stockMax' => $request->stockMax,
            'cantidadDisponible' => $request->cantidadDisponible,
            'idCategoria' => $request->idCategoria,
            'idUnidadMedida' => $request->idUnidadMedida,
            'precioCompra' => $request->precioCompra,
            'idEstado' => $request->idEstado,
            'imagenProducto' => $producto->imagenProducto, // Se mantiene la imagen si no se sube una nueva
        ]);

        return redirect()->route('productos.modificar')->with('success', 'Producto modificado correctamente.');
    }

    public function eliminar(Request $request)
    {
        $productos = Producto::all();
        $productoSeleccionado = null;

        if ($request->filled('producto_id')) {
            $productoSeleccionado = Producto::find($request->producto_id);
        }

        return view('productos.eliminarProductos', compact('productos', 'productoSeleccionado'));
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.eliminar')->with('success', 'Producto eliminado correctamente.');
    }

    public function consultar(Request $request)
    {
        $query = Producto::with('estado');

        if ($request->filled('limpiar')) {
            return redirect()->route('productos.consultar');
        }

        $filtro = $request->input('filtro', 'nombre');
        $busqueda = $request->input('busqueda');

        if ($busqueda) {
            if ($filtro === 'nombre') {
                $query->where('nombreProducto', 'like', "%$busqueda%");
            } elseif ($filtro === 'codigo') {
                $query->where('codProducto', $busqueda);
            } elseif ($filtro === 'general') {
                $query->where(function($q) use ($busqueda) {
                    $q->where('nombreProducto', 'like', "%$busqueda%")
                    ->orWhere('codProducto', 'like', "%$busqueda%")
                    ->orWhere('descripcionProducto', 'like', "%$busqueda%")
                    ->orWhere('nomenclaturaProducto', 'like', "%$busqueda%");
                });
            }
        }

        $productos = $query->get();

        return view('productos.consultarProducto', compact('productos'));
    }

    public function reporte(Request $request)
    {
        $query = Producto::with('estado');

        $filtro = $request->input('filtro', 'nombre');
        $busqueda = $request->input('busqueda');

        if ($busqueda) {
            if ($filtro === 'nombre') {
                $query->where('nombreProducto', 'like', "%$busqueda%");
            } elseif ($filtro === 'codigo') {
                $query->where('codProducto', $busqueda);
            } elseif ($filtro === 'general') {
                $query->where(function($q) use ($busqueda) {
                    $q->where('nombreProducto', 'like', "%$busqueda%")
                    ->orWhere('codProducto', 'like', "%$busqueda%")
                    ->orWhere('descripcionProducto', 'like', "%$busqueda%")
                    ->orWhere('nomenclaturaProducto', 'like', "%$busqueda%");
                });
            }
        }

        $productos = $query->get();

        return view('productos.reporteProducto', compact('productos'));
    }

    public function estado(Request $request)
    {
        $productos = Producto::all();
        $estados = Estado::all();
        $productoSeleccionado = null;

        if ($request->filled('producto_id')) {
            $productoSeleccionado = Producto::find($request->producto_id);
        }

        return view('productos.estadoProductos', compact('productos', 'estados', 'productoSeleccionado'));
    }

    public function estadoUpdate(Request $request, $id)
    {
        $request->validate([
            'idEstado' => 'required|exists:estado,idEstado',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->idEstado = $request->idEstado;
        $producto->save();

        return redirect()->route('productos.estado')->with('success', 'Estado del producto actualizado correctamente.');
    }

    public function cancelar($id)
    {
        $reserva = Reserva::findOrFail($id);
        if ($reserva->idUsuario == Auth::id() && $reserva->idEstado == 1) {
            $reserva->idEstado = 5; // 3 = Cancelada
            $reserva->save();
            return back()->with('success', '¡Reserva cancelada!');
        }
        return back()->with('error', 'No puedes cancelar esta reserva.');
    }

}