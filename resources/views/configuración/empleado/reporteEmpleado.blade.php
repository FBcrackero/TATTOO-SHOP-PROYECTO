<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Empleados</title>
    <link rel="stylesheet" href="{{ asset('css/reporte.css') }}">
</head>
<body>
<div class="consultar-container">
    <div class="reporte-header">
        <h2>Reporte de Empleados</h2>
        <button onclick="window.print()" class="btn-imprimir no-print">Imprimir</button>
        <a href="{{ route('empleado.consultar', request()->all()) }}" class="btn no-print" style="margin-left:10px;">Volver</a>
    </div>
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Identificación</th>
                    <th>Cargo</th>
                    <th>Fecha Vinculación</th>
                    <th>Número Contrato</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empleados as $empleado)
                    <tr>
                        <td>{{ $empleado->idEmpleado }}</td>
                        <td>{{ $empleado->usuario->nombresUsu ?? '' }} {{ $empleado->usuario->apellidosUsu ?? '' }}</td>
                        <td>{{ $empleado->usuario->NidentificacionUsu ?? '' }}</td>
                        <td>{{ $empleado->cargo->nombreCargo ?? '' }}</td>
                        <td>{{ $empleado->fechaVinculacionEmpleado }}</td>
                        <td>{{ $empleado->numeroContrato }}</td>
                        <td>{{ $empleado->estado->nombreEstado ?? '' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No hay empleados para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>