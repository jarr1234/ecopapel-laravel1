@extends('layouts.admin')

@section('title', 'Ventas | Ecopapel Admin')

@section('content')

<section class="admin-page">

    <div class="admin-page-header">

        <div class="admin-page-heading">
            <span class="admin-page-label">VENTAS</span>
            <h1>🛒 Administración de ventas</h1>
            <p>Consulta y administra las ventas pendientes de corte.</p>
        </div>

        <div class="admin-page-actions">

            <a
                href="{{ route('admin.cortes') }}"
                class="admin-secondary-button"
            >
                📚 Historial de cortes
            </a>

            <a
                href="{{ route('admin.cortes.generar') }}"
                class="admin-primary-button"
                target="_blank"
            >
                📄 Generar corte
            </a>

        </div>

    </div>

    <div class="admin-sales-summary">

        <div class="admin-summary-card">

            <div class="admin-summary-icon">
                🛒
            </div>

            <div>
                <span>Ventas pendientes de corte</span>

                <strong>
                    {{ $ventas->count() }}
                </strong>

                <p>Ventas que todavía no forman parte de un corte.</p>
            </div>

        </div>

        <div class="admin-summary-card">

            <div class="admin-summary-icon">
                📦
            </div>

            <div>
                <span>Pendientes de entrega</span>

                <strong>
                    {{ $ventas->filter(function ($venta) {
                        return strtolower($venta->estado ?? 'pendiente') !== 'entregado';
                    })->count() }}
                </strong>

                <p>Pedidos que todavía deben marcarse como entregados.</p>
            </div>

        </div>

        <div class="admin-summary-card">

            <div class="admin-summary-icon">
                ✅
            </div>

            <div>
                <span>Entregadas</span>

                <strong>
                    {{ $ventas->filter(function ($venta) {
                        return strtolower($venta->estado ?? '') === 'entregado';
                    })->count() }}
                </strong>

                <p>Ventas listas para incluirse en el próximo corte.</p>
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
                    <h2>Ventas pendientes de corte</h2>
                    <p>Revisa el cliente, pago, entrega y comprobante de cada venta.</p>
                </div>

            </div>

            <span class="admin-count-badge">
                {{ $ventas->count() }}
                {{ $ventas->count() === 1 ? 'venta' : 'ventas' }}
            </span>

        </div>

        <div class="tabla-responsive">

            <table class="admin-modern-table admin-sales-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Método</th>
                        <th>Dirección</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Comprobante</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($ventas as $venta)

                        <tr>

                            <td>
                                <span class="admin-id">
                                    #{{ $venta->id }}
                                </span>
                            </td>

                            <td>

                                <div class="admin-sale-client">

                                    <div class="admin-user-avatar">
                                        {{ strtoupper(substr($venta->usuario ?? 'C', 0, 1)) }}
                                    </div>

                                    <strong>
                                        {{ $venta->usuario ?? 'Cliente' }}
                                    </strong>

                                </div>

                            </td>

                            <td>
                                <strong class="admin-sale-total">
                                    ${{ number_format($venta->total, 2) }}
                                </strong>
                            </td>

                            <td>

                                <span class="admin-payment-badge">
                                    @if(strtolower($venta->metodo_pago ?? '') === 'efectivo')
                                        💵
                                    @elseif(strtolower($venta->metodo_pago ?? '') === 'tarjeta')
                                        💳
                                    @elseif(strtolower($venta->metodo_pago ?? '') === 'transferencia')
                                        🏦
                                    @else
                                        💰
                                    @endif

                                    {{ $venta->metodo_pago }}
                                </span>

                            </td>

                            <td>

                                <div
                                    class="admin-sale-address"
                                    title="{{ $venta->direccion }}"
                                >
                                    📍 {{ $venta->direccion }}
                                </div>

                            </td>

                            <td>

                                <div class="admin-sale-date">
                                    <span>🗓️</span>
                                    <span>{{ $venta->fecha }}</span>
                                </div>

                            </td>

                            <td>

                                @if(strtolower($venta->estado ?? 'pendiente') === 'entregado')

                                    <span class="admin-status-badge admin-status-delivered">
                                        ✓ Entregado
                                    </span>

                                @else

                                    <form
                                        action="{{ route('admin.ventas.entregar', $venta->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Confirmas que este pedido ya fue entregado?')"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="admin-delivery-button"
                                        >
                                            📦 Marcar entregado
                                        </button>

                                    </form>

                                @endif

                            </td>

                            <td>

                                @if(file_exists(public_path('tickets/ticket_' . $venta->id . '.pdf')))

                                    <a
                                        href="{{ route('compra.comprobante', $venta->id) }}"
                                        target="_blank"
                                        class="admin-pdf-button"
                                    >
                                        📄 Ver PDF
                                    </a>

                                @else

                                    <span class="admin-no-pdf">
                                        Sin PDF
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8">

                                <div class="admin-empty-state">

                                    <span>✅</span>

                                    <strong>
                                        No hay ventas pendientes de corte
                                    </strong>

                                    <p>
                                        Las nuevas ventas aparecerán aquí automáticamente.
                                    </p>

                                    <a
                                        href="{{ route('admin.cortes') }}"
                                        class="admin-secondary-button"
                                    >
                                        📚 Ver historial de cortes
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="admin-sales-help">

        <div class="admin-sales-help-icon">
            💡
        </div>

        <div>
            <strong>¿Cómo funciona el corte?</strong>

            <p>
                Primero marca los pedidos como entregados. Al generar el corte,
                las ventas entregadas pendientes de corte se incluirán en el PDF
                y dejarán de aparecer en esta pantalla.
            </p>
        </div>

    </div>

</section>

@endsection