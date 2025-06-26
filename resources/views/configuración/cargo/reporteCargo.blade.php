<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Cargos</title>
    <link rel="stylesheet" href="{{ asset('css/reporte.css') }}">
</head>
<body>
<div class="consultar-container">
    <div class="reporte-header">
        <h2>Reporte de Cargos</h2>
        <button onclick="window.print()" class="btn-imprimir no-print">Imprimir</button>
        <a href="{{ route('cargo.consultar', request()->all()) }}" class="btn no-print" style="margin-left:10px;">Volver</a>
    </div>
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Nomenclatura</th>
                    <th>Sueldo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cargos as $cargo)
                    <tr>
                        <td>{{ $cargo->idCargo }}</td>
                        <td>{{ $cargo->nombreCargo }}</td>
                        <td>{{ $cargo->descripcionCargo }}</td>
                        <td>{{ $cargo->nomenclaturaCargo }}</td>
                        <td>{{ $cargo->sueldo }}</td>
                        <td>
                            @if(isset($cargo->estado) && $cargo->estado)
                                {{ $cargo->estado->nombreEstado }}
                            @else
                                Sin estado
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No hay cargos para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>