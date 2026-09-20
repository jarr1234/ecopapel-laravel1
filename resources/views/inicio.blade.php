@extends('layouts.app')

@section('title', 'Ecopapel | Tu papelería en línea')

@section('content')

<section class="hero">

    <div class="hero-contenido">

        <div class="hero-texto">

            <span class="hero-etiqueta">
                ✏️ Todo para escuela y oficina
            </span>

            <h1>
                Todo lo que necesitas para crear, estudiar y trabajar
            </h1>

            <p>
                Encuentra productos de papelería, útiles escolares,
                materiales de oficina y mucho más en un solo lugar.
            </p>

            <div class="hero-acciones">

                <a href="{{ route('productos') }}" class="btn-principal">
                    Explorar productos
                </a>

                @if(!session('usuario'))
                    <a href="{{ route('registro') }}" class="btn-secundario">
                        Crear una cuenta
                    </a>
                @endif

            </div>

        </div>

        <div class="hero-visual">

            <div class="hero-iconos">
                <span>📚</span>
                <span>✏️</span>
                <span>📒</span>
                <span>🎨</span>
            </div>

            <div class="hero-mensaje">
                <strong>Encuentra tus favoritos</strong>
                <span>Escolar · Oficina · Creatividad</span>
            </div>

        </div>

    </div>

</section>

<section class="beneficios">

    <div class="beneficio">
        <span>🛍️</span>
        <div>
            <strong>Compra fácil</strong>
            <p>Encuentra rápidamente lo que necesitas.</p>
        </div>
    </div>

    <div class="beneficio">
        <span>📚</span>
        <div>
            <strong>Gran variedad</strong>
            <p>Productos para escuela, oficina y creatividad.</p>
        </div>
    </div>

    <div class="beneficio">
        <span>💚</span>
        <div>
            <strong>Atención cercana</strong>
            <p>Una experiencia de compra sencilla y confiable.</p>
        </div>
    </div>

</section>

<section class="seccion-categorias">

    <div class="encabezado-seccion">
        <span class="subtitulo-seccion">Encuentra lo que buscas</span>
        <h2>Explora por categoría</h2>
        <p>
            Elige una categoría y descubre nuestros productos.
        </p>
    </div>

    <div class="categorias">

        @php
            $categoriasInicio = [
                [
                    'nombre' => 'Cuadernos',
                    'icono' => '📒',
                    'descripcion' => 'Para clases y apuntes'
                ],
                [
                    'nombre' => 'Manualidades',
                    'icono' => '✂️',
                    'descripcion' => 'Crea algo increíble'
                ],
                [
                    'nombre' => 'Escritura',
                    'icono' => '✏️',
                    'descripcion' => 'Escribe tus ideas'
                ],
                [
                    'nombre' => 'Oficina',
                    'icono' => '📎',
                    'descripcion' => 'Organiza tu espacio'
                ]
            ];
        @endphp

        @foreach($categoriasInicio as $item)

            @php
                $categoriaEncontrada = $categorias->first(function ($categoria) use ($item) {
                    return strtolower(trim($categoria->nombre)) === strtolower(trim($item['nombre']));
                });
            @endphp

            @if($categoriaEncontrada)

                <a
                    href="{{ route('productos', ['categoria' => $categoriaEncontrada->id]) }}"
                    class="categoria-card"
                >
                    <span class="categoria-icono">
                        {{ $item['icono'] }}
                    </span>

                    <div>
                        <strong>{{ $item['nombre'] }}</strong>
                        <small>{{ $item['descripcion'] }}</small>
                    </div>

                    <span class="categoria-flecha">→</span>
                </a>

            @endif

        @endforeach

    </div>

</section>

<section class="seccion-destacados">

    <div class="encabezado-seccion encabezado-productos">

        <div>
            <span class="subtitulo-seccion">Nuestros favoritos</span>
            <h2>Productos destacados</h2>
            <p>
                Una selección de productos que pueden interesarte.
            </p>
        </div>

        <a href="{{ route('productos') }}" class="ver-todos">
            Ver todos los productos →
        </a>

    </div>

    <div class="productos-destacados">

        <article class="producto-card">

            <div class="producto-imagen">
                <img
                    src="{{ asset('imagenes/1776834195_imagen_2026-04-21_230309933.png') }}"
                    alt="Lapiceros"
                >
            </div>

            <div class="producto-info">
                <span class="producto-categoria">Escritura</span>
                <h3>Lapiceros</h3>
                <p class="precio">$15.00</p>

                <a href="{{ route('productos') }}" class="btn-producto">
                    Ver producto
                </a>
            </div>

        </article>

        <article class="producto-card">

            <div class="producto-imagen">
                <img
                    src="{{ asset('imagenes/1776834356_imagen_2026-04-21_230549334.png') }}"
                    alt="Portaminas"
                >
            </div>

            <div class="producto-info">
                <span class="producto-categoria">Escritura</span>
                <h3>Portaminas</h3>
                <p class="precio">$20.00</p>

                <a href="{{ route('productos') }}" class="btn-producto">
                    Ver producto
                </a>
            </div>

        </article>

        <article class="producto-card">

            <div class="producto-imagen">
                <img
                    src="{{ asset('imagenes/1777005375_imagen_2026-04-23_223434115.png') }}"
                    alt="Diccionario Básico"
                >
            </div>

            <div class="producto-info">
                <span class="producto-categoria">Escolar</span>
                <h3>Diccionario Básico</h3>
                <p class="precio">$120.00</p>

                <a href="{{ route('productos') }}" class="btn-producto">
                    Ver producto
                </a>
            </div>

        </article>

        <article class="producto-card">

            <div class="producto-imagen">
                <img
                    src="{{ asset('imagenes/1777005249_imagen_2026-04-23_223228661.png') }}"
                    alt="Globos de colores"
                >
            </div>

            <div class="producto-info">
                <span class="producto-categoria">Manualidades</span>
                <h3>Globos de colores</h3>
                <p class="precio">$65.00</p>

                <a href="{{ route('productos') }}" class="btn-producto">
                    Ver producto
                </a>
            </div>

        </article>

    </div>

</section>

<section class="cta-final">

    <div>
        <span>ECOPAPEL</span>
        <h2>¿Listo para encontrar lo que necesitas?</h2>
        <p>
            Explora nuestro catálogo y descubre todos nuestros productos.
        </p>
    </div>

    <a href="{{ route('productos') }}" class="btn-cta">
        Ver catálogo
    </a>

</section>

<footer class="footer">

    <div class="footer-contenido">

        <div class="footer-marca">
            <strong>Ecopapel</strong>
            <p>
                Papelería para estudiar, trabajar y crear.
            </p>
        </div>

        <div class="footer-enlaces">
            <a href="{{ route('inicio') }}">Inicio</a>
            <a href="{{ route('productos') }}">Productos</a>

            @if(session('usuario'))
                <a href="{{ route('carrito') }}">Carrito</a>
            @else
                <a href="{{ route('login') }}">Mi cuenta</a>
            @endif
        </div>

    </div>

    <div class="footer-inferior">
        <p>© 2026 Ecopapel. Todos los derechos reservados.</p>
    </div>

</footer>

@endsection