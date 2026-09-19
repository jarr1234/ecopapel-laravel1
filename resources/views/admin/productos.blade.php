@extends('layouts.admin')

@section('title', 'Productos | Ecopapel Admin')

@section('content')

<div class="admin-header">
    <h1>📦 Productos</h1>
    <p>Administra los productos de Ecopapel</p>
</div>

<div class="admin-formulario">

    <h2>➕ Agregar producto</h2>

    <form
        action="{{ route('admin.productos.guardar') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        <div class="form-group">
            <label for="nombre">Nombre</label>

            <input
                type="text"
                id="nombre"
                name="nombre"
                value="{{ old('nombre') }}"
                placeholder="Nombre del producto"
                required
            >
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>

            <input
                type="text"
                id="descripcion"
                name="descripcion"
                value="{{ old('descripcion') }}"
                placeholder="Descripción del producto"
            >
        </div>

        <div class="form-group">
            <label for="precio">Precio</label>

            <input
                type="number"
                id="precio"
                name="precio"
                value="{{ old('precio') }}"
                step="0.01"
                min="0"
                placeholder="Precio"
                required
            >
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>

            <input
                type="number"
                id="stock"
                name="stock"
                value="{{ old('stock') }}"
                min="0"
                placeholder="Cantidad disponible"
                required
            >
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
        </div>

        <div class="form-group">
            <label for="imagen">Imagen</label>

            <input
                type="file"
                id="imagen"
                name="imagen"
                accept="image/*"
            >
        </div>

        <button type="submit" class="btn-admin">
            ➕ Agregar producto
        </button>

    </form>

</div>

<div class="admin-tabla">

    <h2>📋 Productos registrados</h2>

    <div class="tabla-responsive">

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
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
                            {{ $producto->id }}
                        </td>

                        <td>
                            {{ $producto->nombre }}
                        </td>

                        <td>
                            ${{ number_format($producto->precio, 2) }}
                        </td>

                        <td>
                            {{ $producto->stock }}
                        </td>

                        <td>
                            {{ $producto->categoria ?? 'Sin categoría' }}
                        </td>

                        <td>

                            <form
                                action="{{ route('admin.productos.eliminar', $producto->id) }}"
                                method="POST"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn-eliminar-admin"
                                >
                                    🗑 Eliminar
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6">
                            No hay productos registrados.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection