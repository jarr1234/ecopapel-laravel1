@extends('layouts.admin')

@section('title', 'Ver productos | Ecopapel Admin')

@section('content')

<div class="admin-header">

    <div>
        <h1>📦 Panel de Productos</h1>
        <p>Consulta y administra todos los productos de Ecopapel</p>
    </div>

    <div class="acciones-top">

        <a href="{{ route('admin') }}" class="btn-volver-admin">
            ⬅ Volver
        </a>

        <a href="{{ route('admin.productos') }}" class="btn-agregar-admin">
            ➕ Agregar producto
        </a>

    </div>

</div>

<div class="buscar-admin">

    <form action="{{ route('admin.productos.ver') }}" method="GET">

        <input
            type="text"
            name="buscar"
            value="{{ request('buscar') }}"
            placeholder="🔍 Buscar por nombre, descripción, categoría o precio..."
        >

        <button type="submit" class="btn-admin">
            🔍 Buscar
        </button>

        <a href="{{ route('admin.productos.ver') }}" class="btn-admin btn-rojo">
            Limpiar
        </a>

    </form>

</div>

<div class="productos-admin-grid">

    @forelse($productos as $producto)

        <div class="producto-admin-card">

            <div class="producto-admin-imagen">

                @if(!empty($producto->imagen))

                    <img
                        src="{{ asset(trim($producto->imagen)) }}"
                        alt="{{ $producto->nombre }}"
                        class="img-producto-admin"
                        loading="lazy"
                    >

                @else

                    <div class="sin-imagen">
                        <span>📦</span>
                        <p>Sin imagen</p>
                    </div>

                @endif

            </div>

            <div class="producto-admin-info">

                <h2>
                    {{ $producto->nombre }}
                </h2>

                <p class="producto-categoria">
                    📁 {{ $producto->categoria ?? 'Sin categoría' }}
                </p>

                <p class="producto-descripcion">
                    {{ $producto->descripcion ?: 'Sin descripción' }}
                </p>

                <div class="producto-datos">

                    <span class="producto-precio">
                        💲 ${{ number_format($producto->precio, 2) }}
                    </span>

                    @if($producto->stock > 0)

                        <span class="producto-stock">
                            📦 Stock: {{ $producto->stock }}
                        </span>

                    @else

                        <span class="producto-agotado">
                            ❌ Agotado
                        </span>

                    @endif

                </div>

                <div class="producto-admin-acciones">

                    <a
                        href="{{ route('admin.productos.editar', $producto->id) }}"
                        class="btn-editar-admin"
                    >
                        ✏ Editar
                    </a>

                    <form
                        action="{{ route('admin.productos.eliminar', $producto->id) }}"
                        method="POST"
                        onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn-eliminar-admin"
                        >
                            🗑 Eliminar
                        </button>

                    </form>

                </div>

            </div>

        </div>

    @empty

        <div class="sin-resultados">

            <h2>😕 No se encontraron productos</h2>

            <p>
                No hay productos que coincidan con la búsqueda.
            </p>

        </div>

    @endforelse

</div>

@endsection