@extends('layouts.admin')

@section('title', 'Historial de Cortes | Ecopapel Admin')

@section('content')

<div class="admin-header">
    <div>
        <h1>📄 Historial de Cortes</h1>
        <p>Consulta los cortes de ventas generados</p>
    </div>
</div>

<div class="acciones-ventas-superior">

    <a
        href="{{ route('admin.ventas') }}"
        class="btn-admin"
    >
        ⬅ Volver a Ventas
    </a>

</div>

<div class="admin-tabla">

    <h2>📚 Cortes guardados</h2>

    <div class="tabla-responsive">

        <table>

            <thead>
                <tr>
                    <th>Archivo</th>
                    <th>Fecha de generación</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>

                @forelse($cortes as $corte)

                    <tr>

                        <td>
                            {{ $corte['nombre'] }}
                        </td>

                        <td>
                            {{ $corte['fecha'] }}
                        </td>

                        <td>

                            <a
                                href="{{ route('admin.cortes.ver', ['archivo' => $corte['nombre']]) }}"
                                target="_blank"
                                class="btn-pdf-admin"
                            >
                                📄 Ver PDF
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="3">
                            No hay cortes generados todavía.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection