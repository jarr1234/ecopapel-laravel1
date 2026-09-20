@extends('layouts.app')

@section('title', 'Productos | Ecopapel')

@section('content')

<section class="catalogo">

    <div class="catalogo-encabezado">

        <span class="catalogo-etiqueta">
            Catálogo Ecopapel
        </span>

        <h1>Productos</h1>

        <p>
            Encuentra artículos escolares, de oficina y materiales
            para tus proyectos.
        </p>

    </div>

    <div class="filtros-categorias">

        <a
            href="{{ route('productos') }}"
            class="filtro-categoria {{ !request('categoria') ? 'activo' : '' }}"
        >
            Todos
        </a>

        @foreach($categorias as $categoria)

            <a
                href="{{ route('productos', ['categoria' => $categoria->id]) }}"
                class="filtro-categoria {{ request('categoria') == $categoria->id ? 'activo' : '' }}"
            >
                {{ $categoria->nombre }}
            </a>

        @endforeach

    </div>

    @if(request('buscar'))

        <div class="resultado-busqueda">

            <span>
                Resultados para:
                <strong>{{ request('buscar') }}</strong>
            </span>

            <a href="{{ route('productos') }}">
                Limpiar búsqueda
            </a>

        </div>

    @endif

    <div class="catalogo-productos">

        @forelse($productos as $producto)

            <article class="catalogo-card">

                <div class="catalogo-imagen">

                    @if(!empty($producto->imagen))

                        <img
                            src="{{ asset(ltrim(trim($producto->imagen), '/')) }}"
                            alt="{{ $producto->nombre }}"
                        >

                    @else

                        <div class="sin-imagen">
                            <span>📦</span>
                            <p>Sin imagen</p>
                        </div>

                    @endif

                    @if($producto->stock <= 0)

                        <span class="producto-agotado">
                            Agotado
                        </span>

                    @elseif($producto->stock <= 5)

                        <span class="producto-pocas-unidades">
                            Últimas unidades
                        </span>

                    @endif

                </div>

                <div class="catalogo-info">

                    <span class="catalogo-categoria">
                        {{ $producto->categoria ?? 'Sin categoría' }}
                    </span>

                    <h2>
                        {{ $producto->nombre }}
                    </h2>

                    <p class="catalogo-descripcion">
                        {{ $producto->descripcion }}
                    </p>

                    <div class="catalogo-datos">

                        <span class="catalogo-precio">
                            ${{ number_format($producto->precio, 2) }}
                        </span>

                        @if($producto->stock > 0)

                            <span class="catalogo-stock">
                                {{ $producto->stock }} disponibles
                            </span>

                        @else

                            <span class="catalogo-stock agotado">
                                Sin existencia
                            </span>

                        @endif

                    </div>

                    @if($producto->stock > 0)

                        @if(session('usuario'))

                            <form
                                action="{{ route('carrito.agregar') }}"
                                method="POST"
                                class="form-agregar-carrito"
                            >

                                @csrf

                                <input
                                    type="hidden"
                                    name="id"
                                    value="{{ $producto->id }}"
                                >

                                <div class="compra-producto">

                                    <div class="cantidad-producto">

                                        <label for="cantidad-{{ $producto->id }}">
                                            Cantidad
                                        </label>

                                        <input
                                            id="cantidad-{{ $producto->id }}"
                                            type="number"
                                            name="cantidad"
                                            value="1"
                                            min="1"
                                            max="{{ $producto->stock }}"
                                            class="input-cantidad"
                                        >

                                    </div>

                                    <button
                                        type="submit"
                                        class="btn-agregar-carrito"
                                    >
                                        🛒 Agregar
                                    </button>

                                </div>

                            </form>

                        @else

                            <a
                                href="{{ route('login') }}"
                                class="btn-agregar-carrito btn-login-compra"
                            >
                                🛒 Inicia sesión para comprar
                            </a>

                        @endif

                    @else

                        <button
                            type="button"
                            class="btn-agotado"
                            disabled
                        >
                            Sin existencia
                        </button>

                    @endif

                </div>

            </article>

        @empty

            <div class="sin-resultados">

                <span>🔎</span>

                <h2>No encontramos productos</h2>

                <p>
                    Prueba con otra búsqueda o selecciona otra categoría.
                </p>

                <a href="{{ route('productos') }}">
                    Ver todos los productos
                </a>

            </div>

        @endforelse

    </div>

</section>

@endsection