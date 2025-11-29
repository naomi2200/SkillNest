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
    <style>
        .courses-stats { display:grid; gap:18px; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); }
        .courses-stat-card {
            border-radius: 20px;
            border:1px solid rgba(124,58,237,0.12);
            background:#fff;
            box-shadow:0 16px 36px rgba(124,58,237,0.08);
            padding: 18px;
        }
        .courses-stat-card .label { font-size:13px; text-transform:uppercase; letter-spacing:0.14em; color:#94a3b8; font-weight:800; }
        .courses-stat-card .value { font-size:28px; font-weight:900; margin-top:6px; }
        .courses-pills { display:flex; gap:10px; flex-wrap:wrap; margin: 10px 0 18px; }
        .courses-pill {
            border:1px solid #e5e7eb;
            border-radius:12px;
            padding:10px 14px;
            background:#fff;
            color:#475569;
            font-weight:700;
            cursor:pointer;
        }
        .courses-pill.active {
            background:linear-gradient(135deg,#7c3aed,#8b5cf6);
            color:#fff;
            border-color:transparent;
            box-shadow:0 10px 25px rgba(124,58,237,0.2);
        }
    </style>

    @php
        $draftCount = $courses->where('status', 'borrador')->count();
        $pendingCount = $courses->where('status', 'pendiente')->count();
        $approvedCount = $courses->where('status', 'aprobado')->count();
        $totalCount = $courses->count();
    @endphp

    <div class="mentor-card" style="margin-bottom: 16px;">
        <div class="courses-stats">
            <div class="courses-stat-card">
                <p class="label">Borradores</p>
                <p class="value" style="color:#7c3aed;">{{ $draftCount }}</p>
                <small>En modo editor visual</small>
            </div>
            <div class="courses-stat-card">
                <p class="label">En revisión</p>
                <p class="value" style="color:#b45309;">{{ $pendingCount }}</p>
                <small>Esperando aprobación</small>
            </div>
            <div class="courses-stat-card">
                <p class="label">Publicados</p>
                <p class="value" style="color:#047857;">{{ $approvedCount }}</p>
                <small>Cursos activos</small>
            </div>
            <div class="courses-stat-card">
                <p class="label">Total</p>
                <p class="value">{{ $totalCount }}</p>
                <small>Todos tus cursos</small>
            </div>
        </div>
    </div>

    <div class="mentor-card">
        <div class="courses-pills">
            <button class="courses-pill active" data-filter="all">Todas</button>
            <button class="courses-pill" data-filter="borrador">Borradores</button>
            <button class="courses-pill" data-filter="pendiente">En revisión</button>
            <button class="courses-pill" data-filter="aprobado">Publicadas</button>
        </div>

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
                    <tr data-status="{{ $course->status }}">
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

    <script>
        (function(){
            const pills = document.querySelectorAll('.courses-pill');
            const rows = document.querySelectorAll('.mentor-table tbody tr[data-status]');
            pills.forEach(pill => {
                pill.addEventListener('click', function(){
                    pills.forEach(p => p.classList.remove('active'));
                    this.classList.add('active');
                    const filter = this.dataset.filter;
                    rows.forEach(row => {
                        const status = row.dataset.status || '';
                        const show = filter === 'all' ? true : status === filter;
                        row.style.display = show ? '' : 'none';
                    });
                });
            });
        })();
    </script>
@endsection
