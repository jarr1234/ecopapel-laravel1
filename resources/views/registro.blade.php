@extends('layouts.app')

@section('title', 'Crear cuenta | Ecopapel')

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
                Crea tu cuenta
            </h1>

            <p>
                Regístrate para agregar productos a tu carrito
                y realizar tus compras en Ecopapel.
            </p>

            <div class="acceso-beneficios">

                <div>
                    <span>🛒</span>
                    <p>Agrega tus productos favoritos</p>
                </div>

                <div>
                    <span>📦</span>
                    <p>Realiza tus pedidos fácilmente</p>
                </div>

                <div>
                    <span>🔒</span>
                    <p>Compra desde tu cuenta de forma segura</p>
                </div>

            </div>

        </div>

        <div class="acceso-formulario">

            <div class="login-card">

                <span class="login-etiqueta">
                    Nueva cuenta
                </span>

                <h2>Crear cuenta</h2>

                <p class="login-subtitulo">
                    Completa tus datos para comenzar.
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
                            placeholder="Mínimo 6 caracteres"
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
                            placeholder="Ej. 963 123 4567"
                            maxlength="20"
                            required
                        >

                        @error('telefono')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                    <button
                        type="submit"
                        class="login-btn"
                    >
                        Crear mi cuenta
                    </button>

                </form>

                <div class="login-registro">

                    <span>
                        ¿Ya tienes una cuenta?
                    </span>

                    <a href="{{ route('login') }}">
                        Iniciar sesión
                    </a>

                </div>

                <a
                    href="{{ route('productos') }}"
                    class="acceso-volver"
                >
                    ← Continuar viendo productos
                </a>

            </div>

        </div>

    </div>

</section>

@endsection