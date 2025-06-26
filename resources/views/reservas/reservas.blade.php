@extends('layouts.app')

@section('title', 'Reservas | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/reservar.css') }}">
@endpush

@section('content')

    {{-- Panel ADMIN FUERA DEL FLEX CONTAINER --}}
    @if(Auth::user()->idPerfil == 1)
    <div class="admin-reservas">
        <h1 class="admin-reservas-titulo">Administrar Reservas</h1>
        <p class="admin-reservas-subtitulo">
            Gestiona las reservas de TATTOO SHOP de manera eficiente
        </p>
        <div class="admin-reservas-botones">
            <a href="{{ route('reservas.ingresar') }}" class="admin-btn">Ingresar reserva</a>
            <a href="{{ route('reservas.modificar') }}" class="admin-btn">Modificar reserva</a>
            <a href="{{ route('reservas.eliminar') }}" class="admin-btn">Eliminar reserva</a>
            <a href="{{ route('reservas.consultar') }}" class="admin-btn">Consultar reservas</a>
            <a href="{{ route('reservas.estado') }}" class="admin-btn">Cambiar estado de reserva</a>
        </div>
    </div>
    @endif

    {{-- Panel USUARIO/ARTISTA --}}
    @if(Auth::user()->idPerfil != 1)
    <div class="reservas-flex-container">
        {{-- Listado de reservas --}}
        <div class="consultar-container">
            <h2>Mis Reservas</h2>
            @if(Auth::user()->idPerfil == 2)
                <p>
                    Esta reserva es para que te encuentres personalmente con el artista encargado y puedan llegar a un acuerdo para empezar a trabajar
                </p>
            @endif
            @if(session('success'))
                <div class="mensaje-exito">{{ session('success') }}</div>
            @endif
            <div class="tabla-servicios">
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Servicio</th>
                            <th>Artista</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservas as $reserva)
                            <tr>
                                <td>{{ $reserva->fechaReserva }}</td>
                                <td>{{ $reserva->horaReserva }}</td>
                                <td>{{ $reserva->servicio->nombreServicio ?? '' }}</td>
                                <td>{{ $reserva->artista->nombresUsu ?? '' }}</td>
                                <td>{{ $reserva->descripcionReserva }}</td>
                                <td>{{ $reserva->estado->nombreEstado ?? 'Pendiente' }}</td>
                                <td>
                                    {{-- Usuario puede cancelar --}}
                                    @if(Auth::user()->idPerfil == 2 && $reserva->idEstado == 3 && Auth::id() == $reserva->idUsuario)
                                        <form action="{{ route('reservas.cancelar', $reserva->idReserva) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn-accion btn-cancelar" onclick="return confirm('¿Seguro que deseas cancelar la reserva?')">Cancelar</button>
                                        </form>
                                    {{-- Artista puede aceptar o rechazar --}}
                                    @elseif(Auth::user()->idPerfil == 3 && $reserva->idEstado == 3 && Auth::id() == $reserva->idArtista)
                                        <form action="{{ route('reservas.aceptar', $reserva->idReserva) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn-accion btn-aceptar">Aceptar</button>
                                        </form>
                                        <form action="{{ route('reservas.rechazar', $reserva->idReserva) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn-accion btn-rechazar">Rechazar</button>
                                        </form>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No hay reservas para mostrar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Formulario de nueva reserva solo para usuarios --}}
        @if(Auth::user()->idPerfil == 2)
        <div class="ingresar-container">
            <h2>Reservar Cita</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('reservas.store') }}" method="POST">
                @csrf
                <div>
                    <label>Nombre</label>
                    <input type="text" value="{{ Auth::user()->nombresUsu }}" readonly>
                </div>
                <div>
                    <label>Tipo de documento</label>
                    <input type="text" value="{{ Auth::user()->tipoDocumento->nombreTipoDoc ?? '' }}" readonly>
                </div>
                <div>
                    <label>N° Identificación</label>
                    <input type="text" value="{{ Auth::user()->NidentificacionUsu }}" readonly>
                </div>
                <div>
                    <label>Correo</label>
                    <input type="text" value="{{ Auth::user()->emailUsu }}" readonly>
                </div>
                <div>
                    <label>Edad</label>
                    <input type="text" value="{{ \Carbon\Carbon::parse(Auth::user()->fechaNacUsu)->age }}" readonly>
                </div>
                <div>
                    <label>Fecha</label>
                    <input type="date" name="fechaReserva" required value="{{ old('fechaReserva') }}">
                </div>
                <div>
                    <label>Hora</label>
                    <input type="time" name="horaReserva" required value="{{ old('horaReserva') }}">
                </div>
                <div>
                    <label>Servicio</label>
                    <select name="idServicio" required>
                        <option value="">Selecciona un servicio</option>
                        @foreach($servicios as $servicio)
                            <option value="{{ $servicio->idServicio }}" {{ old('idServicio') == $servicio->idServicio ? 'selected' : '' }}>
                                {{ $servicio->nombreServicio }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Artista</label>
                    <select name="idArtista" required>
                        <option value="">Selecciona un artista</option>
                        @foreach($artistas as $artista)
                            <option value="{{ $artista->idUsuario }}" {{ old('idArtista') == $artista->idUsuario ? 'selected' : '' }}>
                                {{ $artista->nombresUsu }} {{ $artista->apellidosUsu }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Descripción</label>
                    <textarea name="descripcionReserva" maxlength="255">{{ old('descripcionReserva') }}</textarea>
                </div>
                <div class="botones-accion">
                    <button type="submit">Reservar</button>
                </div>
            </form>
        </div>
        @endif
    </div>
    @endif {{-- Fin panel usuario/artista --}}
@endsection