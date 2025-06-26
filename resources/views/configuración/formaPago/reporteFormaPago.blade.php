
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Formas de Pago</title>
    <link rel="stylesheet" href="{{ asset('css/reporte.css') }}">
</head>
<body>
<div class="consultar-container">
    <div class="reporte-header">
        <h2>Reporte de Formas de Pago</h2>
        <button onclick="window.print()" class="btn-imprimir no-print">Imprimir</button>
        <a href="{{ route('formaPago.consultar', request()->all()) }}" class="btn no-print" style="margin-left:10px;">Volver</a>
    </div>
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Nomenclatura</th>
                </tr>
            </thead>
            <tbody>
                @forelse($formasPago as $formaPago)
                    <tr>
                        <td>{{ $formaPago->idFormaPago }}</td>
                        <td>{{ $formaPago->nombreFormaPago }}</td>
                        <td>{{ $formaPago->descripcionFormaPago }}</td>
                        <td>{{ $formaPago->nomenclaturaFormaPago }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No hay formas de pago para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>