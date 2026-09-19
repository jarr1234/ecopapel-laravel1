@extends('layouts.admin')

@section('title', 'Cortes | Ecopapel Admin')

@section('content')

<div class="admin-header">
    <h1>📄 Cortes de ventas</h1>
    <p>Consulta el resumen de ventas de Ecopapel</p>
</div>

<div class="admin-formulario">

    <h2>📅 Filtrar por fecha</h2>

    <form action="{{ route('admin.cortes') }}" method="GET">

        <div class="form-group">
            <label for="desde">Desde</label>

            <input
                type="date"
                id="desde"
                name="desde"
                value="{{ $desde }}"
            >
        </div>

        <div class="form-group">
            <label for="hasta">Hasta</label>

            <input
                type="date"
                id="hasta"
                name="hasta"
                value="{{ $hasta }}"
            >
        </div>

        <button type="submit" class="btn-admin">
            🔍 Consultar corte
        </button>

        <a href="{{ route('admin.cortes') }}" class="btn-admin btn-rojo">
            Limpiar
        </a>

    </form>

</div>

<div class="cards">

    <div class="card">
        <h2>{{ $totalVentas }}</h2>
        <p>Ventas realizadas</p>
    </div>

    <div class="card">
        <h2>${{ number_format($totalDinero, 2) }}</h2>
        <p>Total vendido</p>
    </div>

    <div class="card">
        <h2>${{ number_format($totalEfectivo, 2) }}</h2>
        <p>💵 Efectivo</p>
    </div>

    <div class="card">
        <h2>${{ number_format($totalTarjeta, 2) }}</h2>
        <p>💳 Tarjeta</p>
    </div>

    <div class="card">
        <h2>${{ number_format($totalTransferencia, 2) }}</h2>
        <p>🏦 Transferencia</p>
    </div>

</div>

<div class="admin-tabla">

    <h2>🧾 Detalle del corte</h2>

    <div class="tabla-responsive">

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Total</th>
                    <th>Método de pago</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>

                @forelse($ventas as $venta)

                    <tr>
                        <td>{{ $venta->id }}</td>

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
                            {{ ucfirst($venta->estado ?? 'pendiente') }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="6">
                            No hay ventas en este periodo.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection