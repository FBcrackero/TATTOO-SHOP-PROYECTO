
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Servicios</title>
    <link rel="stylesheet" href="{{ asset('css/reporte.css') }}">
</head>
<body>
<div class="consultar-container">
    <div class="reporte-header">
        <h2>Reporte de Servicios</h2>
        <button onclick="window.print()" class="btn-imprimir no-print">Imprimir</button>
        <a href="{{ route('servicios.consultar') }}" class="btn no-print" style="margin-left:10px;">Volver</a>
    </div>
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Servicio</th>
                    <th>Descripción</th>
                    <th>Nomenclatura</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($servicios as $servicio)
                    <tr>
                        <td>{{ str_pad($servicio->idServicio, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $servicio->nombreServicio }}</td>
                        <td>{{ $servicio->descripcionServicio }}</td>
                        <td>{{ $servicio->nomenclaturaServicio }}</td>
                        <td>{{ $servicio->estado->nombreEstado ?? 'Sin estado' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No hay servicios para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>