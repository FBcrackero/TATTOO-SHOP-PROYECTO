@extends('layouts.app')

@section('title', 'Eliminar Forma de Pago | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('formaPago') }}" class="volver-flecha" title="Volver"></a>
    <h2>Eliminar Forma de Pago</h2>

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
    <form id="buscarFormaPagoForm" method="GET" action="{{ route('formaPago.eliminar') }}">
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

    {{-- Formulario de eliminación --}}
    @if(isset($formaPagoSeleccionada))
    <form action="{{ route('formaPago.destroy', $formaPagoSeleccionada->idFormaPago) }}" method="POST">
        @csrf
        @method('DELETE')

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
            <label>Descripción:</label>
            <input type="text" value="{{ $formaPagoSeleccionada->descripcionFormaPago }}" readonly>
        </div>

        <div class="botones-accion">
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta forma de pago?')">Eliminar</button>
            <a href="{{ route('formaPago') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona una forma de pago para eliminar.</p>
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