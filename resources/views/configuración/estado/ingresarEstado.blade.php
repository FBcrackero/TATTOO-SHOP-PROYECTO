@extends('layouts.app')

@section('title', 'Ingresar Estado | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <h2>Ingresar Estado</h2>

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

    <form action="{{ route('estado.store') }}" method="POST">
        @csrf

        {{-- Nombre del estado --}}
        <div>
            <label for="nombreEstado">Nombre del Estado</label>
            <input type="text" id="nombreEstado" name="nombreEstado" required maxlength="40" value="{{ old('nombreEstado') }}">
        </div>

        {{-- Nomenclatura --}}
        <div>
            <label for="nomenclaturaEstado">Nomenclatura</label>
            <input type="text" id="nomenclaturaEstado" name="nomenclaturaEstado" required maxlength="10" value="{{ old('nomenclaturaEstado') }}">
        </div>

        {{-- Descripción --}}
        <div>
            <label for="descripcionEstado">Descripción</label>
            <input type="text" id="descripcionEstado" name="descripcionEstado" required maxlength="100" value="{{ old('descripcionEstado') }}">
        </div>

        {{-- Botones --}}
        <div class="botones-accion">
            <button type="submit">Guardar Estado</button>
            <a href="{{ route('estado') }}" class="btn">Cancelar</a>
        </div>
    </form>
</div>
@endsection