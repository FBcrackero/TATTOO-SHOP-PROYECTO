
@extends('layouts.app')

@section('title', 'Historial de Compras | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/reporte.css') }}">
@endpush

@section('content')
<div class="consultar-container">
    <a href="{{ route('perfil.ver') }}" class="volver-flecha" title="Volver"></a>
    <h2>Historial de Compras</h2>

    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th># Factura</th>
                    <th>Fecha</th>
                    <th>Productos</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($facturas as $factura)
                    <tr>
                        <td>{{ $factura->codFacturaProducto }}</td>
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
                        <td>
                            <a href="{{ route('facturas.reporte', $factura->codFacturaProducto) }}" class="btn btn-reporte" target="_blank">Ver Detalle</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No tienes compras registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection