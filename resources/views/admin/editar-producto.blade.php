@extends('layouts.admin')

@section('title', 'Editar producto | Ecopapel Admin')

@section('content')

<div class="admin-header">
    <div>
        <h1>✏️ Editar producto</h1>
        <p>Modifica la información del producto</p>
    </div>

    <div class="acciones-top">
        <a href="{{ route('admin.productos.ver') }}" class="btn-volver-admin">
            ⬅ Volver
        </a>
    </div>
</div>

<div class="editar-producto-container">

    <div class="editar-producto-imagen">

        <h3>Imagen actual</h3>

        @if(!empty($producto->imagen))

            <img
                src="{{ asset(trim($producto->imagen)) }}"
                alt="{{ $producto->nombre }}"
                class="imagen-editar-preview"
            >

        @else

            <div class="sin-imagen">
                <span>📦</span>
                <p>Sin imagen</p>
            </div>

        @endif

    </div>

    <div class="editar-producto-formulario">

        <form
            action="{{ route('admin.productos.actualizar', $producto->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre del producto</label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="{{ old('nombre', $producto->nombre) }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>

                <textarea
                    id="descripcion"
                    name="descripcion"
                    rows="4"
                >{{ old('descripcion', $producto->descripcion) }}</textarea>
            </div>

            <div class="form-fila">

                <div class="form-group">
                    <label for="precio">Precio</label>

                    <input
                        type="number"
                        id="precio"
                        name="precio"
                        step="0.01"
                        min="0"
                        value="{{ old('precio', $producto->precio) }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="stock">Stock</label>

                    <input
                        type="number"
                        id="stock"
                        name="stock"
                        min="0"
                        value="{{ old('stock', $producto->stock) }}"
                        required
                    >
                </div>

            </div>

            <div class="form-group">
                <label for="categoria_id">Categoría</label>

                <select
                    id="categoria_id"
                    name="categoria_id"
                    required
                >

                    @foreach($categorias as $categoria)

                        <option
                            value="{{ $categoria->id }}"
                            {{ (string) old('categoria_id', $producto->categoria_id) === (string) $categoria->id ? 'selected' : '' }}
                        >
                            {{ $categoria->nombre }}
                        </option>

                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label for="imagen">Cambiar imagen</label>

                <input
                    type="file"
                    id="imagen"
                    name="imagen"
                    accept="image/*"
                >

                <small>
                    Si no seleccionas otra imagen, se conservará la actual.
                </small>
            </div>

            @if($errors->any())

                <div class="mensaje mensaje-error">

                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach

                </div>

            @endif

            <div class="acciones-editar">

                <button type="submit" class="btn-guardar-editar">
                    💾 Guardar cambios
                </button>

                <a
                    href="{{ route('admin.productos.ver') }}"
                    class="btn-cancelar-editar"
                >
                    ❌ Cancelar
                </a>

            </div>

        </form>

    </div>

</div>

@endsection