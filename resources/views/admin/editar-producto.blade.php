@extends('layouts.admin')

@section('title', 'Editar producto | Ecopapel Admin')

@section('content')

<section class="admin-page">

    <div class="admin-page-header">

        <div class="admin-page-heading">
            <span class="admin-page-label">CATÁLOGO</span>
            <h1>✏️ Editar producto</h1>
            <p>Actualiza la información, precio, inventario e imagen del producto.</p>
        </div>

        <div class="admin-page-actions">

            <a
                href="{{ route('admin.productos.ver') }}"
                class="admin-secondary-button"
            >
                ← Volver al catálogo
            </a>

        </div>

    </div>

    <div class="admin-edit-layout">

        <aside class="admin-product-preview">

            <div class="admin-section-heading">

                <div class="admin-section-icon">
                    🖼️
                </div>

                <div>
                    <h2>Imagen actual</h2>
                    <p>Vista previa del producto.</p>
                </div>

            </div>

            <div class="admin-edit-image">

                @if(!empty($producto->imagen))

                    <img
                        src="{{ asset(trim($producto->imagen)) }}"
                        alt="{{ $producto->nombre }}"
                    >

                @else

                    <div class="admin-no-image">
                        <span>📦</span>
                        <p>Sin imagen</p>
                    </div>

                @endif

            </div>

            <div class="admin-preview-info">

                <span class="admin-product-id">
                    #{{ $producto->id }}
                </span>

                <h3>{{ $producto->nombre }}</h3>

                <div class="admin-preview-data">

                    <div>
                        <span>Precio actual</span>

                        <strong>
                            ${{ number_format($producto->precio, 2) }}
                        </strong>
                    </div>

                    <div>
                        <span>Stock actual</span>

                        <strong>
                            {{ $producto->stock }}
                        </strong>
                    </div>

                </div>

            </div>

        </aside>

        <div class="admin-form-card admin-edit-form-card">

            <div class="admin-section-heading">

                <div class="admin-section-icon">
                    ✏️
                </div>

                <div>
                    <h2>Información del producto</h2>
                    <p>Modifica únicamente los datos que necesites actualizar.</p>
                </div>

            </div>

            @if($errors->any())

                <div class="admin-validation-errors">

                    <strong>Revisa los siguientes datos:</strong>

                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

            @endif

            <form
                action="{{ route('admin.productos.actualizar', $producto->id) }}"
                method="POST"
                enctype="multipart/form-data"
                class="admin-product-form"
            >

                @csrf
                @method('PUT')

                <div class="form-group form-group-full">

                    <label for="nombre">
                        Nombre del producto
                    </label>

                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        value="{{ old('nombre', $producto->nombre) }}"
                        placeholder="Nombre del producto"
                        required
                    >

                    @error('nombre')
                        <span class="form-error">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group">

                    <label for="precio">
                        Precio
                    </label>

                    <div class="admin-input-prefix">

                        <span>$</span>

                        <input
                            type="number"
                            id="precio"
                            name="precio"
                            step="0.01"
                            min="0"
                            value="{{ old('precio', $producto->precio) }}"
                            placeholder="0.00"
                            required
                        >

                    </div>

                    @error('precio')
                        <span class="form-error">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group">

                    <label for="stock">
                        Stock disponible
                    </label>

                    <input
                        type="number"
                        id="stock"
                        name="stock"
                        min="0"
                        value="{{ old('stock', $producto->stock) }}"
                        placeholder="Cantidad disponible"
                        required
                    >

                    @error('stock')
                        <span class="form-error">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group form-group-full">

                    <label for="categoria_id">
                        Categoría
                    </label>

                    <select
                        id="categoria_id"
                        name="categoria_id"
                        required
                    >

                        @foreach($categorias as $categoria)

                            <option
                                value="{{ $categoria->id }}"
                                @selected(
                                    (string) old(
                                        'categoria_id',
                                        $producto->categoria_id
                                    ) === (string) $categoria->id
                                )
                            >
                                {{ $categoria->nombre }}
                            </option>

                        @endforeach

                    </select>

                    @error('categoria_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group form-group-full">

                    <label for="descripcion">
                        Descripción
                    </label>

                    <textarea
                        id="descripcion"
                        name="descripcion"
                        rows="5"
                        placeholder="Descripción del producto"
                    >{{ old('descripcion', $producto->descripcion) }}</textarea>

                    @error('descripcion')
                        <span class="form-error">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group form-group-full">

                    <label for="imagen">
                        Cambiar imagen
                    </label>

                    <div class="admin-file-field">

                        <div class="admin-file-icon">
                            🖼️
                        </div>

                        <div class="admin-file-info">
                            <strong>Seleccionar nueva imagen</strong>
                            <span>
                                Si no seleccionas otra imagen,
                                se conservará la imagen actual.
                            </span>
                        </div>

                        <input
                            type="file"
                            id="imagen"
                            name="imagen"
                            accept="image/*"
                        >

                    </div>

                    @error('imagen')
                        <span class="form-error">{{ $message }}</span>
                    @enderror

                </div>

                <div class="admin-form-actions">

                    <button
                        type="submit"
                        class="admin-primary-button"
                    >
                        💾 Guardar cambios
                    </button>

                    <a
                        href="{{ route('admin.productos.ver') }}"
                        class="admin-secondary-button"
                    >
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </div>

</section>

@endsection