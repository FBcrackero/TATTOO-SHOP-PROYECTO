@extends('layouts.app')

@section('title', 'Modificar Forma de Pago | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('formaPago') }}" class="volver-flecha" title="Volver"></a>
    <h2>Modificar Forma de Pago</h2>

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

    {{-- Selección de forma de pago --}}
    <form id="buscarFormaPagoForm" method="GET" action="{{ route('formaPago.modificar') }}">
        <div class="busqueda-servicio">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar por nombre, ID o nomenclatura..." value="{{ old('busqueda', request('busqueda')) }}">
            <select name="forma_pago_id" id="forma_pago_id">
                <option value="">Selecciona una forma de pago</option>
                @foreach($formasPago as $formaPago)
                    <option value="{{ $formaPago->idFormaPago }}" {{ (request('forma_pago_id') == $formaPago->idFormaPago) ? 'selected' : '' }}>
                        {{ $formaPago->nombreFormaPago }} (ID: {{ $formaPago->idFormaPago }})
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn">Buscar</button>
            <hr class="divisor-modificar">
        </div>
    </form>

    {{-- Formulario de modificación --}}
    @if(isset($formaPagoSeleccionada))
    <form action="{{ route('formaPago.update', $formaPagoSeleccionada->idFormaPago) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>ID:</label>
            <input type="text" value="{{ $formaPagoSeleccionada->idFormaPago }}" readonly>
        </div>
        <div>
            <label for="nombreFormaPago">Nombre</label>
            <input type="text" id="nombreFormaPago" name="nombreFormaPago" required maxlength="40" value="{{ old('nombreFormaPago', $formaPagoSeleccionada->nombreFormaPago) }}">
        </div>
        <div>
            <label for="descripcionFormaPago">Descripción</label>
            <input type="text" id="descripcionFormaPago" name="descripcionFormaPago" required maxlength="60" value="{{ old('descripcionFormaPago', $formaPagoSeleccionada->descripcionFormaPago) }}">
        </div>
        <div>
            <label for="nomenclaturaFormaPago">Nomenclatura</label>
            <input type="text" id="nomenclaturaFormaPago" name="nomenclaturaFormaPago" required maxlength="4" value="{{ old('nomenclaturaFormaPago', $formaPagoSeleccionada->nomenclaturaFormaPago) }}">
        </div>
        <div class="botones-accion">
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
            <a href="{{ route('formaPago') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona una forma de pago para modificar.</p>
    @endif
</div>
@endsection