@extends('layouts.admin')

@section('title', 'Usuarios | Ecopapel Admin')

@section('content')

<section class="admin-page">

    <div class="admin-page-header">

        <div class="admin-page-heading">
            <span class="admin-page-label">CUENTAS</span>
            <h1>👥 Usuarios</h1>
            <p>Administra las cuentas de clientes y administradores de Ecopapel.</p>
        </div>

        <div class="admin-page-actions">

            <a
                href="{{ route('admin') }}"
                class="admin-secondary-button"
            >
                ← Volver al panel
            </a>

        </div>

    </div>

    <div class="admin-users-summary">

        <div class="admin-summary-card">

            <div class="admin-summary-icon">
                👥
            </div>

            <div>
                <span>Usuarios registrados</span>
                <strong>{{ $usuarios->count() }}</strong>
                <p>Total de cuentas registradas.</p>
            </div>

        </div>

        <div class="admin-summary-card">

            <div class="admin-summary-icon">
                🛡️
            </div>

            <div>
                <span>Administradores</span>

                <strong>
                    {{ $usuarios->where('rol', 'admin')->count() }}
                </strong>

                <p>Cuentas con acceso administrativo.</p>
            </div>

        </div>

        <div class="admin-summary-card">

            <div class="admin-summary-icon">
                👤
            </div>

            <div>
                <span>Clientes</span>

                <strong>
                    {{ $usuarios->where('rol', 'cliente')->count() }}
                </strong>

                <p>Cuentas de clientes registradas.</p>
            </div>

        </div>

    </div>

    <div class="admin-form-card">

        <div class="admin-section-heading">

            <div class="admin-section-icon">
                ➕
            </div>

            <div>
                <h2>Agregar usuario</h2>
                <p>Crea una nueva cuenta y asigna su nivel de acceso.</p>
            </div>

        </div>

        <form
            action="{{ route('admin.usuarios.guardar') }}"
            method="POST"
            class="admin-user-form"
        >

            @csrf

            <div class="form-group">

                <label for="usuario">
                    Nombre de usuario
                </label>

                <input
                    type="text"
                    id="usuario"
                    name="usuario"
                    value="{{ old('usuario') }}"
                    placeholder="Ej. jorge123"
                    maxlength="100"
                    required
                >

                @error('usuario')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <div class="form-group">

                <label for="correo">
                    Correo electrónico
                </label>

                <input
                    type="email"
                    id="correo"
                    name="correo"
                    value="{{ old('correo') }}"
                    placeholder="correo@ejemplo.com"
                >

                @error('correo')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <div class="form-group">

                <label for="password">
                    Contraseña
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Mínimo 6 caracteres"
                    minlength="6"
                    required
                >

                @error('password')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <div class="form-group">

                <label for="rol">
                    Rol del usuario
                </label>

                <select
                    id="rol"
                    name="rol"
                    required
                >

                    <option
                        value=""
                        disabled
                        @selected(!old('rol'))
                    >
                        Selecciona un rol
                    </option>

                    <option
                        value="cliente"
                        @selected(old('rol') === 'cliente')
                    >
                        👤 Cliente
                    </option>

                    <option
                        value="admin"
                        @selected(old('rol') === 'admin')
                    >
                        🛡️ Administrador
                    </option>

                </select>

                @error('rol')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <div class="admin-form-actions">

                <button
                    type="submit"
                    class="admin-primary-button"
                >
                    ➕ Crear usuario
                </button>

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
                    <h2>Usuarios registrados</h2>
                    <p>Consulta las cuentas y sus permisos dentro de Ecopapel.</p>
                </div>

            </div>

            <span class="admin-count-badge">
                {{ $usuarios->count() }}
                {{ $usuarios->count() === 1 ? 'usuario' : 'usuarios' }}
            </span>

        </div>

        <div class="tabla-responsive">

            <table class="admin-modern-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($usuarios as $usuario)

                        <tr>

                            <td>
                                <span class="admin-id">
                                    #{{ $usuario->id }}
                                </span>
                            </td>

                            <td>

                                <div class="admin-user-cell">

                                    <div class="admin-user-avatar">
                                        {{ strtoupper(substr($usuario->usuario, 0, 1)) }}
                                    </div>

                                    <div>
                                        <strong>
                                            {{ $usuario->usuario }}
                                        </strong>

                                        @if($usuario->id == session('id'))
                                            <small>Tu cuenta</small>
                                        @endif
                                    </div>

                                </div>

                            </td>

                            <td>

                                @if(!empty($usuario->correo))

                                    <span class="admin-user-email">
                                        {{ $usuario->correo }}
                                    </span>

                                @else

                                    <span class="admin-no-data">
                                        Sin correo
                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($usuario->rol === 'admin')

                                    <span class="admin-role-badge admin-role-admin">
                                        🛡️ Administrador
                                    </span>

                                @else

                                    <span class="admin-role-badge admin-role-client">
                                        👤 Cliente
                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($usuario->id != session('id'))

                                    <form
                                        action="{{ route('admin.usuarios.eliminar', $usuario->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?')"
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

                                @else

                                    <span class="admin-current-user">
                                        ✓ Sesión actual
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5">

                                <div class="admin-empty-state">

                                    <span>👥</span>

                                    <strong>
                                        No hay usuarios registrados
                                    </strong>

                                    <p>
                                        Cuando registres usuarios aparecerán en esta sección.
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