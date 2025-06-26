@extends('layouts.app')

@section('title', 'Inicio | Tattoo Shop')

@section('content')
<main>
    <div class="lateral-izq">
        <img src="{{ asset('imagenes/kanji.svg') }}" alt="Kanji Tattoo" class="kanji-img">
    </div>
    <div class="contenido-central">
        <div class="fondo-central">
            <div class="img-fondo-central">
                <img src="{{ asset('imagenes/img1_tattoo.svg') }}" alt="Tattoo fondo">
            </div>
            <h1>TATTOO SHOP</h1>
            <p>No solo se trata de las herramientas, es sobre precisión, diseño y atención a los detalles.</p>
            <a href="{{ url('/reservas') }}" class="btn-reserva">RESERVA AHORA</a>
        </div>
    </div>
</main>
@endsection