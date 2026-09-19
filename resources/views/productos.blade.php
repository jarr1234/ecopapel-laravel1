@extends('layouts.app')

@section('title', 'Productos | Ecopapel')

@section('content')

<h2 class="titulo">🛍 Productos Disponibles</h2>

<div class="menu">

    <a href="{{ route('productos') }}">
        Todas
    </a>

    @foreach($categorias as $categoria)

        <a href="{{ route('productos', ['categoria' => $categoria->id]) }}">
            {{ $categoria->nombre }}
        </a>

    @endforeach

</div>

<div class="productos">

    @forelse($productos as $producto)

        <div class="card">

            @if(!empty($producto->imagen))

                <img
                    src="{{ asset(ltrim(trim($producto->imagen), '/')) }}"
                    alt="{{ $producto->nombre }}"
                >

            @else

                <div class="sin-imagen">
                    📦
                    <p>Sin imagen</p>
                </div>

            @endif

            <h3>
                {{ $producto->nombre }}
            </h3>

            <p class="descripcion">
                {{ $producto->descripcion }}
            </p>

            <p>
                📂 {{ $producto->categoria ?? 'Sin categoría' }}
            </p>

            <p class="precio">
                💲{{ number_format($producto->precio, 2) }}
            </p>

            <p>
                📦 Stock: {{ $producto->stock }}
            </p>

            @if($producto->stock > 0)

                <form action="{{ route('carrito.agregar') }}" method="POST">

                    @csrf

                    <input
                        type="hidden"
                        name="id"
                        value="{{ $producto->id }}"
                    >

                    <input
                        type="number"
                        name="cantidad"
                        value="1"
                        min="1"
                        max="{{ $producto->stock }}"
                        class="input-cantidad"
                    >

                    <button type="submit" class="btn">
                        🛒 Agregar al carrito
                    </button>

                </form>

            @else

                <button type="button" class="btn" disabled>
                    ❌ Sin existencia
                </button>

            @endif

        </div>

    @empty

        <div class="sin-resultados">
            <h2>❌ No se encontraron productos</h2>
            <p>Prueba con otra categoría o búsqueda.</p>
        </div>

    @endforelse

</div>

@endsection