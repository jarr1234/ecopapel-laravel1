@extends('layouts.app')

@section('title', 'Verificar cuenta | Ecopapel')

@section('content')

<div class="login-container">

    <div class="login-card">

        <div class="login-icon">
            🔐
        </div>

        <h1>Verificar cuenta</h1>

        <p class="login-subtitulo">
            Ingresa el código para activar tu cuenta
        </p>

        @if(session('codigo'))

            <div class="mensaje mensaje-ok">
                Tu código es:
                <strong>{{ session('codigo') }}</strong>
            </div>

        @endif

        <form
            action="{{ route('verificar.post') }}"
            method="POST"
            class="login-form"
        >

            @csrf

            <input
                type="hidden"
                name="usuario"
                value="{{ $usuario }}"
            >

            <div class="login-grupo">

                <label for="codigo">
                    Código de verificación
                </label>

                <input
                    type="text"
                    id="codigo"
                    name="codigo"
                    value="{{ old('codigo') }}"
                    placeholder="Ingresa el código"
                    inputmode="numeric"
                    maxlength="6"
                    required
                    autofocus
                >

                @error('codigo')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <button type="submit" class="login-btn">
                ✅ Verificar cuenta
            </button>

        </form>

    </div>

</div>

@endsection