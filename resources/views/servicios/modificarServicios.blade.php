@extends('layouts.app')

@section('title', 'Modificar Servicio | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('servicios') }}" class="volver-flecha" title="Volver"></a>
    <h2>Modificar Servicio</h2>

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
    <form id="buscarServicioForm" method="GET" action="{{ route('servicios.modificar') }}">
        <div class="busqueda-servicio">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar por nombre, ID o nomenclatura..." value="{{ old('busqueda', request('busqueda')) }}">
            <select name="servicio_id" id="servicio_id">
                <option value="">Selecciona un servicio</option>
                @foreach($servicios as $servicio)
                    <option value="{{ $servicio->idServicio }}" {{ (request('servicio_id') == $servicio->idServicio) ? 'selected' : '' }}>
                        {{ $servicio->nombreServicio }} (ID: {{ $servicio->idServicio }})
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn">Buscar</button>
            <hr class="divisor-modificar">
        </div>
    </form>

    {{-- Formulario de modificación --}}
    @if(isset($servicioSeleccionado))
    <form action="{{ route('servicios.update', $servicioSeleccionado->idServicio) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nombre del servicio --}}
        <div>
            <label for="nombreServicio">Nombre del Servicio</label>
            <input type="text" id="nombreServicio" name="nombreServicio" required maxlength="40" value="{{ old('nombreServicio', $servicioSeleccionado->nombreServicio) }}">
        </div>

        {{-- Descripción --}}
        <div>
            <label for="descripcionServicio">Descripción</label>
            <input type="text" id="descripcionServicio" name="descripcionServicio" required maxlength="60" value="{{ old('descripcionServicio', $servicioSeleccionado->descripcionServicio) }}">
        </div>

        {{-- Nomenclatura --}}
        <div>
            <label for="nomenclaturaServicio">Nomenclatura</label>
            <input type="text" id="nomenclaturaServicio" name="nomenclaturaServicio" required maxlength="4" value="{{ old('nomenclaturaServicio', $servicioSeleccionado->nomenclaturaServicio) }}">
        </div>

        {{-- Imagen --}}
        <div>
            <label for="imagenServicio">Imagen</label>
            <input type="file" id="imagenServicio" name="imagenServicio" accept="image/*">
            <input type="text" id="nombreImagen" name="nombreImagen" placeholder="Nombre personalizado de imagen (opcional)" maxlength="100">
            {{-- Vista previa --}}
            <img id="preview" src="{{ asset('imagenes/imgServicios/' . ($servicioSeleccionado->imagenServicio ?? 'tatuaje-ejemplo.jpg')) }}" alt="Vista previa">
        </div>

        {{-- Estado por defecto --}}
        <input type="hidden" name="idEstado" value="1">

        {{-- Botones --}}
        <div class="botones-accion">
            <button type="submit">Guardar Cambios</button>
            <a href="{{ route('servicios') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona un servicio para modificar.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Vista previa de imagen
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('imagenServicio');
        const preview = document.getElementById('preview');
        if(input){
            input.addEventListener('change', function (event) {
                const [file] = event.target.files;
                if (file) {
                    preview.src = URL.createObjectURL(file);
                    preview.style.display = 'block';
                    const nombreSinExtension = file.name.replace(/\.[^/.]+$/, "");
                    const nombreInput = document.getElementById('nombreImagen');
                    if (nombreInput && !nombreInput.value) {
                        nombreInput.value = nombreSinExtension;
                    }
                }
            });
        }
        // Cambio automático al seleccionar en el select
        const select = document.getElementById('servicio_id');
        if(select){
            select.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });
</script>
@endpush