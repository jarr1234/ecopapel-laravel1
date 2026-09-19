@extends('layouts.app')

@section('title', 'Iniciar sesión | Ecopapel')

@section('content')

<div class="login-container">

    <div class="login-card">

        <div class="login-icon">🔐</div>

        <h1>Iniciar sesión</h1>

        <p class="login-subtitulo">
            Ingresa a tu cuenta de Ecopapel
        </p>

        @if(session('error'))
            <div class="login-error">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="login-form">
            @csrf

            <div class="login-grupo">
                <label for="usuario">Usuario</label>

                <input
                    type="text"
                    id="usuario"
                    name="usuario"
                    placeholder="Escribe tu usuario"
                    value="{{ old('usuario') }}"
                    required
                    autofocus
                >
            </div>

            <div class="login-grupo">
                <label for="password">Contraseña</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Escribe tu contraseña"
                    required
                >
            </div>

            <button type="submit" class="login-btn">
                Iniciar sesión
            </button>

        </form>

        <div class="login-registro">
            <span>¿No tienes una cuenta?</span>

            <a href="{{ route('registro') }}">
                Crear cuenta
            </a>
        </div>

    </div>

</div>

@endsection
