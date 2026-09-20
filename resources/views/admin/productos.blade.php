@extends('layouts.admin')

@section('title', 'Productos | Ecopapel Admin')

@section('content')

<section class="admin-page">

    <div class="admin-page-header">

        <div class="admin-page-heading">
            <span class="admin-page-label">CATÁLOGO</span>
            <h1>📦 Productos</h1>
            <p>Agrega nuevos productos y administra el inventario de Ecopapel.</p>
        </div>

        <div class="admin-page-actions">
            <a href="{{ route('admin.productos.ver') }}" class="admin-action-link">
                👁️ Ver catálogo
            </a>
        </div>

    </div>

    <div class="admin-form-card">

        <div class="admin-section-heading">

            <div class="admin-section-icon">
                ➕
            </div>

            <div>
                <h2>Agregar producto</h2>
                <p>Completa la información para registrar un nuevo producto.</p>
            </div>

        </div>

        <form
            action="{{ route('admin.productos.guardar') }}"
            method="POST"
            enctype="multipart/form-data"
            class="admin-product-form"
        >

            @csrf

            <div class="form-group">
                <label for="nombre">Nombre del producto</label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="{{ old('nombre') }}"
                    placeholder="Ej. Libreta ecológica"
                    required
                >

                @error('nombre')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="categoria_id">Categoría</label>

                <select
                    id="categoria_id"
                    name="categoria_id"
                    required
                >
                    <option value="">Selecciona una categoría</option>

                    @foreach($categorias as $categoria)
                        <option
                            value="{{ $categoria->id }}"
                            @selected(old('categoria_id') == $categoria->id)
                        >
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>

                @error('categoria_id')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="precio">Precio</label>

                <div class="admin-input-prefix">
                    <span>$</span>

                    <input
                        type="number"
                        id="precio"
                        name="precio"
                        value="{{ old('precio') }}"
                        step="0.01"
                        min="0"
                        placeholder="0.00"
                        required
                    >
                </div>

                @error('precio')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="stock">Stock disponible</label>

                <input
                    type="number"
                    id="stock"
                    name="stock"
                    value="{{ old('stock') }}"
                    min="0"
                    placeholder="Cantidad disponible"
                    required
                >

                @error('stock')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group form-group-full">
                <label for="descripcion">Descripción</label>

                <textarea
                    id="descripcion"
                    name="descripcion"
                    rows="4"
                    placeholder="Describe brevemente el producto"
                >{{ old('descripcion') }}</textarea>

                @error('descripcion')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group form-group-full">

                <label for="imagen">Imagen del producto</label>

                <div class="admin-file-field">
                    <div class="admin-file-icon">🖼️</div>

                    <div class="admin-file-info">
                        <strong>Selecciona una imagen</strong>
                        <span>JPG, PNG, WEBP u otro formato de imagen compatible.</span>
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

                <button type="submit" class="admin-primary-button">
                    ➕ Guardar producto
                </button>

                <a href="{{ route('admin.productos.ver') }}" class="admin-secondary-button">
                    Ver productos
                </a>

            </div>

        </form>

    </div>

    <div class="admin-list-card">

        <div class="admin-section-heading admin-section-heading-between">

            <div class="admin-section-title-group">

                <div class="admin-section-icon">
                    📋
                </div>

                <div>
                    <h2>Productos registrados</h2>
                    <p>Vista rápida de los productos disponibles en el sistema.</p>
                </div>

            </div>

            <span class="admin-count-badge">
                {{ $productos->count() }} productos
            </span>

        </div>

        <div class="tabla-responsive">

            <table class="admin-modern-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Categoría</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($productos as $producto)

                        <tr>

                            <td>
                                <span class="admin-id">
                                    #{{ $producto->id }}
                                </span>
                            </td>

                            <td>
                                <strong class="admin-product-name">
                                    {{ $producto->nombre }}
                                </strong>
                            </td>

                            <td>
                                <span class="admin-price">
                                    ${{ number_format($producto->precio, 2) }}
                                </span>
                            </td>

                            <td>
                                @if($producto->stock > 0)
                                    <span class="admin-stock admin-stock-ok">
                                        {{ $producto->stock }} disponibles
                                    </span>
                                @else
                                    <span class="admin-stock admin-stock-empty">
                                        Agotado
                                    </span>
                                @endif
                            </td>

                            <td>
                                <span class="admin-category-badge">
                                    {{ $producto->categoria ?? 'Sin categoría' }}
                                </span>
                            </td>

                            <td>

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

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6">

                                <div class="admin-empty-state">
                                    <span>📦</span>
                                    <strong>No hay productos registrados</strong>
                                    <p>Agrega tu primer producto utilizando el formulario superior.</p>
                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</section>

@endsection