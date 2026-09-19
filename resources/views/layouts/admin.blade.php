<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Ecopapel Admin')</title>

    <link rel="stylesheet" href="{{ asset('CSS/admin.css') }}">
</head>

<body>

<div class="panel-admin">

    <div class="top-form-admin">

        <h1>📦 Ecopapel Admin</h1>

        <nav>
            <a href="{{ route('admin') }}">Panel</a>
            <a href="{{ route('admin.productos') }}">Productos</a>
            <a href="{{ route('admin.categorias') }}">Categorías</a>
            <a href="{{ route('admin.usuarios') }}">Usuarios</a>
            <a href="{{ route('admin.ventas') }}">Ventas</a>

            <form action="{{ route('logout') }}" method="POST" class="form-salir-admin">
                @csrf
                <button type="submit" class="btn-salir-admin">
                    🚪 Salir
                </button>
            </form>
        </nav>

    </div>

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

    <main>
        @yield('content')
    </main>

</div>

</body>
</html>