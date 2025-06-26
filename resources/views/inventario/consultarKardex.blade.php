@extends('layouts.app')

@section('title', 'Consultar Kardex | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/consultar.css') }}">
@endpush

@section('content')
<div class="consultar-container">
    <a href="{{ route('inventario.index') }}" class="volver-flecha" title="Volver"></a>
    <h2>Consultar Kardex</h2>

    <form method="GET" action="{{ route('inventario.kardex') }}" class="filtros-form">
        <div class="filtros-opciones">
            <label><input type="radio" name="tipo" value="" {{ request('tipo') == '' ? 'checked' : '' }}> Todos</label>
            <label><input type="radio" name="tipo" value="entrada" {{ request('tipo') == 'entrada' ? 'checked' : '' }}> Entradas</label>
            <label><input type="radio" name="tipo" value="salida" {{ request('tipo') == 'salida' ? 'checked' : '' }}> Salidas</label>
        </div>
        <div class="filtros-busqueda">
            <select name="producto">
                <option value="">Todos los productos</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->codProducto }}" {{ request('producto') == $producto->codProducto ? 'selected' : '' }}>
                        {{ $producto->nombreProducto }}
                    </option>
                @endforeach
            </select>
            <input type="date" name="fecha" value="{{ request('fecha') }}">
            <button type="submit" class="btn btn-buscar">Buscar</button>
            <button type="submit" name="limpiar" value="1" class="btn btn-limpiar">Limpiar</button>
            <div class="reporte-header" style="margin-bottom:18px;">
                <a href="{{ route('inventario.kardex.reporte', request()->all()) }}" class="btn btn-reporte" target="_blank">Reporte</a>
            </div>
        </div>
    </form>

    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Entrada</th>
                    <th>Salida</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kardex as $mov)
                    <tr>
                        <td>{{ $mov->fechaInventario }}</td>
                        <td>{{ $mov->producto->nombreProducto ?? '-' }}</td>
                        <td>{{ $mov->cantKardEntrada }}</td>
                        <td>{{ $mov->cantKardSalida }}</td>
                        <td>${{ number_format($mov->precioVenta, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No hay movimientos para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection