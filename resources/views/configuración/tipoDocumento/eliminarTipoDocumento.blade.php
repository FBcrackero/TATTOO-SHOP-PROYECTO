@extends('layouts.app')

@section('title', 'Eliminar Tipo de Documento | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('tipodocumento') }}" class="volver-flecha" title="Volver"></a>
    <h2>Eliminar Tipo de Documento</h2>

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
    <form id="buscarTipoDocumentoForm" method="GET" action="{{ route('tipodocumento.eliminar') }}">
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

    {{-- Formulario de eliminación --}}
    @if(isset($tipoSeleccionado))
    <form action="{{ route('tipodocumento.destroy', $tipoSeleccionado->idTipoDocumento) }}" method="POST">
        @csrf
        @method('DELETE')

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
            <label>Descripción:</label>
            <input type="text" value="{{ $tipoSeleccionado->descripcionTipoDoc }}" readonly>
        </div>

        <div class="botones-accion">
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este tipo de documento?')">Eliminar</button>
            <a href="{{ route('tipodocumento') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona un tipo de documento para eliminar.</p>
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