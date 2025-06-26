<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Kardex</title>
    <link rel="stylesheet" href="{{ asset('css/reporte.css') }}">
</head>
<body>
<div class="consultar-container">
    <div class="reporte-header">
        <h2>Reporte de Kardex</h2>
        <button onclick="window.print()" class="btn-imprimir no-print">Imprimir</button>
        <a href="{{ route('inventario.kardex', request()->all()) }}" class="btn no-print" style="margin-left:10px;">Volver</a>
    </div>
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Entrada</th>
                    <th>Salida</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kardex as $mov)
                    <tr>
                        <td>{{ $mov->fechaInventario }}</td>
                        <td>{{ $mov->producto->nombreProducto ?? '-' }}</td>
                        <td>{{ $mov->cantKardEntrada }}</td>
                        <td>{{ $mov->cantKardSalida }}</td>
                        <td>${{ number_format($mov->precioVenta, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No hay movimientos para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>