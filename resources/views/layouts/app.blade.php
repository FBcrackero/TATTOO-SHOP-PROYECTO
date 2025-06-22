{{-- filepath: resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Tattoo Shop')</title>
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <link rel="stylesheet" href="{{ asset('css/servicios.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400;700&display=swap" rel="stylesheet">
    @stack('styles')

</head>
<body>
    {{-- Header y navbar --}}
    <header>
        <div class="logo-superior">
            <img src="{{ asset('imagenes/logo.svg') }}" alt="Logo" class="logo">
        </div>
        <div class="header-superior">
            <div class="buscador">
                <input type="text" placeholder="Buscar">
                <button><i class='bx bx-search'></i></button>
            </div>
        </div>
        <nav>
            <ul class="menu">
                <li><a href="{{ url('/inicio') }}" class="{{ request()->is('inicio') ? 'activo' : '' }}">INICIO</a></li>
                <li><a href="{{ url('/servicios') }}" class="{{ request()->is('servicios') ? 'activo' : '' }}">SERVICIOS</a></li>
                <li><a href="#">PRODUCTOS</a></li>
                <li><a href="#">RESERVAR</a></li>
                @auth
                    @if(Auth::user()->idPerfil == 1)
                        <li><a href="#">CONFIGURACIÓN</a></li>
                        <li><a href="#">INVENTARIO</a></li>
                    @endif
                    <li>
                        <a href="#">PERFIL</a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;">
                                CERRAR SESIÓN
                            </button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">INICIAR SESIÓN</a></li>
                @endauth
                <li><a href="#"><i class='bx bx-cart'></i></a></li>
            </ul>
        </nav>
        <div class="nav-divider"></div>
    </header>

    {{-- Contenido dinámico --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer y redes flotantes --}}
    <div class="redes-flotantes">
        <a href="#"><i class='bx bxl-whatsapp'></i></a>
        <a href="#"><i class='bx bxl-facebook-circle'></i></a>
        <a href="#"><i class='bx bxl-twitter'></i></a>
    </div>
    <footer>
        <div class="copyright">
            COPYRIGHT 2025<br>
            TODOS LOS DERECHOS RESERVADOS
        </div>
    </footer>
    @stack('scripts')
</body>
</html>