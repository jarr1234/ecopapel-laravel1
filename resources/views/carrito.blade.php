@extends('layouts.app')

@section('title', 'Mi carrito | Ecopapel')

@section('content')

<div class="carrito-container">

    <h2>🛒 Mi carrito</h2>

    @forelse($items as $item)

        <div class="carrito-item">

            <div class="carrito-imagen">
                <img
                    src="{{ asset($item->imagen) }}"
                    alt="{{ $item->nombre }}"
                    class="carrito-img"
                >
            </div>

            <div class="carrito-info">

                <h3>{{ $item->nombre }}</h3>

                <p>
                    💵 Precio:
                    ${{ number_format($item->precio, 2) }}
                </p>

                <p>
                    📦 Cantidad:
                    {{ $item->cantidad }}
                </p>

                <p>
                    💰 Subtotal:
                    ${{ number_format($item->subtotal, 2) }}
                </p>

            </div>

            <form
                method="POST"
                action="{{ route('carrito.eliminar', $item->id) }}"
            >
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="btn-eliminar"
                    title="Eliminar producto"
                >
                    ✖
                </button>
            </form>

        </div>

    @empty

        <div class="carrito-vacio">
            <p>😢 Tu carrito está vacío</p>

            <a href="{{ route('productos') }}" class="btn-comprar">
                Ver productos
            </a>
        </div>

    @endforelse

    @if($items->isNotEmpty())

        <div class="total">
            💰 Total: ${{ number_format($total, 2) }}
        </div>

        <div class="carrito-acciones">

            <a href="{{ route('comprar') }}" class="btn-comprar">
                💳 Comprar
            </a>

            <form
                method="POST"
                action="{{ route('carrito.vaciar') }}"
            >
                @csrf
                @method('DELETE')

                <button type="submit" class="btn-vaciar">
                    🗑 Vaciar carrito
                </button>
            </form>

        </div>

    @endif

</div>

@endsection