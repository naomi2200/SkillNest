@extends('layouts.mentor')

@section('mentor-title', 'Mis cursos')
@section('mentor-subtitle', 'Gestiona y publica tus experiencias Lovable')

@section('mentor-actions')
    <form action="{{ route('cursos.create-draft') }}" method="POST">
        @csrf
        <button type="submit" class="mentor-btn primary">+ Crear curso</button>
    </form>
@endsection

@section('mentor-content')
    @php
        $draftCount = $courses->where('status', 'borrador')->count();
        $pendingCount = $courses->where('status', 'pendiente')->count();
        $approvedCount = $courses->where('status', 'aprobado')->count();
    @endphp

    <div class="mentor-card" style="margin-bottom: 24px;">
        <div class="mentor-stats-grid" style="display:grid;gap:18px;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));">
            <div class="mentor-stat-card">
                <p class="mentor-stat-label">Borradores</p>
                <p class="mentor-stat-value">{{ $draftCount }}</p>
                <small>En modo editor visual</small>
            </div>
            <div class="mentor-stat-card">
                <p class="mentor-stat-label">En revisión</p>
                <p class="mentor-stat-value" style="color:#b45309;">{{ $pendingCount }}</p>
                <small>Esperando aprobación</small>
            </div>
            <div class="mentor-stat-card">
                <p class="mentor-stat-label">Publicados</p>
                <p class="mentor-stat-value" style="color:#047857;">{{ $approvedCount }}</p>
                <small>Cursos activos</small>
            </div>
        </div>
    </div>

    <div class="mentor-card">
        <div class="mentor-table-wrapper">
            <table class="mentor-table">
                <thead>
                <tr>
                    <th>Curso</th>
                    <th>Inscritos</th>
                    <th>Revisión</th>
                    <th>Estado</th>
                    <th style="text-align:right;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td>
                            <strong>{{ $course->title }}</strong>
                            <div style="font-size:12px;color:#94a3b8;">{{ $course->category }} · {{ $course->level }}</div>
                        </td>
                        <td>{{ $course->estudiantes_count ?? 0 }}</td>
                        <td>
                            @php
                                $reviewBadge = match($course->review_status) {
                                    'approved' => 'mentor-badge badge-approved',
                                    'pending' => 'mentor-badge badge-pending',
                                    'rejected' => 'mentor-badge badge-rejected',
                                    default => 'mentor-badge badge-draft',
                                };
                            @endphp
                            <span class="{{ $reviewBadge }}">{{ ucfirst($course->review_status ?? 'pendiente') }}</span>
                        </td>
                        <td>
                            @php
                                $statusBadge = match($course->status) {
                                    'borrador' => 'mentor-badge badge-draft',
                                    'pendiente' => 'mentor-badge badge-pending',
                                    'aprobado' => 'mentor-badge badge-approved',
                                    'rechazado' => 'mentor-badge badge-rejected',
                                    default => 'mentor-badge badge-draft',
                                };
                            @endphp
                            <span class="{{ $statusBadge }}">{{ ucfirst($course->status) }}</span>
                        </td>
                        <td style="text-align:right;">
                            <a href="{{ route('cursos.editor', $course) }}" style="margin-right:12px;color:#6c47ff;font-weight:600;text-decoration:none;">Editar</a>
                            <a href="{{ route('courses.classroom', $course) }}" style="color:#6b7280;font-weight:500;text-decoration:none;">Aula</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;color:#94a3b8;padding:30px 0;">Aún no has creado cursos.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
