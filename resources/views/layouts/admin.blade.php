<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Ecopapel Admin')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('CSS/admin.css') }}">
</head>

<body>

<div class="panel-admin">

    <header class="admin-navbar">

        <a href="{{ route('admin') }}" class="admin-marca">

            <div class="admin-logo">
                <img
                    src="{{ asset('imagenes/logo2.png') }}"
                    alt="Logo Ecopapel"
                >
            </div>

            <div class="admin-marca-texto">
                <strong>Ecopapel</strong>
                <span>Administración</span>
            </div>

        </a>

        <nav class="admin-menu">

            <a
                href="{{ route('admin') }}"
                class="{{ request()->routeIs('admin') ? 'activo' : '' }}"
            >
                <span>▦</span>
                Panel
            </a>

            <a
                href="{{ route('admin.productos.ver') }}"
                class="{{ request()->routeIs('admin.productos*') ? 'activo' : '' }}"
            >
                <span>📦</span>
                Productos
            </a>

            <a
                href="{{ route('admin.categorias') }}"
                class="{{ request()->routeIs('admin.categorias*') ? 'activo' : '' }}"
            >
                <span>🗂️</span>
                Categorías
            </a>

            <a
                href="{{ route('admin.usuarios') }}"
                class="{{ request()->routeIs('admin.usuarios*') ? 'activo' : '' }}"
            >
                <span>👥</span>
                Usuarios
            </a>

            <a
                href="{{ route('admin.ventas') }}"
                class="{{ request()->routeIs('admin.ventas*') ? 'activo' : '' }}"
            >
                <span>🛒</span>
                Ventas
            </a>

            <a
                href="{{ route('admin.cortes') }}"
                class="{{ request()->routeIs('admin.cortes*') ? 'activo' : '' }}"
            >
                <span>📄</span>
                Cortes
            </a>

        </nav>

        <div class="admin-usuario">

            <div class="admin-avatar">
                {{ strtoupper(substr(session('usuario') ?? 'A', 0, 1)) }}
            </div>

            <div class="admin-usuario-info">
                <strong>{{ session('usuario') }}</strong>
                <span>Administrador</span>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button
                    type="submit"
                    class="admin-btn-salir"
                    title="Cerrar sesión"
                >
                    🚪
                </button>
            </form>

        </div>

    </header>

    @if(session('ok'))
        <div class="mensaje-admin mensaje-ok">
            {{ session('ok') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mensaje-admin mensaje-error">
            {{ session('error') }}
        </div>
    @endif

    <main class="admin-contenido">
        @yield('content')
    </main>

</div>

</body>
</html>