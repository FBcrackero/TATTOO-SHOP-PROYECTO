@extends('layouts.app')

@section('title', 'Entrada de Inventario | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <h2>Registrar Entrada de Inventario</h2>
    <form action="{{ route('inventario.entrada.store') }}" method="POST">
        @csrf
        <div>
            <label for="codProducto">Producto</label>
            <select name="codProducto" id="codProducto" required>
                <option value="">Seleccione un producto</option>
                @foreach(\App\Models\Producto::all() as $producto)
                    <option value="{{ $producto->codProducto }}">{{ $producto->nombreProducto }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="cantidad">Cantidad de entrada</label>
            <input type="number" name="cantidad" id="cantidad" min="1" required>
        </div>
        <div>
            <label for="precio">Precio de compra (opcional)</label>
            <input type="number" name="precio" id="precio" min="0" step="0.01">
        </div>
        <button type="submit" class="admin-btn">Registrar entrada</button>
    </form>
</div>
@endsection