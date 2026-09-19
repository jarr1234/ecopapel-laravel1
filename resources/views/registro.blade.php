@extends('layouts.app')

@section('title', 'Crear cuenta | Ecopapel')

@section('content')

<div class="login-container">

    <div class="login-card">

        <div class="login-icon">
            📱
        </div>

        <h1>Crear cuenta</h1>

        <p class="login-subtitulo">
            Regístrate para comprar en Ecopapel
        </p>

        <form
            action="{{ route('registro.post') }}"
            method="POST"
            class="login-form"
        >

            @csrf

            <div class="login-grupo">

                <label for="usuario">
                    Usuario
                </label>

                <input
                    type="text"
                    id="usuario"
                    name="usuario"
                    value="{{ old('usuario') }}"
                    placeholder="Escribe tu usuario"
                    maxlength="100"
                    required
                    autofocus
                >

                @error('usuario')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <div class="login-grupo">

                <label for="password">
                    Contraseña
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Escribe tu contraseña"
                    minlength="6"
                    required
                >

                @error('password')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <div class="login-grupo">

                <label for="telefono">
                    Número celular
                </label>

                <input
                    type="tel"
                    id="telefono"
                    name="telefono"
                    value="{{ old('telefono') }}"
                    placeholder="Escribe tu número celular"
                    maxlength="20"
                    required
                >

                @error('telefono')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <button type="submit" class="login-btn">
                Crear cuenta
            </button>

        </form>

        <div class="login-registro">

            <span>¿Ya tienes una cuenta?</span>

            <a href="{{ route('login') }}">
                Iniciar sesión
            </a>

        </div>

    </div>

</div>

@endsection