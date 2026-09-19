@extends('layouts.admin')

@section('title', 'Ventas | Ecopapel Admin')

@section('content')

<div class="admin-header">
    <h1>🛒 Ventas</h1>
    <p>Consulta y administra las ventas de Ecopapel</p>
</div>

<div class="admin-tabla">

    <h2>📋 Ventas registradas</h2>

    <div class="tabla-responsive">

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Total</th>
                    <th>Pago</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>

                @forelse($ventas as $venta)

                    <tr>

                        <td>
                            {{ $venta->id }}
                        </td>

                        <td>
                            {{ $venta->usuario }}
                        </td>

                        <td>
                            ${{ number_format($venta->total, 2) }}
                        </td>

                        <td>
                            {{ $venta->metodo_pago }}
                        </td>

                        <td>
                            {{ $venta->fecha }}
                        </td>

                        <td>
                            {{ $venta->estado ?? 'Pendiente' }}
                        </td>

                        <td>

                            @if(($venta->estado ?? 'Pendiente') !== 'Entregado')

                                <form
                                    action="{{ route('admin.ventas.entregar', $venta->id) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="btn-entregar-admin"
                                    >
                                        ✅ Entregar
                                    </button>

                                </form>

                            @else

                                <span class="venta-entregada">
                                    ✅ Entregado
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7">
                            No hay ventas registradas.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection