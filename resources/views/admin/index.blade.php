@extends('layouts.admin')

@section('title', 'Panel Administrador | Ecopapel')

@section('content')

<section class="dashboard">

    <div class="dashboard-bienvenida">

        <div>
            <span class="dashboard-etiqueta">
                PANEL DE CONTROL
            </span>

            <h1>Hola, {{ session('usuario') }} 👋</h1>

            <p>
                Administra los productos, usuarios, ventas y cortes
                de Ecopapel desde un solo lugar.
            </p>
        </div>

        <div class="dashboard-estado">
            <span class="estado-punto"></span>
            Sistema activo
        </div>

    </div>

    <div class="dashboard-estadisticas">

        <a
            href="{{ route('admin.productos.ver') }}"
            class="estadistica-card"
        >

            <div class="estadistica-icono productos-icono">
                📦
            </div>

            <div class="estadistica-contenido">
                <span>Productos registrados</span>
                <strong>{{ $productos }}</strong>
                <small>Ver catálogo →</small>
            </div>

        </a>

        <a
            href="{{ route('admin.usuarios') }}"
            class="estadistica-card"
        >

            <div class="estadistica-icono usuarios-icono">
                👥
            </div>

            <div class="estadistica-contenido">
                <span>Usuarios registrados</span>
                <strong>{{ $usuarios }}</strong>
                <small>Administrar usuarios →</small>
            </div>

        </a>

        <a
            href="{{ route('admin.ventas') }}"
            class="estadistica-card"
        >

            <div class="estadistica-icono ventas-icono">
                🛒
            </div>

            <div class="estadistica-contenido">
                <span>Ventas registradas</span>
                <strong>{{ $ventas }}</strong>
                <small>Revisar ventas →</small>
            </div>

        </a>

    </div>

    <div class="dashboard-seccion">

        <div class="dashboard-seccion-titulo">
            <div>
                <span class="dashboard-etiqueta">
                    ADMINISTRACIÓN
                </span>

                <h2>Accesos rápidos</h2>

                <p>
                    Selecciona la sección que deseas administrar.
                </p>
            </div>
        </div>

        <div class="dashboard-opciones">

            <a
                href="{{ route('admin.productos') }}"
                class="opcion-admin"
            >

                <div class="opcion-icono">
                    ➕
                </div>

                <div class="opcion-contenido">
                    <h3>Agregar producto</h3>
                    <p>
                        Registra nuevos productos en el catálogo.
                    </p>
                </div>

                <span class="opcion-flecha">→</span>

            </a>

            <a
                href="{{ route('admin.productos.ver') }}"
                class="opcion-admin"
            >

                <div class="opcion-icono">
                    📦
                </div>

                <div class="opcion-contenido">
                    <h3>Productos</h3>
                    <p>
                        Consulta, modifica o elimina productos.
                    </p>
                </div>

                <span class="opcion-flecha">→</span>

            </a>

            <a
                href="{{ route('admin.categorias') }}"
                class="opcion-admin"
            >

                <div class="opcion-icono">
                    🗂️
                </div>

                <div class="opcion-contenido">
                    <h3>Categorías</h3>
                    <p>
                        Organiza las categorías de tus productos.
                    </p>
                </div>

                <span class="opcion-flecha">→</span>

            </a>

            <a
                href="{{ route('admin.usuarios') }}"
                class="opcion-admin"
            >

                <div class="opcion-icono">
                    👥
                </div>

                <div class="opcion-contenido">
                    <h3>Usuarios</h3>
                    <p>
                        Consulta y administra las cuentas registradas.
                    </p>
                </div>

                <span class="opcion-flecha">→</span>

            </a>

            <a
                href="{{ route('admin.ventas') }}"
                class="opcion-admin"
            >

                <div class="opcion-icono">
                    🛒
                </div>

                <div class="opcion-contenido">
                    <h3>Ventas</h3>
                    <p>
                        Revisa las ventas pendientes de corte.
                    </p>
                </div>

                <span class="opcion-flecha">→</span>

            </a>

            <a
                href="{{ route('admin.cortes') }}"
                class="opcion-admin"
            >

                <div class="opcion-icono">
                    📄
                </div>

                <div class="opcion-contenido">
                    <h3>Cortes</h3>
                    <p>
                        Consulta y genera los cortes de ventas.
                    </p>
                </div>

                <span class="opcion-flecha">→</span>

            </a>

        </div>

    </div>

    <div class="dashboard-sesion">

        <div>
            <strong>Sesión de administrador</strong>

            <p>
                Has iniciado sesión como {{ session('usuario') }}.
            </p>
        </div>

        <form
            action="{{ route('logout') }}"
            method="POST"
        >
            @csrf

            <button
                type="submit"
                class="btn-cerrar-dashboard"
            >
                🚪 Cerrar sesión
            </button>

        </form>

    </div>

</section>

@endsection