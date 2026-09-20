@extends('layouts.app')

@section('title', 'Mi carrito | Ecopapel')

@section('content')

<section class="pagina-carrito">

    <div class="carrito-encabezado">
        <span class="carrito-etiqueta">Tu compra</span>
        <h1>Mi carrito</h1>
        <p>Revisa los productos que agregaste antes de continuar con tu compra.</p>
    </div>

    @if($items->isNotEmpty())

        <div class="carrito-layout">

            <div class="carrito-lista">

                @foreach($items as $item)

                    <article class="carrito-producto">

                        <div class="carrito-imagen">

                            @if(!empty($item->imagen))

                                <img
                                    src="{{ asset(ltrim(trim($item->imagen), '/')) }}"
                                    alt="{{ $item->nombre }}"
                                >

                            @else

                                <div class="carrito-sin-imagen">
                                    📦
                                </div>

                            @endif

                        </div>

                        <div class="carrito-info">

                            <h2>{{ $item->nombre }}</h2>

                            <div class="carrito-detalles">

                                <p>
                                    Precio
                                    <strong>
                                        ${{ number_format($item->precio, 2) }}
                                    </strong>
                                </p>

                                <p>
                                    Cantidad
                                    <strong>
                                        {{ $item->cantidad }}
                                    </strong>
                                </p>

                            </div>

                            <div class="carrito-subtotal">
                                <span>Subtotal</span>

                                <strong>
                                    ${{ number_format($item->subtotal, 2) }}
                                </strong>
                            </div>

                        </div>

                        <form
                            method="POST"
                            action="{{ route('carrito.eliminar', $item->id) }}"
                            class="form-eliminar-producto"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn-eliminar"
                                title="Eliminar producto"
                                aria-label="Eliminar {{ $item->nombre }}"
                            >
                                ✕
                            </button>

                        </form>

                    </article>

                @endforeach

            </div>

            <aside class="resumen-compra">

                <span class="resumen-etiqueta">
                    Resumen
                </span>

                <h2>Resumen de compra</h2>

                <div class="resumen-linea">
                    <span>Productos</span>
                    <strong>{{ $items->sum('cantidad') }}</strong>
                </div>

                <div class="resumen-total">
                    <span>Total</span>

                    <strong>
                        ${{ number_format($total, 2) }}
                    </strong>
                </div>

                <a
                    href="{{ route('comprar') }}"
                    class="btn-finalizar-compra"
                >
                    Continuar con la compra
                </a>

                <a
                    href="{{ route('productos') }}"
                    class="seguir-comprando"
                >
                    ← Seguir comprando
                </a>

                <form
                    method="POST"
                    action="{{ route('carrito.vaciar') }}"
                    class="form-vaciar-carrito"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn-vaciar"
                    >
                        🗑 Vaciar carrito
                    </button>

                </form>

            </aside>

        </div>

    @else

        <div class="carrito-vacio">

            <div class="carrito-vacio-icono">
                🛒
            </div>

            <h2>Tu carrito está vacío</h2>

            <p>
                Todavía no has agregado productos.
                Explora nuestro catálogo y encuentra lo que necesitas.
            </p>

            <a
                href="{{ route('productos') }}"
                class="btn-ver-productos"
            >
                Explorar productos
            </a>

        </div>

    @endif

</section>

@endsection