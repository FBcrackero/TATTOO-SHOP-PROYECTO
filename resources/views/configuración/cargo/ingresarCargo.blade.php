@extends('layouts.app')

@section('title', 'Ingresar Cargo | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <h2>Ingresar Cargo</h2>

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

    <form action="{{ route('cargo.store') }}" method="POST">
        @csrf

        <div>
            <label for="nombreCargo">Nombre del Cargo</label>
            <input type="text" id="nombreCargo" name="nombreCargo" required value="{{ old('nombreCargo') }}">
        </div>

        <div>
            <label for="descripcionCargo">Descripción</label>
            <input type="text" id="descripcionCargo" name="descripcionCargo" required maxlength="255" value="{{ old('descripcionCargo') }}">
        </div>

        <div>
            <label for="nomenclaturaCargo">Nomenclatura</label>
            <input type="text" id="nomenclaturaCargo" name="nomenclaturaCargo" required maxlength="100" value="{{ old('nomenclaturaCargo') }}">
        </div>

        <div>
            <label for="sueldo">Sueldo</label>
            <input type="number" id="sueldo" name="sueldo" required min="0" step="0.01" value="{{ old('sueldo') }}">
        </div>

        {{-- Estado por defecto --}}
        <input type="hidden" name="idEstado" value="1">

        <div class="botones-accion">
            <button type="submit">Guardar Cargo</button>
            <a href="{{ route('cargo') }}" class="btn">Cancelar</a>
        </div>
    </form>
</div>
@endsection