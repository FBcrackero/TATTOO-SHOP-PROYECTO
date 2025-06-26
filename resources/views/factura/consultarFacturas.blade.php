@extends('layouts.app')

@section('title', 'Consultar Facturas | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/consultar.css') }}">
@endpush

@section('content')
<div class="consultar-container">
    <a href="{{ route('perfil.ver') }}" class="volver-flecha" title="Volver"></a>
    <h2>Consultar Facturas</h2>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('facturas.consultar') }}" class="filtros-form">
        <div class="filtros-opciones">
            <label><input type="radio" name="filtro" value="usuario" {{ request('filtro', 'usuario') == 'usuario' ? 'checked' : '' }}> Usuario</label>
            <label><input type="radio" name="filtro" value="fecha" {{ request('filtro') == 'fecha' ? 'checked' : '' }}> Fecha</label>
            <label><input type="radio" name="filtro" value="estado" {{ request('filtro') == 'estado' ? 'checked' : '' }}> Estado</label>
            <label><input type="radio" name="filtro" value="general" {{ request('filtro') == 'general' ? 'checked' : '' }}> General</label>
        </div>
        <div class="filtros-busqueda">
            <input type="text" name="busqueda" placeholder="Buscar" value="{{ request('busqueda') }}">
            <button type="submit" class="btn btn-buscar">Buscar</button>
            <button type="submit" name="limpiar" value="1" class="btn btn-limpiar">Limpiar</button>
            <a href="{{ route('facturas.reporte', request()->all()) }}" class="btn btn-reporte" target="_blank">Reporte</a>        </div>
    </form>

    {{-- Tabla de facturas --}}
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th># Factura</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Productos</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($facturas as $factura)
                    <tr>
                        <td>{{ $factura->codFacturaProducto }}</td>
                        <td>{{ $factura->usuario->nombresUsu ?? '-' }} {{ $factura->usuario->apellidosUsu ?? '' }}</td>
                        <td>{{ \Carbon\Carbon::parse($factura->fechaFactura)->format('d/m/Y H:i') }}</td>
                        <td>
                            <ul style="padding-left: 18px;">
                                @foreach($factura->productos as $fp)
                                    <li>
                                        {{ $fp->producto->nombreProducto ?? '-' }}
                                        (x{{ $fp->Cantidad }})
                                        - ${{ number_format($fp->producto->precioCompra ?? 0, 0, ',', '.') }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            ${{ number_format($factura->productos->sum(function($p) {
                                return $p->Cantidad * ($p->producto->precioCompra ?? 0);
                            }), 0, ',', '.') }}
                        </td>
                        <td>{{ $factura->idEstado == 1 ? 'Pagada' : 'Pendiente' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No hay facturas para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection