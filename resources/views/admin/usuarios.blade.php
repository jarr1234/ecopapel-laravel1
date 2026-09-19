@extends('layouts.admin')

@section('title', 'Usuarios | Ecopapel Admin')

@section('content')

<div class="admin-header">
    <h1>👥 Usuarios</h1>
    <p>Administra las cuentas de Ecopapel</p>
</div>

<div class="admin-formulario">

    <h2>➕ Agregar usuario</h2>

    <form
        action="{{ route('admin.usuarios.guardar') }}"
        method="POST"
    >
        @csrf

        <div class="form-group">
            <label for="usuario">Usuario</label>

            <input
                type="text"
                id="usuario"
                name="usuario"
                value="{{ old('usuario') }}"
                placeholder="Nombre de usuario"
                required
            >

            @error('usuario')
                <span class="form-error">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="correo">Correo electrónico</label>

            <input
                type="email"
                id="correo"
                name="correo"
                value="{{ old('correo') }}"
                placeholder="Correo electrónico"
            >

            @error('correo')
                <span class="form-error">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Contraseña"
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
            <label for="rol">Rol</label>

            <select
                id="rol"
                name="rol"
                required
            >
                <option
                    value="cliente"
                    @selected(old('rol') === 'cliente')
                >
                    Cliente
                </option>

                <option
                    value="admin"
                    @selected(old('rol') === 'admin')
                >
                    Administrador
                </option>
            </select>
        </div>

        <button type="submit" class="btn-admin">
            ➕ Agregar usuario
        </button>

    </form>

</div>

<div class="admin-tabla">

    <h2>📋 Usuarios registrados</h2>

    <div class="tabla-responsive">

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>

                @forelse($usuarios as $usuario)

                    <tr>

                        <td>
                            {{ $usuario->id }}
                        </td>

                        <td>
                            {{ $usuario->usuario }}
                        </td>

                        <td>
                            {{ ucfirst($usuario->rol) }}
                        </td>

                        <td>

                            @if($usuario->id != session('id'))

                                <form
                                    action="{{ route('admin.usuarios.eliminar', $usuario->id) }}"
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

                            @else

                                <span class="usuario-actual">
                                    👤 Tu cuenta
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4">
                            No hay usuarios registrados.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection