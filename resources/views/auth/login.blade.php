{{-- filepath: resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión | Tattoo Shop</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="fondo-granulado">
    <div class="login-container">
        <img src="{{ asset('imagenes/logo-formu.svg') }}" alt="Tattoo Shop Logo" class="logo-login">
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="emailUsu" placeholder="Correo electrónico" required autofocus>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>
        <a href="{{ route('password.request') }}" class="olvide">¿Olvidaste tu contraseña?</a>
        <a href="{{ route('register') }}" class="registro">¿No tienes cuenta? Regístrate aquí</a>
    </div>
</body>
</html>