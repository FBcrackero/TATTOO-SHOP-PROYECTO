@extends('layouts.app')

@section('title', 'Servicios | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/servicios.css') }}">
@endpush

@section('content')

{{-- Mensaje de éxito --}}
@if(session('success'))
    <div class="notificacion-exito" id="notificacion-exito">
        {{ session('success') }}
    </div>
@endif

@auth
    @if(Auth::user()->idPerfil == 1)
        <div class="admin-servicios">
            <h1 class="admin-servicios-titulo">Administrar Servicios</h1>
            <p class="admin-servicios-subtitulo">
                Administra los Servicios de TATTOO SHOP de manera eficiente
            </p>
            <div class="admin-servicios-botones">
                <a href="{{ route('servicios.ingresar') }}" class="admin-btn">Ingresar servicio</a>
                <a href="{{ route('servicios.modificar') }}" class="admin-btn">Modificar servicio</a>
                <a href="{{ route('servicios.eliminar') }}" class="admin-btn">Eliminar servicio</a>
                <a href="{{ route('servicios.consultar') }}" class="admin-btn">Consultar servicio</a>
                <a href="{{ route('servicios.estado') }}" class="admin-btn">Cambiar estado de servicio</a>

            </div>
        </div>
    @else
        <div class="servicios-section">
            <h1 class="servicios-titulo">TU IDEA, NUESTRA AGUJA</h1>
            <p class="servicios-subtitulo">Desde lo pequeño hasta lo complejo, la aguja lo dice todo</p>
            <div class="servicios-grid">
                @foreach($servicios as $servicio)
                    <div class="servicio-card">
                        <img src="{{ asset('imagenes/imgServicios/' . ($servicio->imagenServicio ?? 'tatuaje-ejemplo.jpg')) }}" alt="Imagen servicio" class="servicio-img">
                        <div class="servicio-info">
                            <span class="servicio-nombre">{{ strtoupper($servicio->nombreServicio) }}</span>
                            <hr class="servicio-divisor">
                            <p class="servicio-desc">{{ $servicio->descripcionServicio }}</p>
                            <div class="servicio-precio-btn">
                                <button class="servicio-btn">RESERVAR CITA</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endauth
@endsection

@push('scripts')
<script>
    setTimeout(function() {
        var notif = document.getElementById('notificacion-exito');
        if(notif) notif.style.display = 'none';
    }, 4000);
</script>