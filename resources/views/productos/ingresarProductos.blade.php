@extends('layouts.app')

@section('title', 'Ingresar Producto | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <h2>Ingresar Nuevo Producto</h2>

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

    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Nombre del producto --}}
        <div>
            <label for="nombreProducto">Nombre del Producto</label>
            <input type="text" id="nombreProducto" name="nombreProducto" required maxlength="40">
        </div>

        {{-- Descripción --}}
        <div>
            <label for="descripcionProducto">Descripción</label>
            <input type="text" id="descripcionProducto" name="descripcionProducto" required maxlength="60">
        </div>

        {{-- Nomenclatura --}}
        <div>
            <label for="nomenclaturaProducto">Nomenclatura</label>
            <input type="text" id="nomenclaturaProducto" name="nomenclaturaProducto" required maxlength="4">
        </div>

        {{-- Stock mínimo --}}
        <div>
            <label for="stockMin">Stock Mínimo</label>
            <input type="number" id="stockMin" name="stockMin" min="0" step="1" required>
        </div>

        {{-- Stock máximo --}}
        <div>
            <label for="stockMax">Stock Máximo</label>
            <input type="number" id="stockMax" name="stockMax" min="0" step="1" required>
        </div>

        {{-- Cantidad disponible --}}
        <div>
            <label for="cantidadDisponible">Cantidad Disponible</label>
            <input type="number" id="cantidadDisponible" name="cantidadDisponible" min="0" step="1" required>
        </div>

        {{-- Categoría de producto --}}
        <div>
            <label for="idCategoria">Categoría de Producto</label>
            <select id="idCategoria" name="idCategoria" required>
                <option value="">Seleccione una categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->idCategoriaProducto }}">{{ $categoria->nombreCategoriaProducto }}</option>
                @endforeach
            </select>
        </div>

        {{-- Unidad de medida --}}
        <div>
            <label for="idUnidadMedida">Unidad de Medida</label>
            <select id="idUnidadMedida" name="idUnidadMedida" required>
                <option value="">Seleccione una unidad</option>
                @foreach($unidades as $unidad)
                    <option value="{{ $unidad->idUnidadMedida }}">{{ $unidad->nombreUnidadMedida }}</option>
                @endforeach
            </select>
        </div>

        {{-- Precio de compra --}}
        <div>
            <label for="precioCompra">Precio de Compra</label>
            <input type="number" id="precioCompra" name="precioCompra" min="0" step="0.01" required>
        </div>

        {{-- Imagen --}}
        <div>
            <label for="imagenProducto">Imagen</label>
            <input type="file" id="imagenProducto" name="imagenProducto" accept="image/*">
            <input type="text" id="nombreImagen" name="nombreImagen" placeholder="Nombre personalizado de imagen (opcional)" maxlength="100">
            <img id="preview" src="#" alt="Vista previa" style="display:none;">
        </div>

        {{-- Estado por defecto --}}
        <input type="hidden" name="idEstado" value="1">

        {{-- Botones --}}
        <div class="botones-accion">
            <button type="submit">Guardar Producto</button>
            <a href="{{ route('productos') }}" class="btn">Cancelar</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('imagenProducto');
        const preview = document.getElementById('preview');

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
    });
</script>
@endpush