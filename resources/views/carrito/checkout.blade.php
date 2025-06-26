@extends('layouts.app')

@section('title', 'Finalizar compra')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/check.css') }}">
<link rel="stylesheet" href="{{ asset('css/carrito.css') }}">
@endpush

@section('content')
<div class="carrito-main-container">
    <div class="carrito-lista">
        <h2>Finalizar compra</h2>

        <form action="{{ route('checkout.procesar') }}" method="POST" class="form-checkout">
            @csrf

            <div class="form-group">
                <label for="idFormaPago">Método de pago:</label>
                <select name="idFormaPago" id="idFormaPago" required>
                    <option value="">Seleccione...</option>
                    @foreach($formasPago as $fp)
                        <option value="{{ $fp->idFormaPago }}">{{ $fp->nombreFormaPago }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="numero_tarjeta">Número de tarjeta:</label>
                <input type="text" name="numero_tarjeta" maxlength="19" pattern="\d{16,19}" required>
            </div>

            <div class="form-group">
                <label for="nombre_tarjeta">Nombre en la tarjeta:</label>
                <input type="text" name="nombre_tarjeta" maxlength="50" required>
            </div>

            <div class="form-group-inline">
                <div>
                    <label for="vencimiento">Fecha de vencimiento:</label>
                    <input type="text" name="vencimiento" placeholder="MM/AA" pattern="\d{2}/\d{2}" required>
                </div>

                <div>
                    <label for="cvv">CVV:</label>
                    <input type="password" name="cvv" maxlength="4" pattern="\d{3,4}" required>
                </div>
            </div>

            <div class="resumen-compra">
                <h3>Resumen</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cant.</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($carrito as $item)
                            @php $subtotal = $item['precioCompra'] * $item['cantidad']; $total += $subtotal; @endphp
                            <tr>
                                <td>{{ $item['nombreProducto'] }}</td>
                                <td>{{ $item['cantidad'] }}</td>
                                <td>${{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2"><strong>Total</strong></td>
                            <td><strong>${{ number_format($total, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-checkout">Confirmar compra</button>
        </form>
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    </div>
</div>
@endsection
