@extends('layouts.app')

@section('title', 'Estado de la Categoría | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('categoria') }}" class="volver-flecha" title="Volver"></a>
    <h2>Cambiar Estado de la Categoría</h2>

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
    <form id="buscarCategoriaForm" method="GET" action="{{ route('categoria.estado') }}">
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

    {{-- Formulario de cambio de estado --}}
    @if(isset($categoriaSeleccionada))
    <form action="{{ route('categoria.estado.update', $categoriaSeleccionada->idCategoriaProducto) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>ID:</label>
            <input type="text" value="{{ $categoriaSeleccionada->idCategoriaProducto }}" readonly>
        </div>
        <div>
            <label>Nombre:</label>
            <input type="text" value="{{ $categoriaSeleccionada->nombreCategoriaProducto }}" readonly>
        </div>
        <div>
            <label>Nomenclatura:</label>
            <input type="text" value="{{ $categoriaSeleccionada->nomenclaturaCategoriaProducto }}" readonly>
        </div>
        <div>
            <label>Estado:</label>
            <select name="idEstado" required>
                @foreach($estados as $estado)
                    <option value="{{ $estado->idEstado }}" {{ $categoriaSeleccionada->idEstado == $estado->idEstado ? 'selected' : '' }}>
                        {{ $estado->nombreEstado }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="botones-accion">
            <button type="submit" class="btn btn-success">Actualizar Estado</button>
            <a href="{{ route('categoria') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona una categoría para cambiar su estado.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('categoria_id');
        if(select){
            select.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });
</script>
@endpush