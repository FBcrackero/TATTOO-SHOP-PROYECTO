@extends('layouts.app')

@section('title', 'Carrito de Compras')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/carrito.css') }}">
@endpush

@section('content')
<div class="carrito-main-container">
    <div class="carrito-lista">
        <h2>Mi Carrito</h2>
        @if(session('success'))
            <div class="mensaje-exito">{{ session('success') }}</div>
        @endif

        @if(count($carrito))
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cant.</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($carrito as $item)
                        @php
                            $subtotal = $item['precioCompra'] * $item['cantidad'];
                            $total += $subtotal;
                            $producto = \App\Models\Producto::find($item['codProducto']);
                            $max = $producto ? $producto->cantidadDisponible : 1;
                        @endphp
                        <tr>
                            <td>
                                <img src="{{ asset('imagenes/imgProductos/' . ($producto->imagenProducto ?? 'producto-ejemplo.jpg')) }}"
                                     alt="Imagen producto" class="carrito-img">
                            </td>
                            <td class="carrito-nombre">{{ $item['nombreProducto'] }}</td>
                            <td class="carrito-precio">${{ number_format($item['precioCompra'], 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('carrito.actualizar', $item['codProducto']) }}" method="POST" class="form-actualizar-cantidad carrito-cantidad">
                                    @csrf
                                    <button type="button" class="btn-menos" {{ $item['cantidad'] <= 1 ? 'disabled' : '' }}>−</button>
                                    <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" max="{{ $max }}" readonly>
                                    <button type="button" class="btn-mas" {{ $item['cantidad'] >= $max ? 'disabled' : '' }}>+</button>
                                </form>
                            </td>
                            <td class="carrito-subtotal">${{ number_format($subtotal, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('carrito.quitar', $item['codProducto']) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="carrito-btn">×</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="carrito-vacio">
                <h3>Tu carrito está vacío</h3>
                <p>Agrega productos para continuar con tu compra.</p>
                <a href="{{ route('productos') }}" class="carrito-vacio-btn">Ver productos</a>
            </div>
        @endif
    </div>

    @if(count($carrito))
    <div class="carrito-resumen">
        <h3>Resumen del pedido</h3>
        <div class="carrito-resumen-row">
            <span>Subtotal</span>
            <span>${{ number_format($total, 0, ',', '.') }}</span>
        </div>
        <div class="carrito-resumen-row">
            <span>Envío</span>
            <span>Gratis</span>
        </div>
        <div class="carrito-resumen-total">
            <span>Total</span>
            <span>${{ number_format($total, 0, ',', '.') }}</span>
        </div>

        {{-- Botón Vaciar carrito --}}
        <form action="{{ route('carrito.vaciar') }}" method="POST">
            @csrf
            <button type="submit" class="carrito-accion-btn btn-vaciar">Vaciar carrito</button>
        </form>

        {{-- Botón Finalizar compra --}}
        <a href="{{ route('checkout') }}" class="carrito-accion-btn btn-finalizar">Finalizar compra</a>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.form-actualizar-cantidad').forEach(form => {
    const input = form.querySelector('input[name="cantidad"]');
    const btnMas = form.querySelector('.btn-mas');
    const btnMenos = form.querySelector('.btn-menos');
    const max = parseInt(input.getAttribute('max'));
    const min = parseInt(input.getAttribute('min'));

    btnMas.addEventListener('click', function() {
        let val = parseInt(input.value);
        if(val < max) {
            input.value = val + 1;
            form.submit();
        } else {
            alert('No puedes agregar más de la cantidad disponible.');
        }
    });

    btnMenos.addEventListener('click', function() {
        let val = parseInt(input.value);
        if(val > min) {
            input.value = val - 1;
            form.submit();
        }
    });
});
</script>
@endpush
