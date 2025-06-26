<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Categorías</title>
    <link rel="stylesheet" href="{{ asset('css/reporte.css') }}">
</head>
<body>
<div class="consultar-container">
    <div class="reporte-header">
        <h2>Reporte de Categorías</h2>
        <button onclick="window.print()" class="btn-imprimir no-print">Imprimir</button>
        <a href="{{ route('categoria.consultar', request()->all()) }}" class="btn no-print" style="margin-left:10px;">Volver</a>
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
                @forelse($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->idCategoriaProducto }}</td>
                        <td>{{ $categoria->nombreCategoriaProducto }}</td>
                        <td>{{ $categoria->descripcionCategoriaProducto }}</td>
                        <td>{{ $categoria->nomenclaturaCategoriaProducto }}</td>
                        <td>{{ $categoria->estado ? $categoria->estado->nombreEstado : 'Sin estado' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No hay categorías para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>