@extends('layouts.app')

@section('title', 'Verificar cuenta | Ecopapel')

@section('content')

<section class="pagina-acceso">

    <div class="acceso-layout">

        <div class="acceso-presentacion">

            <div class="acceso-marca">
                <img
                    src="{{ asset('imagenes/logo2.png') }}"
                    alt="Ecopapel"
                >
                <span>Ecopapel</span>
            </div>

            <h1>
                Verifica tu cuenta
            </h1>

            <p>
                Solo falta un paso para activar tu cuenta
                y comenzar a comprar en Ecopapel.
            </p>

            <div class="acceso-beneficios">

                <div>
                    <span>🔐</span>
                    <p>Verificación de tu cuenta</p>
                </div>

                <div>
                    <span>🛒</span>
                    <p>Acceso a tu carrito</p>
                </div>

                <div>
                    <span>📦</span>
                    <p>Realiza tus pedidos fácilmente</p>
                </div>

            </div>

        </div>

        <div class="acceso-formulario">

            <div class="login-card">

                <span class="login-etiqueta">
                    Verificación
                </span>

                <h2>Ingresa tu código</h2>

                <p class="login-subtitulo">
                    Escribe el código para activar tu cuenta.
                </p>

                @if(session('codigo'))

                    <div class="codigo-verificacion">

                        <span>
                            Tu código de verificación es
                        </span>

                        <strong>
                            {{ session('codigo') }}
                        </strong>

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
                            placeholder="Ingresa el código de 6 dígitos"
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

                    <button
                        type="submit"
                        class="login-btn"
                    >
                        Verificar cuenta
                    </button>

                </form>

                <a
                    href="{{ route('login') }}"
                    class="acceso-volver"
                >
                    ← Volver a iniciar sesión
                </a>

            </div>

        </div>

    </div>

</section>

@endsection