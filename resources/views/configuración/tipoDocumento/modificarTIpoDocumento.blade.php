@extends('layouts.app')

@section('title', 'Modificar Tipo de Documento | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('tipodocumento') }}" class="volver-flecha" title="Volver"></a>
    <h2>Modificar Tipo de Documento</h2>

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
    <form id="buscarTipoDocumentoForm" method="GET" action="{{ route('tipodocumento.modificar') }}">
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

    {{-- Formulario de modificación --}}
    @if(isset($tipoSeleccionado))
    <form action="{{ route('tipodocumento.update', $tipoSeleccionado->idTipoDocumento) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div>
            <label for="nombreTipoDoc">Nombre del Tipo de Documento</label>
            <input type="text" id="nombreTipoDoc" name="nombreTipoDoc" required maxlength="40" value="{{ old('nombreTipoDoc', $tipoSeleccionado->nombreTipoDoc) }}">
        </div>

        {{-- Descripción --}}
        <div>
            <label for="descripcionTipoDoc">Descripción</label>
            <input type="text" id="descripcionTipoDoc" name="descripcionTipoDoc" required maxlength="100" value="{{ old('descripcionTipoDoc', $tipoSeleccionado->descripcionTipoDoc) }}">
        </div>

        {{-- Nomenclatura --}}
        <div>
            <label for="nomenclaturaTipoDoc">Nomenclatura</label>
            <input type="text" id="nomenclaturaTipoDoc" name="nomenclaturaTipoDoc" required maxlength="5" value="{{ old('nomenclaturaTipoDoc', $tipoSeleccionado->nomenclaturaTipoDoc) }}">
        </div>

        {{-- Botones --}}
        <div class="botones-accion">
            <button type="submit">Guardar Cambios</button>
            <a href="{{ route('tipodocumento') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona un tipo de documento para modificar.</p>
    @endif
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Desvanecer mensaje de éxito
        const mensaje = document.querySelector('.mensaje-exito');
        if(mensaje){
            setTimeout(() => {
                mensaje.style.transition = 'opacity 0.5s';
                mensaje.style.opacity = '0';
                setTimeout(() => mensaje.style.display = 'none', 500);
            }, 2000);
        }
    });
</script>
@endpush