@extends('layouts.admin')

@section('title', 'Ventas | Ecopapel Admin')

@section('content')

<div class="admin-header">
    <div>
        <h1>🛒 Administración de Ventas</h1>
        <p>Ventas pendientes de corte</p>
    </div>
</div>

<div class="acciones-ventas-superior">

    <a
        href="{{ route('admin.cortes.generar') }}"
        class="btn-pdf-admin"
        target="_blank"
    >
        📄 Corte del Día
    </a>

    <a
        href="{{ route('admin.cortes') }}"
        class="btn-admin"
    >
        📚 Historial de Cortes
    </a>

</div>

<div class="admin-tabla">

    <div class="tabla-responsive">

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Método</th>
                    <th>Dirección</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>PDF</th>
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
                            {{ $venta->direccion }}
                        </td>

                        <td>
                            {{ $venta->fecha }}
                        </td>

                        <td>

                            @if(strtolower($venta->estado ?? 'pendiente') === 'entregado')

                                <span class="venta-entregada">
                                    ✅ Entregado
                                </span>

                            @else

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
                                        📦 Pendiente
                                    </button>

                                </form>

                            @endif

                        </td>

                        <td>

                            @if(file_exists(public_path('tickets/ticket_' . $venta->id . '.pdf')))

                                <a
                                    href="{{ route('compra.comprobante', $venta->id) }}"
                                    target="_blank"
                                    class="btn-pdf-admin"
                                >
                                    📄 Ver PDF
                                </a>

                            @else

                                <span class="sin-pdf-admin">
                                    Sin PDF
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8">
                            No hay ventas pendientes de corte.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection