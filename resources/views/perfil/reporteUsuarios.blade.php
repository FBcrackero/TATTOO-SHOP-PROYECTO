
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Usuarios</title>
    <link rel="stylesheet" href="{{ asset('css/reporte.css') }}">
</head>
<body>
<div class="consultar-container">
    <div class="reporte-header">
        <h2>Reporte de Usuarios</h2>
        <button onclick="window.print()" class="btn-imprimir no-print">Imprimir</button>
        <a href="{{ route('usuarios.consultar', request()->all()) }}" class="btn no-print" style="margin-left:10px;">Volver</a>
    </div>
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Correo</th>
                    <th>Identificación</th>
                    <th>Perfil</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->idUsuario }}</td>
                        <td>{{ $usuario->nombresUsu }}</td>
                        <td>{{ $usuario->apellidosUsu }}</td>
                        <td>{{ $usuario->emailUsu }}</td>
                        <td>{{ $usuario->NidentificacionUsu }}</td>
                        <td>{{ $usuario->perfil->nombrePerfil ?? 'Sin perfil' }}</td>
                        <td>{{ $usuario->idEstado == 1 ? 'Activo' : 'Inactivo' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No hay usuarios para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>