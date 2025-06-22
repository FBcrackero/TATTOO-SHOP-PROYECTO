{{-- filepath: resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrarse | Tattoo Shop</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="fondo-granulado">
    <div class="login-container">
        <img src="{{ asset('imagenes/logo-formu.svg') }}" alt="Tattoo Shop Logo" class="logo-login">
        <h2>Crear cuenta</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="nombresUsu" placeholder="Nombres" value="{{ old('nombresUsu') }}" required>
            @error('nombresUsu') <div class="error">{{ $message }}</div> @enderror

            <input type="text" name="apellidosUsu" placeholder="Apellidos" value="{{ old('apellidosUsu') }}" required>
            @error('apellidosUsu') <div class="error">{{ $message }}</div> @enderror

            <input type="text" name="celularUsu" placeholder="Celular" value="{{ old('celularUsu') }}" required>
            @error('celularUsu') <div class="error">{{ $message }}</div> @enderror

            <!-- Tipo de documento -->
            <select name="idTipoDocumento" required>
                <option value="">Tipo de documento</option>
                @foreach($tiposDocumento as $tipo)
                    <option value="{{ $tipo->idTipoDocumento }}" {{ old('idTipoDocumento') == $tipo->idTipoDocumento ? 'selected' : '' }}>
                        {{ $tipo->nombreTipoDoc }}
                    </option>
                @endforeach
            </select>
            @error('idTipoDocumento') <div class="error">{{ $message }}</div> @enderror

            <input type="text" name="NIdentificacion" placeholder="N° Identificación" value="{{ old('NIdentificacion') }}" required>
            @error('NIdentificacion') <div class="error">{{ $message }}</div> @enderror

            <!-- Fecha de nacimiento -->
            <input
                type="text"
                id="fechaNacUsu"
                name="fechaNacUsu"
                placeholder="Fecha de nacimiento"
                value="{{ old('fechaNacUsu') }}"
                required
                onfocus="(this.type='date')"
                onblur="if(this.value==''){this.type='text'}"
            />
            @error('fechaNacUsu') <div class="error">{{ $message }}</div> @enderror

            <!-- Género -->
            <select name="idGenero" required>
                <option value="">Género</option>
                @foreach($generos as $genero)
                    <option value="{{ $genero->idGenero }}" {{ old('idGenero') == $genero->idGenero ? 'selected' : '' }}>
                        {{ $genero->nombreGenero }}
                    </option>
                @endforeach
            </select>
            @error('idGenero') <div class="error">{{ $message }}</div> @enderror

            <!-- País, Departamento, Ciudad -->
            <select name="idPais" id="idPais" required>
                <option value="">País</option>
                @foreach($paises as $pais)
                    <option value="{{ $pais->idPais }}" {{ old('idPais') == $pais->idPais ? 'selected' : '' }}>
                        {{ $pais->nombrePais }}
                    </option>
                @endforeach
            </select>
            @error('idPais') <div class="error">{{ $message }}</div> @enderror

            <select name="idDepartamento" id="idDepartamento" required>
                <option value="">Departamento</option>
            </select>
            @error('idDepartamento') <div class="error">{{ $message }}</div> @enderror

            <select name="idCiudad" id="idCiudad" required>
                <option value="">Ciudad</option>
            </select>
            @error('idCiudad') <div class="error">{{ $message }}</div> @enderror

            <input type="email" name="emailUsu" placeholder="Correo electrónico" value="{{ old('emailUsu') }}" required>
            @error('emailUsu') <div class="error">{{ $message }}</div> @enderror

            <input type="password" name="Contraseña" placeholder="Contraseña" required>
            @error('Contraseña') <div class="error">{{ $message }}</div> @enderror

            <input type="password" name="Contraseña_confirmation" placeholder="Confirmar contraseña" required>
            @error('Contraseña_confirmation') <div class="error">{{ $message }}</div> @enderror

            <button type="submit">Registrarse</button>
        </form>
        <a href="{{ route('login') }}" class="registro">¿Ya tienes cuenta? Inicia sesión aquí</a>
    </div>

    <!-- JS para selects dependientes -->
    <script>
        document.getElementById('idPais').addEventListener('change', function() {
            let paisId = this.value;
            fetch('/departamentos/' + paisId)
                .then(response => response.json())
                .then(data => {
                    let deptSelect = document.getElementById('idDepartamento');
                    deptSelect.innerHTML = '<option value="">Departamento</option>';
                    data.forEach(function(depto) {
                        deptSelect.innerHTML += `<option value="${depto.idDepartamento}">${depto.nombreDepartamento}</option>`;
                    });
                    document.getElementById('idCiudad').innerHTML = '<option value="">Ciudad</option>';
                });
        });

        document.getElementById('idDepartamento').addEventListener('change', function() {
            let deptId = this.value;
            fetch('/ciudades/' + deptId)
                .then(response => response.json())
                .then(data => {
                    let ciudadSelect = document.getElementById('idCiudad');
                    ciudadSelect.innerHTML = '<option value="">Ciudad</option>';
                    data.forEach(function(ciudad) {
                        ciudadSelect.innerHTML += `<option value="${ciudad.idCiudad}">${ciudad.nombreCiudad}</option>`;
                    });
                });
        });
    </script>
</body>
</html>