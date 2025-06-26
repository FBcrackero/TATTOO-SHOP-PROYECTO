@extends('layouts.app')

@section('title', 'Estado del Tipo de Documento | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('tipodocumento') }}" class="volver-flecha" title="Volver"></a>
    <h2>Cambiar Estado del Tipo de Documento</h2>

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
    <form id="buscarTipoDocumentoForm" method="GET" action="{{ route('tipodocumento.estado') }}">
        <div class="busqueda-servicio">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar por nombre, ID o nomenclatura..." value="{{ old('busqueda', request('busqueda')) }}">
            <select name="tipo_documento_id" id="tipo_documento_id">
                <option value="">Selecciona un tipo de documento</option>
                @foreach($tiposDocumento as $tipo)
                    <option value="{{ $tipo->idTipoDocumento }}" {{ (request('tipo_documento_id') == $tipo->idTipoDocumento) ? 'selected' : '' }}>
                        {{ $tipo->nombreTipoDoc }} (ID: {{ $tipo->idTipoDocumento }})
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn">Buscar</button>
            <hr class="divisor-modificar">
        </div>
    </form>

    {{-- Formulario de cambio de estado --}}
    @if(isset($tipoSeleccionado))
    <form action="{{ route('tipodocumento.estado.update', $tipoSeleccionado->idTipoDocumento) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>ID:</label>
            <input type="text" value="{{ $tipoSeleccionado->idTipoDocumento }}" readonly>
        </div>
        <div>
            <label>Nombre:</label>
            <input type="text" value="{{ $tipoSeleccionado->nombreTipoDoc }}" readonly>
        </div>
        <div>
            <label>Nomenclatura:</label>
            <input type="text" value="{{ $tipoSeleccionado->nomenclaturaTipoDoc }}" readonly>
        </div>
        <div>
            <label>Estado:</label>
            <select name="idEstado" required>
                @foreach($estados as $estado)
                    <option value="{{ $estado->idEstado }}" {{ $tipoSeleccionado->idEstado == $estado->idEstado ? 'selected' : '' }}>
                        {{ $estado->nombreEstado }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="botones-accion">
            <button type="submit" class="btn btn-success">Actualizar Estado</button>
            <a href="{{ route('tipodocumento') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona un tipo de documento para cambiar su estado.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('tipo_documento_id');
        if(select){
            select.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });
</script>
@endpush