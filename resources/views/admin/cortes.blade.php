@extends('layouts.admin')

@section('title', 'Historial de Cortes | Ecopapel Admin')

@section('content')

<section class="admin-page">

    <div class="admin-page-header">

        <div class="admin-page-heading">
            <span class="admin-page-label">REPORTES</span>
            <h1>📄 Historial de cortes</h1>
            <p>Consulta los cortes de ventas generados y accede a sus comprobantes PDF.</p>
        </div>

        <div class="admin-page-actions">

            <a
                href="{{ route('admin.ventas') }}"
                class="admin-secondary-button"
            >
                ← Volver a ventas
            </a>

        </div>

    </div>

    <div class="admin-cuts-summary">

        <div class="admin-summary-card">

            <div class="admin-summary-icon">
                📚
            </div>

            <div>
                <span>Cortes guardados</span>

                <strong>
                    {{ count($cortes) }}
                </strong>

                <p>Total de cortes disponibles en el historial.</p>
            </div>

        </div>

        <div class="admin-summary-card">

            <div class="admin-summary-icon">
                📄
            </div>

            <div>
                <span>Formato</span>

                <strong>PDF</strong>

                <p>Los cortes se almacenan como documentos PDF.</p>
            </div>

        </div>

        <div class="admin-summary-card">

            <div class="admin-summary-icon">
                🛒
            </div>

            <div>
                <span>Administrar ventas</span>

                <strong>Ventas</strong>

                <p>Regresa a ventas para preparar un nuevo corte.</p>
            </div>

        </div>

    </div>

    <div class="admin-list-card">

        <div class="admin-section-heading admin-section-heading-between">

            <div class="admin-section-title-group">

                <div class="admin-section-icon">
                    📚
                </div>

                <div>
                    <h2>Cortes guardados</h2>
                    <p>Historial de documentos generados por el sistema.</p>
                </div>

            </div>

            <span class="admin-count-badge">
                {{ count($cortes) }}
                {{ count($cortes) === 1 ? 'corte' : 'cortes' }}
            </span>

        </div>

        <div class="tabla-responsive">

            <table class="admin-modern-table admin-cuts-table">

                <thead>
                    <tr>
                        <th>Documento</th>
                        <th>Fecha de generación</th>
                        <th>Formato</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($cortes as $corte)

                        <tr>

                            <td>

                                <div class="admin-cut-document">

                                    <div class="admin-pdf-icon">
                                        PDF
                                    </div>

                                    <div>
                                        <strong>
                                            {{ $corte['nombre'] }}
                                        </strong>

                                        <span>
                                            Corte de ventas
                                        </span>
                                    </div>

                                </div>

                            </td>

                            <td>

                                <div class="admin-cut-date">
                                    <span>🗓️</span>

                                    <strong>
                                        {{ $corte['fecha'] }}
                                    </strong>
                                </div>

                            </td>

                            <td>

                                <span class="admin-file-badge">
                                    📄 PDF
                                </span>

                            </td>

                            <td>

                                <a
                                    href="{{ route('admin.cortes.ver', ['archivo' => $corte['nombre']]) }}"
                                    target="_blank"
                                    class="admin-pdf-button"
                                >
                                    📄 Ver PDF
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4">

                                <div class="admin-empty-state">

                                    <span>📄</span>

                                    <strong>
                                        No hay cortes generados todavía
                                    </strong>

                                    <p>
                                        Cuando generes un corte desde la sección de ventas,
                                        aparecerá automáticamente en este historial.
                                    </p>

                                    <a
                                        href="{{ route('admin.ventas') }}"
                                        class="admin-primary-button"
                                    >
                                        🛒 Ir a ventas
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="admin-cuts-help">

        <div class="admin-cuts-help-icon">
            💡
        </div>

        <div>
            <strong>Historial de cortes</strong>

            <p>
                Los cortes generados permanecen guardados en esta sección.
                Puedes abrir cualquier documento utilizando el botón Ver PDF.
            </p>
        </div>

    </div>

</section>

@endsection