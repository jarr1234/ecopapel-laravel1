@extends('layouts.app')

@section('title', 'Iniciar sesión | Ecopapel')

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
                Bienvenido de nuevo
            </h1>

            <p>
                Inicia sesión para agregar productos a tu carrito
                y realizar tus compras.
            </p>

            <div class="acceso-beneficios">

                <div>
                    <span>🛒</span>
                    <p>Guarda productos en tu carrito</p>
                </div>

                <div>
                    <span>📦</span>
                    <p>Realiza tus pedidos fácilmente</p>
                </div>

                <div>
                    <span>🔒</span>
                    <p>Accede de forma segura a tu cuenta</p>
                </div>

            </div>

        </div>

        <div class="acceso-formulario">

            <div class="login-card">

                <span class="login-etiqueta">
                    Mi cuenta
                </span>

                <h2>Iniciar sesión</h2>

                <p class="login-subtitulo">
                    Ingresa tus datos para continuar.
                </p>

                @if(session('error'))

                    <div class="login-error">
                        {{ session('error') }}
                    </div>

                @endif

                <form
                    action="{{ route('login.post') }}"
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
                            placeholder="Escribe tu usuario"
                            value="{{ old('usuario') }}"
                            required
                            autofocus
                        >

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
                            required
                        >

                    </div>

                    <button
                        type="submit"
                        class="login-btn"
                    >
                        Iniciar sesión
                    </button>

                </form>

                <div class="login-registro">

                    <span>
                        ¿Todavía no tienes una cuenta?
                    </span>

                    <a href="{{ route('registro') }}">
                        Crear cuenta
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