@extends('layouts.app')

@section('title', 'Ingresar Tipo de Documento | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <h2>Ingresar Tipo de Documento</h2>

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

    <form action="{{ route('tipodocumento.store') }}" method="POST">
        @csrf

        {{-- Nombre del tipo de documento --}}
        <div>
            <label for="nombreTipoDoc">Nombre del Tipo de Documento</label>
            <input type="text" id="nombreTipoDoc" name="nombreTipoDoc" required maxlength="40" value="{{ old('nombreTipoDoc') }}">
        </div>

        {{-- Descripción --}}
        <div>
            <label for="descripcionTipoDoc">Descripción</label>
            <input type="text" id="descripcionTipoDoc" name="descripcionTipoDoc" required maxlength="100" value="{{ old('descripcionTipoDoc') }}">
        </div>

        {{-- Nomenclatura --}}
        <div>
            <label for="nomenclaturaTipoDoc">Nomenclatura</label>
            <input type="text" id="nomenclaturaTipoDoc" name="nomenclaturaTipoDoc" required maxlength="5" value="{{ old('nomenclaturaTipoDoc') }}">
        </div>

        {{-- Estado por defecto --}}
        <input type="hidden" name="idEstado" value="1">

        {{-- Botones --}}
        <div class="botones-accion">
            <button type="submit">Guardar Tipo de Documento</button>
            <a href="{{ route('tipodocumento') }}" class="btn">Cancelar</a>
        </div>
    </form>
</div>
@endsection