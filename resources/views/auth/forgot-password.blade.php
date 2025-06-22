{{-- filepath: resources/views/auth/forgot-password.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña | Tattoo Shop</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="fondo-granulado">
    <div class="login-container">
        <img src="{{ asset('imagenes/logo-formu.svg') }}" alt="Tattoo Shop Logo" class="logo-login">
        <h2>Recuperar contraseña</h2>
        <div class="mb-4" style="color:#bfa94a;">
            ¿Olvidaste tu contraseña? Ingresa tu correo y te enviaremos un enlace para restablecerla.
        </div>

        @if (session('status'))
            <div class="mb-4" style="color: #4caf50;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit">Enviar enlace de recuperación</button>
        </form>
        <a href="{{ route('login') }}" class="registro">Volver al inicio de sesión</a>
    </div>
</body>
</html>
