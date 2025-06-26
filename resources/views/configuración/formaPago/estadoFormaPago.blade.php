@extends('layouts.app')

@section('title', 'Estado de la Forma de Pago | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('formaPago') }}" class="volver-flecha" title="Volver"></a>
    <h2>Cambiar Estado de la Forma de Pago</h2>

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

    {{-- Barra de búsqueda y select --}}
    <form id="buscarFormaPagoForm" method="GET" action="{{ route('formaPago.estado') }}">
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

    {{-- Formulario de cambio de estado --}}
    @if(isset($formaPagoSeleccionada))
    <form action="{{ route('formaPago.estado.update', $formaPagoSeleccionada->idFormaPago) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>ID:</label>
            <input type="text" value="{{ $formaPagoSeleccionada->idFormaPago }}" readonly>
        </div>
        <div>
            <label>Nombre:</label>
            <input type="text" value="{{ $formaPagoSeleccionada->nombreFormaPago }}" readonly>
        </div>
        <div>
            <label>Nomenclatura:</label>
            <input type="text" value="{{ $formaPagoSeleccionada->nomenclaturaFormaPago }}" readonly>
        </div>
        <div>
            <label>Estado:</label>
            <select name="idEstado" required>
                @foreach($estados as $estado)
                    <option value="{{ $estado->idEstado }}" {{ $formaPagoSeleccionada->idEstado == $estado->idEstado ? 'selected' : '' }}>
                        {{ $estado->nombreEstado }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="botones-accion">
            <button type="submit" class="btn btn-success">Actualizar Estado</button>
            <a href="{{ route('formaPago') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona una forma de pago para cambiar su estado.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('forma_pago_id');
        if(select){
            select.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });
</script>
@endpush