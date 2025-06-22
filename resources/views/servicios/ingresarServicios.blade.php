@extends('layouts.app')

@section('title', 'Ingresar Servicio | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <h2>Ingresar Nuevo Servicio</h2>

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

    <form action="{{ route('servicios.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Nombre del servicio --}}
        <div>
            <label for="nombreServicio">Nombre del Servicio</label>
            <input type="text" id="nombreServicio" name="nombreServicio" required maxlength="40">
        </div>

        {{-- Descripción --}}
        <div>
            <label for="descripcionServicio">Descripción</label>
            <input type="text" id="descripcionServicio" name="descripcionServicio" required maxlength="60">
        </div>

        {{-- Nomenclatura --}}
        <div>
            <label for="nomenclaturaServicio">Nomenclatura</label>
            <input type="text" id="nomenclaturaServicio" name="nomenclaturaServicio" required maxlength="4">
        </div>

        {{-- Imagen --}}
        <div>
            <label for="imagenServicio">Imagen</label>
            <input type="file" id="imagenServicio" name="imagenServicio" accept="image/*">

            {{-- Campo editable para el nombre personalizado --}}
            <input type="text" id="nombreImagen" name="nombreImagen" placeholder="Nombre personalizado de imagen (opcional)" maxlength="100">>

            {{-- Vista previa --}}
            <img id="preview" src="#" alt="Vista previa">
        </div>

        {{-- Estado por defecto --}}
        <input type="hidden" name="idEstado" value="1">

        {{-- Botones --}}
        <div class="botones-accion">
            <button type="submit">Guardar Servicio</button>
            <a href="{{ route('servicios') }}" class="btn">Cancelar</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('imagenServicio');
        const preview = document.getElementById('preview');

        input.addEventListener('change', function (event) {
            const [file] = event.target.files;
            if (file) {
                // Mostrar imagen
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';

                // Proponer nombre base (sin extensión)
                const nombreSinExtension = file.name.replace(/\.[^/.]+$/, "");
                const nombreInput = document.getElementById('nombreImagen');
                if (nombreInput && !nombreInput.value) {
                    nombreInput.value = nombreSinExtension;
                }
            }
        });
    });
</script>
@endpush
