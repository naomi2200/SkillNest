@extends('layouts.admin')

@php
    $currentView = request()->query('view', 'solicitudes');
@endphp

@section('admin-title', $currentView === 'tabla' ? 'Gesti&oacute;n de cursos' : 'Centro de solicitudes')
@section('admin-subtitle', $currentView === 'tabla' ? 'Consulta el estado global de todos los cursos enviados.' : 'Aprueba, rechaza o solicita cambios en un solo lugar.')

@section('admin-actions')
    <a href="{{ route('admin.courses.index', ['view' => 'solicitudes', 'status' => request()->query('status', 'pendiente')]) }}"
       class="btn-action {{ $currentView === 'solicitudes' ? 'primary' : 'ghost' }}">
        <i class="fa-solid fa-inbox"></i> Solicitudes
    </a>
    <a href="{{ route('admin.courses.index', ['view' => 'tabla', 'status' => request()->query('status', 'pendiente')]) }}"
       class="btn-action {{ $currentView === 'tabla' ? 'primary' : 'ghost' }}">
        <i class="fa-solid fa-table"></i> Vista tabla
    </a>
@endsection

@push('styles')
    <style>
        :root {
            --primary: #6c47ff;
            --secondary: #1f2937;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --white: #ffffff;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
        }
        .courses-board { border-radius: 32px; border: 1px solid rgba(226,232,240,0.9); background: #fff; padding: 32px; box-shadow: 0 15px 35px rgba(15,23,42,0.08); }
        .courses-board .table-header{display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:20px;margin-bottom:24px;}
        .courses-board .header-content{flex:1;min-width:300px;}
        .courses-board .section-badge{font-size:.75rem;text-transform:uppercase;letter-spacing:.1em;color:var(--gray-400);font-weight:600;margin-bottom:8px;}
        .courses-board .section-title{font-size:1.6rem;font-weight:700;color:var(--secondary);margin-bottom:6px;}
        .courses-board .section-description{color:var(--gray-500);font-size:.95rem;}
        .filter-form{display:flex;gap:12px;align-items:center;}
        .filter-select{padding:10px 16px;border:1px solid var(--gray-300);border-radius:16px;background:var(--white);color:var(--gray-700);font-size:.875rem;min-width:160px;transition:.2s;}
        .filter-select:focus{outline:none;border-color:var(--primary);box-shadow:0 0 0 3px rgba(108,71,255,.1);}
        .filter-button{padding:10px 20px;background:var(--primary);color:var(--white);border:none;border-radius:16px;font-weight:600;font-size:.875rem;cursor:pointer;transition:.2s;}
        .filter-button:hover{background:#5a38e6;transform:translateY(-1px);}
        .table-container{overflow-x:auto;border-radius:24px;border:1px solid var(--gray-200);background:var(--white);}
        .data-table{width:100%;border-collapse:collapse;font-size:.875rem;}
        .data-table thead{background:var(--gray-50);border-bottom:1px solid var(--gray-200);}
        .data-table th{padding:16px 20px;text-align:left;font-size:.75rem;text-transform:uppercase;letter-spacing:.05em;color:var(--gray-500);font-weight:600;white-space:nowrap;}
        .data-table tbody tr{border-bottom:1px solid var(--gray-100);transition:background-color .2s;}
        .data-table tbody tr:hover{background:var(--gray-50);}
        .data-table td{padding:16px 20px;color:var(--gray-700);vertical-align:top;}
        .course-title{font-weight:600;color:var(--secondary);margin-bottom:4px;line-height:1.4;}
        .course-category{font-size:.75rem;color:var(--gray-400);}
        .status-badge{display:inline-flex;align-items:center;padding:6px 12px;border-radius:20px;font-size:.75rem;font-weight:600;text-transform:capitalize;}
        .status-pendiente{background:rgba(245,158,11,.1);color:var(--warning);}
        .status-aprobado{background:rgba(16,185,129,.1);color:var(--success);}
        .status-rechazado{background:rgba(239,68,68,.1);color:var(--error);}
        .action-buttons{display:flex;gap:8px;justify-content:flex-end;flex-wrap:wrap;}
        .btn-table{padding:8px 14px;border-radius:14px;font-size:.8rem;font-weight:600;text-decoration:none;border:none;cursor:pointer;transition:.2s;white-space:nowrap;}
        .btn-view{background:var(--gray-100);color:var(--gray-700);}
        .btn-view:hover{background:var(--gray-200);}
        .btn-approve{background:rgba(16,185,129,.1);color:var(--success);}
        .btn-approve:hover{background:var(--success);color:var(--white);}
        .btn-reject{background:rgba(239,68,68,.1);color:var(--error);}
        .btn-reject:hover{background:var(--error);color:var(--white);}
        .empty-state{text-align:center;padding:60px 20px;color:var(--gray-400);}
        @media (max-width:1024px){.courses-board .table-header{flex-direction:column;align-items:stretch}.filter-form{justify-content:flex-start}}
        @media (max-width:768px){.filter-form{flex-direction:column;align-items:stretch}.table-container{border-radius:16px}.action-buttons{flex-direction:column}.btn-table{text-align:center}}
    </style>
@endpush

@section('admin-content')
    <div class="courses-board">
        <div class="table-header">
            <div class="header-content">
                <div class="section-badge">Gesti&oacute;n de cursos</div>
                <h2 class="section-title">
                    {{ $currentView === 'tabla' ? 'Listado general' : 'Centro de solicitudes' }}
                </h2>
                <p class="section-description">
                    @if($currentView === 'tabla')
                        Consulta cursos publicados, rechazados y en revisi&oacute;n en formato tabla.
                    @else
                        Aprueba, rechaza o solicita cambios en un solo lugar.
                    @endif
                </p>
            </div>

            <form method="GET" class="filter-form">
                <input type="hidden" name="view" value="{{ $currentView === 'tabla' ? 'tabla' : 'solicitudes' }}">
                <select name="status" class="filter-select">
                    <option value="pendiente" @selected($currentStatus === 'pendiente')>Pendientes</option>
                    <option value="aprobado" @selected($currentStatus === 'aprobado')>Aprobados</option>
                    <option value="rechazado" @selected($currentStatus === 'rechazado')>Rechazados</option>
                </select>
                <button class="filter-button">Filtrar</button>
            </form>
        </div>

        <div class="table-container">
            <table class="data-table">
                <thead>
                <tr>
                    <th>Curso</th>
                    <th>Mentor</th>
                    <th>Estado</th>
                    <th>M&oacute;dulos</th>
                    <th>Actualizado</th>
                    <th style="text-align:right;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td>
                            <div class="course-title">{{ $course->title }}</div>
                            <div class="course-category">{{ $course->category ?? 'Sin categor&iacute;a' }}</div>
                        </td>
                        <td>{{ $course->mentor->name ?? 'Sin asignar' }}</td>
                        <td>
                            <span class="status-badge status-{{ $course->status }}">
                                {{ $course->status }}
                            </span>
                        </td>
                        <td>{{ $course->modules_count ?? 0 }}</td>
                        <td class="text-xs text-slate-500">{{ optional($course->updated_at)->diffForHumans() ?? 'N/A' }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.courses.show', $course->id) }}" class="btn-table btn-view">Ver</a>
                                @if($course->status === 'pendiente')
                                    <form action="{{ route('admin.courses.approve', $course->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn-table btn-approve">Aprobar</button>
                                    </form>
                                    <form action="{{ route('admin.courses.reject', $course->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="rejection_reason" value="Curso rechazado desde la vista de tabla">
                                        <button class="btn-table btn-reject">Rechazar</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <p>No hay registros para el estado seleccionado.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px;">
            {{ $courses->links() }}
        </div>
    </div>
@endsection
