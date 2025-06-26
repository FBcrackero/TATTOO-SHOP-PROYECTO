@extends('layouts.app')

@section('title', 'Productos de Nuestra Tienda | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/productos.css') }}">
@endpush

@section('content')
<div class="productos-section">

    {{-- Panel ADMIN --}}
    @if(Auth::user()->idPerfil == 1)
    <div class="admin-productos">
        <h1 class="admin-productos-titulo">Administrar Productos</h1>
        <p class="admin-productos-subtitulo">
                Administra los Productos de TATTOO SHOP de manera eficiente
        </p>
        <div class="admin-productos-botones">
            <a href="{{ route('productos.ingresar') }}" class="admin-btn">Ingresar producto</a>
            <a href="{{ route('productos.modificar') }}" class="admin-btn">Modificar producto</a>
            <a href="{{ route('productos.eliminar') }}" class="admin-btn">Eliminar producto</a>
            <a href="{{ route('productos.consultar') }}" class="admin-btn">Consultar productos</a>
            <a href="{{ route('productos.estado') }}" class="admin-btn">Cambiar estado de producto</a>
        </div>
    </div>
    @endif

    {{-- Panel USUARIO --}}
    @if(Auth::user()->idPerfil != 1)
    <h1 class="productos-titulo">PRODUCTOS DE NUESTRA TIENDA</h1>
    <p class="productos-subtitulo">Todo lo que necesitas para tu experiencia Tattoo</p>

    <!-- Botón de filtros -->
    <button id="btn-filtros" class="filtro-btn">
        <i class='bx bx-filter'></i> Filtros
    </button>

    <!-- Panel lateral de filtros -->
    <div id="panel-filtros" class="panel-filtros">
        <div class="filtros-header">
            <h3 class="filtro-titulo">Filtrar Productos</h3>
        </div>
        <form method="GET" action="{{ route('productos') }}">
            <!-- Categorías como botones -->
            <div class="filtro-bloque">
                <label class="filtro-label">Categoría:</label>
                <div class="filtro-opciones">
                    @foreach($categorias as $categoria)
                        <label class="categoria-chip">
                            <input type="checkbox" name="categorias[]" value="{{ $categoria->idCategoriaProducto }}"
                                {{ in_array($categoria->idCategoriaProducto, request('categorias', [])) ? 'checked' : '' }}>
                            <span>{{ $categoria->nombreCategoriaProducto }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Precio como slider -->
            <div class="filtro-bloque">
                <label class="filtro-label">Precio máximo:</label>
                <span class="precio-label" id="precio-max-label">${{ request('precio_max', 1000000) }}</span>
                <input type="range" min="0" max="5000000" step="1000" name="precio_max" id="precio_max" value="{{ request('precio_max', 1000000) }}">
            </div>

            <!-- Botones -->
            <div class="filtro-botones">
                <button type="submit" class="btn-aplicar">Aplicar</button>
                <button type="button" id="restaurar-filtros" class="btn-restaurar">Restaurar</button>
                <button type="button" id="cerrar-filtros" class="btn-cancelar">Cancelar</button>
            </div>
        </form>
    </div>

    <!-- Grid de productos -->
    <div class="productos-grid">
        @forelse($productos as $producto)
            <div class="producto-card">
                <img src="{{ asset('imagenes/imgProductos/' . ($producto->imagenProducto ?? 'producto-ejemplo.jpg')) }}" alt="Imagen producto" class="producto-img">
                <div class="producto-info">
                    <span class="producto-nombre">{{ strtoupper($producto->nombreProducto) }}</span>
                    <hr class="producto-divisor">
                    <p class="producto-desc">{{ $producto->descripcionProducto }}</p>
                    <div class="producto-precio-btn">
                        <span class="producto-precio">${{ number_format($producto->precioCompra, 0, ',', '.') }}</span>
                        <form class="form-agregar-carrito" data-producto="{{ $producto->codProducto }}">
                            @csrf
                            <input type="hidden" name="cantidad" value="1">
                            <button type="submit" class="producto-btn">COMPRAR</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p style="margin-top:30px;">No hay productos para mostrar.</p>
        @endforelse
    </div>
    @endif {{-- Fin panel usuario --}}
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnFiltros = document.getElementById('btn-filtros');
    const panelFiltros = document.getElementById('panel-filtros');
    const cerrarFiltros = document.getElementById('cerrar-filtros');
    const precioMax = document.getElementById('precio_max');
    const precioMaxLabel = document.getElementById('precio-max-label');

    if(btnFiltros && panelFiltros){
        btnFiltros.addEventListener('click', () => {
            panelFiltros.classList.toggle('abierto');
            btnFiltros.classList.toggle('activo');
        });
    }
    if(cerrarFiltros && panelFiltros && btnFiltros){
        cerrarFiltros.addEventListener('click', () => {
            panelFiltros.classList.remove('abierto');
            btnFiltros.classList.remove('activo');
        });
    }
    if(precioMax && precioMaxLabel){
        precioMax.addEventListener('input', function() {
            precioMaxLabel.textContent = '$' + this.value;
        });
    }
    const restaurarFiltros = document.getElementById('restaurar-filtros');
    if(restaurarFiltros){
        restaurarFiltros.addEventListener('click', function() {
            window.location.href = "{{ route('productos') }}";
        });
    }
});
</script>
@endpush
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('.form-agregar-carrito').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const codProducto = this.getAttribute('data-producto');
            const cantidad = this.querySelector('input[name="cantidad"]').value;
            const token = this.querySelector('input[name="_token"]').value;

            fetch("{{ url('/carrito/agregar') }}/" + codProducto, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ cantidad: cantidad })
            })
            .then(response => response.json())
            .then(data => {
                // Mostrar mensaje de éxito
                let msg = document.createElement('div');
                msg.className = 'mensaje-exito';
                msg.innerText = '¡Producto agregado al carrito!';
                document.body.appendChild(msg);
                setTimeout(() => msg.remove(), 1800);

                let icono = document.querySelector('.carrito-link i');
                if(icono) {
                    icono.classList.add('carrito-activo');
                    setTimeout(() => icono.classList.remove('carrito-activo'), 1000);
                }


                // Opcional: Actualizar el contador del carrito en el menú
                if(data.carritoCount !== undefined){
                    let badge = document.querySelector('.carrito-badge');
                    if(badge) {
                        badge.textContent = data.carritoCount;
                    }
                }
            });
        });
    });
});
</script>
@endpush
