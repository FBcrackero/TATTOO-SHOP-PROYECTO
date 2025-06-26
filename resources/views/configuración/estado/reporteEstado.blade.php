<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Estados</title>
    <link rel="stylesheet" href="{{ asset('css/reporte.css') }}">
</head>
<body>
<div class="consultar-container">
    <div class="reporte-header">
        <h2>Reporte de Estados</h2>
        <button onclick="window.print()" class="btn-imprimir no-print">Imprimir</button>
        <a href="{{ route('estado.consultar', request()->all()) }}" class="btn no-print" style="margin-left:10px;">Volver</a>
    </div>
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Nomenclatura</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($estados as $estado)
                    <tr>
                        <td>{{ $estado->idEstado }}</td>
                        <td>{{ $estado->nombreEstado }}</td>
                        <td>{{ $estado->nomenclaturaEstado }}</td>
                        <td>{{ $estado->descripcionEstado }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No hay estados para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>