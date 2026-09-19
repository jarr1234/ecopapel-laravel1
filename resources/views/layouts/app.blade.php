<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Ecopapel')</title>

    <link rel="stylesheet" href="{{ asset('CSS/estilos.css') }}">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >
</head>

<body>

<header class="header">

    <div class="logo">
        <a href="{{ route('inicio') }}">
            <img src="{{ asset('imagenes/logo2.png') }}" alt="Ecopapel">
        </a>

        <span>Ecopapel</span>
    </div>

    <form
        action="{{ route('productos') }}"
        method="GET"
        class="form-busqueda"
    >
        @if(session('usuario'))

            <input
                type="text"
                name="buscar"
                placeholder="Buscar productos..."
                class="buscador"
                value="{{ request('buscar') }}"
            >

            <button type="submit" class="btn-buscar">
                🔍
            </button>

        @else

            <a href="{{ route('login') }}" class="btn-login">
                🔒 Inicia sesión para buscar
            </a>

        @endif
    </form>

    <nav class="acciones">

        @if(session('usuario'))

            @if(session('rol') === 'admin')

                <a href="{{ route('admin') }}">
                    ⚙️ Panel
                </a>

                <a href="{{ route('admin.productos') }}">
                    📦 Productos
                </a>

                <a href="{{ route('admin.usuarios') }}">
                    👥 Usuarios
                </a>

                <span>
                    👑 {{ session('usuario') }}
                </span>

            @else

                <a href="{{ route('inicio') }}">
                    🏠 Inicio
                </a>

                <a href="{{ route('productos') }}">
                    📦 Productos
                </a>

                <a href="{{ route('carrito') }}">
                    🛒 Carrito
                </a>

                <span>
                    👤 {{ session('usuario') }}
                </span>

            @endif

            <form
                method="POST"
                action="{{ route('logout') }}"
                class="form-logout"
            >
                @csrf

                <button type="submit" class="cerrar">
                    🚪 Cerrar sesión
                </button>
            </form>

        @else

            <a href="{{ route('inicio') }}">
                🏠 Inicio
            </a>

            <a href="{{ route('productos') }}">
                📦 Productos
            </a>

            <a href="{{ route('login') }}">
                👤 Cuenta
            </a>

        @endif

    </nav>

</header>

@if(session('error'))
    <div class="mensaje mensaje-error">
        {{ session('error') }}
    </div>
@endif

@if(session('ok'))
    <div class="mensaje mensaje-ok">
        {{ session('ok') }}
    </div>
@endif

<main>
    @yield('content')
</main>

</body>
</html>