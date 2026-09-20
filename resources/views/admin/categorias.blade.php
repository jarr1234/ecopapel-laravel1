@extends('layouts.admin')

@section('title', 'Categorías | Ecopapel Admin')

@section('content')

<section class="admin-page">

    <div class="admin-page-header">

        <div class="admin-page-heading">
            <span class="admin-page-label">ORGANIZACIÓN</span>
            <h1>🗂️ Categorías</h1>
            <p>Organiza y administra las categorías de productos de Ecopapel.</p>
        </div>

        <div class="admin-page-actions">

            <a
                href="{{ route('admin.productos.ver') }}"
                class="admin-secondary-button"
            >
                📦 Ver productos
            </a>

        </div>

    </div>

    <div class="admin-category-layout">

        <div class="admin-form-card admin-category-form-card">

            <div class="admin-section-heading">

                <div class="admin-section-icon">
                    ➕
                </div>

                <div>
                    <h2>Nueva categoría</h2>
                    <p>Crea una categoría para organizar los productos.</p>
                </div>

            </div>

            <form
                action="{{ route('admin.categorias.guardar') }}"
                method="POST"
                class="admin-category-form"
            >

                @csrf

                <div class="form-group">

                    <label for="nombre">
                        Nombre de la categoría
                    </label>

                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        value="{{ old('nombre') }}"
                        placeholder="Ej. Cuadernos"
                        maxlength="100"
                        required
                    >

                    @error('nombre')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <button
                    type="submit"
                    class="admin-primary-button"
                >
                    ➕ Guardar categoría
                </button>

            </form>

        </div>

        <div class="admin-category-summary">

            <div class="admin-summary-icon">
                🗂️
            </div>

            <div>
                <span>Categorías registradas</span>

                <strong>
                    {{ $categorias->count() }}
                </strong>

                <p>
                    Categorías disponibles para organizar el catálogo.
                </p>
            </div>

        </div>

    </div>

    <div class="admin-list-card">

        <div class="admin-section-heading admin-section-heading-between">

            <div class="admin-section-title-group">

                <div class="admin-section-icon">
                    📋
                </div>

                <div>
                    <h2>Categorías registradas</h2>
                    <p>Consulta y administra las categorías disponibles.</p>
                </div>

            </div>

            <span class="admin-count-badge">
                {{ $categorias->count() }}
                {{ $categorias->count() === 1 ? 'categoría' : 'categorías' }}
            </span>

        </div>

        <div class="tabla-responsive">

            <table class="admin-modern-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($categorias as $categoria)

                        <tr>

                            <td>
                                <span class="admin-id">
                                    #{{ $categoria->id }}
                                </span>
                            </td>

                            <td>

                                <div class="admin-category-name">

                                    <div class="admin-category-icon">
                                        🗂️
                                    </div>

                                    <strong>
                                        {{ $categoria->nombre }}
                                    </strong>

                                </div>

                            </td>

                            <td>
                                <span class="admin-status-badge admin-status-active">
                                    Activa
                                </span>
                            </td>

                            <td>

                                <form
                                    action="{{ route('admin.categorias.eliminar', $categoria->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar esta categoría?')"
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

                            <td colspan="4">

                                <div class="admin-empty-state">

                                    <span>🗂️</span>

                                    <strong>
                                        No hay categorías registradas
                                    </strong>

                                    <p>
                                        Crea tu primera categoría utilizando el formulario superior.
                                    </p>

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