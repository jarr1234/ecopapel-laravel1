@extends('layouts.admin')

@section('title', 'Categorías | Ecopapel Admin')

@section('content')

<div class="admin-header">
    <h1>📁 Categorías</h1>
    <p>Administra las categorías de productos de Ecopapel</p>
</div>

<div class="admin-formulario">

    <h2>➕ Agregar categoría</h2>

    <form
        action="{{ route('admin.categorias.guardar') }}"
        method="POST"
    >
        @csrf

        <div class="form-group">
            <label for="nombre">Nombre de la categoría</label>

            <input
                type="text"
                id="nombre"
                name="nombre"
                value="{{ old('nombre') }}"
                placeholder="Ejemplo: Cuadernos"
                required
            >

            @error('nombre')
                <span class="form-error">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <button type="submit" class="btn-admin">
            ➕ Agregar categoría
        </button>

    </form>

</div>

<div class="admin-tabla">

    <h2>📋 Categorías registradas</h2>

    <div class="tabla-responsive">

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Categoría</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>

                @forelse($categorias as $categoria)

                    <tr>

                        <td>
                            {{ $categoria->id }}
                        </td>

                        <td>
                            {{ $categoria->nombre }}
                        </td>

                        <td>

                            <form
                                action="{{ route('admin.categorias.eliminar', $categoria->id) }}"
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
                        <td colspan="3">
                            No hay categorías registradas.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection