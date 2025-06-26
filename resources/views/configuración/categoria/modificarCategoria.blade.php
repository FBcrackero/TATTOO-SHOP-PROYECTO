@extends('layouts.app')

@section('title', 'Modificar Categoría | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('categoria') }}" class="volver-flecha" title="Volver"></a>
    <h2>Modificar Categoría</h2>

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

    {{-- Selección de categoría --}}
    <form id="buscarCategoriaForm" method="GET" action="{{ route('categoria.modificar') }}">
        <div class="busqueda-servicio">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar por nombre, ID o nomenclatura..." value="{{ old('busqueda', request('busqueda')) }}">
            <select name="categoria_id" id="categoria_id">
                <option value="">Selecciona una categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->idCategoriaProducto }}" {{ (request('categoria_id') == $categoria->idCategoriaProducto) ? 'selected' : '' }}>
                        {{ $categoria->nombreCategoriaProducto }} (ID: {{ $categoria->idCategoriaProducto }})
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn">Buscar</button>
            <hr class="divisor-modificar">
        </div>
    </form>

    {{-- Formulario de modificación --}}
    @if(isset($categoriaSeleccionada))
    <form action="{{ route('categoria.update', $categoriaSeleccionada->idCategoriaProducto) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>ID:</label>
            <input type="text" value="{{ $categoriaSeleccionada->idCategoriaProducto }}" readonly>
        </div>
        <div>
            <label for="nombreCategoriaProducto">Nombre</label>
            <input type="text" id="nombreCategoriaProducto" name="nombreCategoriaProducto" required maxlength="40" value="{{ old('nombreCategoriaProducto', $categoriaSeleccionada->nombreCategoriaProducto) }}">
        </div>
        <div>
            <label for="descripcionCategoriaProducto">Descripción</label>
            <input type="text" id="descripcionCategoriaProducto" name="descripcionCategoriaProducto" required maxlength="100" value="{{ old('descripcionCategoriaProducto', $categoriaSeleccionada->descripcionCategoriaProducto) }}">
        </div>
        <div>
            <label for="nomenclaturaCategoriaProducto">Nomenclatura</label>
            <input type="text" id="nomenclaturaCategoriaProducto" name="nomenclaturaCategoriaProducto" required maxlength="4" value="{{ old('nomenclaturaCategoriaProducto', $categoriaSeleccionada->nomenclaturaCategoriaProducto) }}">
        </div>
        <div class="botones-accion">
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
            <a href="{{ route('categoria') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona una categoría para modificar.</p>
    @endif
</div>
@endsection