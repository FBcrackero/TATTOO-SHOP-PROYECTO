@extends('layouts.app')

@section('title', 'Ingresar Forma de Pago | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <h2>Ingresar Forma de Pago</h2>

    {{-- Mensajes de error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="mensaje-exito">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('formaPago.store') }}" method="POST">
        @csrf

        <div>
            <label for="nombreFormaPago">Nombre de la Forma de Pago</label>
            <input type="text" id="nombreFormaPago" name="nombreFormaPago" required maxlength="40" value="{{ old('nombreFormaPago') }}">
        </div>

        <div>
            <label for="descripcionFormaPago">Descripción</label>
            <input type="text" id="descripcionFormaPago" name="descripcionFormaPago" required maxlength="60" value="{{ old('descripcionFormaPago') }}">
        </div>

        <div>
            <label for="nomenclaturaFormaPago">Nomenclatura</label>
            <input type="text" id="nomenclaturaFormaPago" name="nomenclaturaFormaPago" required maxlength="4" value="{{ old('nomenclaturaFormaPago') }}">
        </div>

        <div class="botones-accion">
            <button type="submit">Guardar Forma de Pago</button>
            <a href="{{ route('formaPago') }}" class="btn">Cancelar</a>
        </div>
    </form>
</div>
@endsection