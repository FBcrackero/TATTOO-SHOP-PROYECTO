<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Tipos de Documento</title>
    <link rel="stylesheet" href="{{ asset('css/reporte.css') }}">
</head>
<body>
<div class="consultar-container">
    <div class="reporte-header">
        <h2>Reporte de Tipos de Documento</h2>
        <button onclick="window.print()" class="btn-imprimir no-print">Imprimir</button>
        <a href="{{ route('tipodocumento.consultar', request()->all()) }}" class="btn no-print" style="margin-left:10px;">Volver</a>
    </div>
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Nomenclatura</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tiposDocumento as $tipo)
                    <tr>
                        <td>{{ $tipo->idTipoDocumento }}</td>
                        <td>{{ $tipo->nombreTipoDoc }}</td>
                        <td>{{ $tipo->descripcionTipoDoc }}</td>
                        <td>{{ $tipo->nomenclaturaTipoDoc }}</td>
                        <td>{{ $tipo->idEstado == 1 ? 'Activo' : 'Inactivo' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No hay tipos de documento para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>