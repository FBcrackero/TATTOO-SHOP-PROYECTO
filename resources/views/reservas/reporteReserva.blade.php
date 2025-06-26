
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Reservas</title>
    <link rel="stylesheet" href="{{ asset('css/reporte.css') }}">
</head>
<body>
<div class="consultar-container">
    <div class="reporte-header">
        <h2>Reporte de Reservas</h2>
        <button onclick="window.print()" class="btn-imprimir no-print">Imprimir</button>
        <a href="{{ route('reservas.consultar', request()->all()) }}" class="btn no-print" style="margin-left:10px;">Volver</a>
    </div>
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Artista</th>
                    <th>Servicio</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservas as $reserva)
                    <tr>
                        <td>{{ $reserva->idReserva }}</td>
                        <td>{{ $reserva->usuario->nombresUsu ?? '' }}</td>
                        <td>{{ $reserva->artista->nombresUsu ?? '' }}</td>
                        <td>{{ $reserva->servicio->nombreServicio ?? '' }}</td>
                        <td>{{ $reserva->fechaReserva }}</td>
                        <td>{{ $reserva->horaReserva }}</td>
                        <td>{{ $reserva->estado->nombreEstado ?? 'Sin estado' }}</td>
                        <td>{{ $reserva->descripcionReserva }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No hay reservas para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>