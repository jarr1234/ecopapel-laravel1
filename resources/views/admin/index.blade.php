@extends('layouts.admin')

@section('title', 'Panel Administrador | Ecopapel')

@section('content')

<div class="admin-header">
    <h1>Panel Administrador</h1>

    <p>
        Bienvenido: <strong>{{ session('usuario') }}</strong>
    </p>
</div>

<div class="cards">

    <div class="card">
        <h2>{{ $productos }}</h2>
        <p>Productos</p>
    </div>

    <div class="card">
        <h2>{{ $usuarios }}</h2>
        <p>Usuarios</p>
    </div>

    <div class="card">
        <h2>{{ $ventas }}</h2>
        <p>Ventas</p>
    </div>

</div>

<div class="admin-acciones">

    <a href="{{ route('admin.productos') }}" class="btn-admin">
        ➕ Agregar producto
    </a>

    <a href="{{ route('admin.productos.ver') }}" class="btn-admin">
        📦 Ver productos
    </a>

    <a href="{{ route('admin.categorias') }}" class="btn-admin btn-verde">
        📁 Categorías
    </a>

    <a href="{{ route('admin.usuarios') }}" class="btn-admin btn-naranja">
        👥 Usuarios
    </a>

    <a href="{{ route('admin.ventas') }}" class="btn-admin btn-verde">
        🛒 Ventas
    </a>

    <a href="{{ route('admin.cortes') }}" class="btn-admin">
        📄 Cortes
    </a>

    <form action="{{ route('logout') }}" method="POST">
        @csrf

        <button type="submit" class="btn-admin btn-rojo">
            🚪 Cerrar sesión
        </button>
    </form>

</div>

@endsection