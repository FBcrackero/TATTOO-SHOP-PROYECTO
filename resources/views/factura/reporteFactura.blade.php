<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Facturas</title>
    <link rel="stylesheet" href="{{ asset('css/reporte.css') }}">
</head>
<body>
<div class="consultar-container">
    <div class="reporte-header">
        <h2>Reporte de Facturas</h2>
        <button onclick="window.print()" class="btn-imprimir no-print">Imprimir</button>
        <a href="{{ route('facturas.consultar', request()->all()) }}" class="btn no-print" style="margin-left:10px;">Volver</a>
    </div>
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th># Factura</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Productos</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($facturas as $factura)
                    <tr>
                        <td>{{ $factura->codFacturaProducto }}</td>
                        <td>{{ $factura->usuario->nombresUsu ?? '-' }} {{ $factura->usuario->apellidosUsu ?? '' }}</td>
                        <td>{{ \Carbon\Carbon::parse($factura->fechaFactura)->format('d/m/Y H:i') }}</td>
                        <td>
                            <ul style="padding-left: 18px;">
                                @foreach($factura->productos as $fp)
                                    <li>
                                        {{ $fp->producto->nombreProducto ?? '-' }}
                                        (x{{ $fp->Cantidad }})
                                        - ${{ number_format($fp->producto->precioCompra ?? 0, 0, ',', '.') }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            ${{ number_format($factura->productos->sum(function($p) {
                                return $p->Cantidad * ($p->producto->precioCompra ?? 0);
                            }), 0, ',', '.') }}
                        </td>
                        <td>{{ $factura->idEstado == 1 ? 'Pagada' : 'Pendiente' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No hay facturas para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>