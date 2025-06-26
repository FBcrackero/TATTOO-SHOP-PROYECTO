<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Productos</title>
    <link rel="stylesheet" href="{{ asset('css/reporte.css') }}">
</head>
<body>
<div class="consultar-container">
    <div class="reporte-header">
        <h2>Reporte de Productos</h2>
        <button onclick="window.print()" class="btn-imprimir no-print">Imprimir</button>
        <a href="{{ route('productos.consultar', request()->all()) }}" class="btn no-print" style="margin-left:10px;">Volver</a>
    </div>
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Nomenclatura</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $producto)
                    <tr>
                        <td>{{ str_pad($producto->codProducto, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $producto->nombreProducto }}</td>
                        <td>{{ $producto->descripcionProducto }}</td>
                        <td>{{ $producto->nomenclaturaProducto }}</td>
                        <td>${{ number_format($producto->precioCompra, 0, ',', '.') }}</td>
                        <td>{{ $producto->cantidadDisponible }}</td>
                        <td>{{ $producto->estado->nombreEstado ?? 'Sin estado' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No hay productos para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>