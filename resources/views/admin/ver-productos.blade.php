@extends('layouts.admin')

@section('title', 'Ver productos | Ecopapel Admin')

@section('content')

<section class="admin-page">

    <div class="admin-page-header">

        <div class="admin-page-heading">
            <span class="admin-page-label">CATÁLOGO</span>
            <h1>📦 Catálogo de productos</h1>
            <p>Consulta, busca, edita y administra los productos de Ecopapel.</p>
        </div>

        <div class="admin-page-actions">

            <a href="{{ route('admin') }}" class="admin-secondary-button">
                ← Panel
            </a>

            <a href="{{ route('admin.productos') }}" class="admin-primary-button">
                ➕ Agregar producto
            </a>

        </div>

    </div>

    <div class="admin-search-card">

        <form
            action="{{ route('admin.productos.ver') }}"
            method="GET"
            class="admin-search-form"
        >

            <div class="admin-search-input">

                <span>🔍</span>

                <input
                    type="text"
                    name="buscar"
                    value="{{ request('buscar') }}"
                    placeholder="Buscar por nombre, descripción, categoría o precio..."
                >

            </div>

            <button type="submit" class="admin-search-button">
                Buscar
            </button>

            @if(request('buscar'))
                <a
                    href="{{ route('admin.productos.ver') }}"
                    class="admin-clear-button"
                >
                    ✕ Limpiar
                </a>
            @endif

        </form>

        @if(request('buscar'))

            <div class="admin-search-result">

                <span>
                    Resultados para:
                    <strong>{{ request('buscar') }}</strong>
                </span>

                <span class="admin-count-badge">
                    {{ $productos->count() }}
                    {{ $productos->count() === 1 ? 'producto' : 'productos' }}
                </span>

            </div>

        @endif

    </div>

    <div class="admin-catalog-header">

        <div>
            <h2>Productos registrados</h2>
            <p>Administra la información, precio y disponibilidad del catálogo.</p>
        </div>

        <span class="admin-count-badge">
            {{ $productos->count() }}
            {{ $productos->count() === 1 ? 'producto' : 'productos' }}
        </span>

    </div>

    <div class="admin-products-grid">

        @forelse($productos as $producto)

            <article class="admin-product-card">

                <div class="admin-product-image">

                    @if(!empty($producto->imagen))

                        <img
                            src="{{ asset(trim($producto->imagen)) }}"
                            alt="{{ $producto->nombre }}"
                            loading="lazy"
                        >

                    @else

                        <div class="admin-no-image">
                            <span>📦</span>
                            <p>Sin imagen</p>
                        </div>

                    @endif

                    <span class="admin-product-id">
                        #{{ $producto->id }}
                    </span>

                    @if($producto->stock > 0)

                        <span class="admin-product-status admin-product-available">
                            Disponible
                        </span>

                    @else

                        <span class="admin-product-status admin-product-soldout">
                            Agotado
                        </span>

                    @endif

                </div>

                <div class="admin-product-content">

                    <div class="admin-product-category">
                        {{ $producto->categoria ?? 'Sin categoría' }}
                    </div>

                    <h2>{{ $producto->nombre }}</h2>

                    <p class="admin-product-description">
                        {{ $producto->descripcion ?: 'Este producto no tiene descripción.' }}
                    </p>

                    <div class="admin-product-details">

                        <div>
                            <span>Precio</span>

                            <strong class="admin-product-price">
                                ${{ number_format($producto->precio, 2) }}
                            </strong>
                        </div>

                        <div>
                            <span>Inventario</span>

                            @if($producto->stock > 0)

                                <strong class="admin-product-stock">
                                    {{ $producto->stock }} unidades
                                </strong>

                            @else

                                <strong class="admin-product-stock-empty">
                                    Sin existencias
                                </strong>

                            @endif
                        </div>

                    </div>

                    <div class="admin-product-actions">

                        <a
                            href="{{ route('admin.productos.editar', $producto->id) }}"
                            class="admin-edit-button"
                        >
                            ✏️ Editar
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
                                class="admin-delete-button"
                            >
                                🗑️ Eliminar
                            </button>

                        </form>

                    </div>

                </div>

            </article>

        @empty

            <div class="admin-empty-state admin-empty-products">

                <span>🔎</span>

                <strong>
                    @if(request('buscar'))
                        No encontramos productos
                    @else
                        No hay productos registrados
                    @endif
                </strong>

                <p>
                    @if(request('buscar'))
                        No hay resultados que coincidan con “{{ request('buscar') }}”.
                    @else
                        Cuando agregues productos aparecerán en esta sección.
                    @endif
                </p>

                @if(request('buscar'))

                    <a
                        href="{{ route('admin.productos.ver') }}"
                        class="admin-secondary-button"
                    >
                        Mostrar todos
                    </a>

                @else

                    <a
                        href="{{ route('admin.productos') }}"
                        class="admin-primary-button"
                    >
                        ➕ Agregar producto
                    </a>

                @endif

            </div>

        @endforelse

    </div>

</section>

@endsection