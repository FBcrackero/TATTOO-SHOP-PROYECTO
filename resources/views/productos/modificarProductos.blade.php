@extends('layouts.app')

@section('title', 'Modificar Producto | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('productos') }}" class="volver-flecha" title="Volver"></a>
    <h2>Modificar Producto</h2>

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
    <form id="buscarProductoForm" method="GET" action="{{ route('productos.modificar') }}">
        <div class="busqueda-servicio">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar por nombre, ID o nomenclatura..." value="{{ old('busqueda', request('busqueda')) }}">
            <select name="producto_id" id="producto_id">
                <option value="">Selecciona un producto</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->codProducto }}" {{ (request('producto_id') == $producto->codProducto) ? 'selected' : '' }}>
                        {{ $producto->nombreProducto }} (ID: {{ $producto->codProducto }})
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn">Buscar</button>
            <hr class="divisor-modificar">
        </div>
    </form>

    {{-- Formulario de modificación --}}
    @if(isset($productoSeleccionado))
    <form action="{{ route('productos.update', $productoSeleccionado->codProducto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nombre del producto --}}
        <div>
            <label for="nombreProducto">Nombre del Producto</label>
            <input type="text" id="nombreProducto" name="nombreProducto" required maxlength="40" value="{{ old('nombreProducto', $productoSeleccionado->nombreProducto) }}">
        </div>

        {{-- Descripción --}}
        <div>
            <label for="descripcionProducto">Descripción</label>
            <input type="text" id="descripcionProducto" name="descripcionProducto" required maxlength="60" value="{{ old('descripcionProducto', $productoSeleccionado->descripcionProducto) }}">
        </div>

        {{-- Nomenclatura --}}
        <div>
            <label for="nomenclaturaProducto">Nomenclatura</label>
            <input type="text" id="nomenclaturaProducto" name="nomenclaturaProducto" required maxlength="4" value="{{ old('nomenclaturaProducto', $productoSeleccionado->nomenclaturaProducto) }}">
        </div>

        {{-- Stock mínimo --}}
        <div>
            <label for="stockMin">Stock Mínimo</label>
            <input type="number" id="stockMin" name="stockMin" min="0" step="1" required value="{{ old('stockMin', $productoSeleccionado->stockMin) }}">
        </div>

        {{-- Stock máximo --}}
        <div>
            <label for="stockMax">Stock Máximo</label>
            <input type="number" id="stockMax" name="stockMax" min="0" step="1" required value="{{ old('stockMax', $productoSeleccionado->stockMax) }}">
        </div>

        {{-- Cantidad disponible --}}
        <div>
            <label for="cantidadDisponible">Cantidad Disponible</label>
            <input type="number" id="cantidadDisponible" name="cantidadDisponible" min="0" step="1" required value="{{ old('cantidadDisponible', $productoSeleccionado->cantidadDisponible) }}">
        </div>

        {{-- Categoría de producto --}}
        <div>
            <label for="idCategoria">Categoría de Producto</label>
            <select id="idCategoria" name="idCategoria" required>
                <option value="">Seleccione una categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->idCategoriaProducto }}" {{ (old('idCategoria', $productoSeleccionado->idCategoria) == $categoria->idCategoriaProducto) ? 'selected' : '' }}>
                        {{ $categoria->nombreCategoriaProducto }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Unidad de medida --}}
        <div>
            <label for="idUnidadMedida">Unidad de Medida</label>
            <select id="idUnidadMedida" name="idUnidadMedida" required>
                <option value="">Seleccione una unidad</option>
                @foreach($unidades as $unidad)
                    <option value="{{ $unidad->idUnidadMedida }}" {{ (old('idUnidadMedida', $productoSeleccionado->idUnidadMedida) == $unidad->idUnidadMedida) ? 'selected' : '' }}>
                        {{ $unidad->nombreUnidadMedida }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Precio de compra --}}
        <div>
            <label for="precioCompra">Precio de Compra</label>
            <input type="number" id="precioCompra" name="precioCompra" min="0" step="0.01" required value="{{ old('precioCompra', $productoSeleccionado->precioCompra) }}">
        </div>

        {{-- Imagen --}}
        <div>
            <label for="imagenProducto">Imagen</label>
            <input type="file" id="imagenProducto" name="imagenProducto" accept="image/*">
            <input type="text" id="nombreImagen" name="nombreImagen" placeholder="Nombre personalizado de imagen (opcional)" maxlength="100">
            <img id="preview" src="{{ asset('imagenes/imgProductos/' . ($productoSeleccionado->imagenProducto ?? 'producto-ejemplo.jpg')) }}" alt="Vista previa">
        </div>

        {{-- Estado por defecto --}}
        <input type="hidden" name="idEstado" value="1">

        {{-- Botones --}}
        <div class="botones-accion">
            <button type="submit">Guardar Cambios</button>
            <a href="{{ route('productos') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona un producto para modificar.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Vista previa de imagen
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('imagenProducto');
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
        const select = document.getElementById('producto_id');
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