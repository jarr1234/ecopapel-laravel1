@extends('layouts.app')

@section('title', 'Ecopapel')

@section('content')

<section class="banner">

    <div class="banner-contenido">

        <h1>TODO PARA TU PAPELERÍA</h1>

        <p>
            Encuentra productos escolares, oficina y mucho más
        </p>

        <a href="{{ route('productos') }}" class="btn">
            Ver productos
        </a>

    </div>

</section>

<section class="categorias">

    <a href="{{ route('productos', ['categoria' => 1]) }}">
        📒 Cuadernos
    </a>

    <a href="{{ route('productos', ['categoria' => 2]) }}">
        ✂ Manualidades
    </a>

    <a href="{{ route('productos', ['categoria' => 3]) }}">
        ✏ Escritura
    </a>

    <a href="{{ route('productos', ['categoria' => 4]) }}">
        🖇 Oficina
    </a>

</section>

<h2 class="titulo">
    🔥 Productos destacados
</h2>

<section class="productos">

    <div class="card">

        <img
            src="{{ asset('imagenes/1776834195_imagen_2026-04-21_230309933.png') }}"
            alt="Lapiceros"
        >

        <h3>Lapiceros</h3>

        <p class="precio">
            $15.00
        </p>

        <a href="{{ route('productos') }}" class="boton-card">
            Comprar
        </a>

    </div>

    <div class="card">

        <img
            src="{{ asset('imagenes/1776834356_imagen_2026-04-21_230549334.png') }}"
            alt="Portaminas"
        >

        <h3>Portaminas</h3>

        <p class="precio">
            $20.00
        </p>

        <a href="{{ route('productos') }}" class="boton-card">
            Comprar
        </a>

    </div>

    <div class="card">

        <img
            src="{{ asset('imagenes/1777005375_imagen_2026-04-23_223434115.png') }}"
            alt="Diccionario Básico"
        >

        <h3>Diccionario Básico</h3>

        <p class="precio">
            $120.00
        </p>

        <a href="{{ route('productos') }}" class="boton-card">
            Comprar
        </a>

    </div>

    <div class="card">

        <img
            src="{{ asset('imagenes/1777005249_imagen_2026-04-23_223228661.png') }}"
            alt="Globos de colores"
        >

        <h3>Globos de colores</h3>

        <p class="precio">
            $65.00
        </p>

        <a href="{{ route('productos') }}" class="boton-card">
            Comprar
        </a>

    </div>

</section>

<footer class="footer">
    <p>
        © 2026 Ecopapel | Todos los derechos reservados
    </p>
</footer>

@endsection