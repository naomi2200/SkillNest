@extends('layouts.dashboard')

@php
    $user = auth()->user();
    $activeCourses = $stats['courses_active'] ?? 0;
    $pendingCoursesCount = $stats['courses_pending'] ?? 0;
    $draftCourses = $stats['courses_drafts'] ?? 0;
    $rejectedCourses = $stats['courses_rejected'] ?? 0;
    $mentorshipsConfirmed = $stats['mentorships_upcoming'] ?? 0;
    $mentorshipsPending = $stats['mentorships_pending'] ?? 0;
@endphp

@section('dashboard-actions')
    @if(!$user?->isAdmin())
        <div class="flex flex-wrap gap-3">
            <form action="{{ route('cursos.create-draft') }}" method="POST">
                @csrf
                <button type="submit" class="btn-primary rounded-full px-5 py-3 text-sm font-semibold shadow-lg shadow-primary/20">
                    ➕ Nuevo curso
                </button>
            </form>
            <a href="{{ route('mentorias.create') }}" class="btn-secondary rounded-full border border-slate-200 px-5 py-3 text-sm font-semibold">
                Crear mentoría
            </a>
        </div>
    @endif
@endsection

@section('dashboard-content')
    @if($user?->isAdmin())
        <style>
            .admin-hero {
                border-radius: 32px;
                background: linear-gradient(135deg, #fdfcff 0%, #eef2ff 45%, #ede9fe 100%);
                border: 1px solid rgba(226,232,240,0.8);
                padding: 32px;
                box-shadow: 0 20px 60px rgba(79,70,229,0.12);
                display: flex;
                flex-wrap: wrap;
                gap: 32px;
                justify-content: space-between;
            }
            .admin-hero h2 {
                font-size: 30px;
                font-weight: 800;
                color: #312e81;
                margin-bottom: 12px;
            }
            .admin-hero p {
                color: #4b5563;
                font-size: 15px;
                max-width: 520px;
            }
            .admin-hero .hero-actions {
                margin-top: 20px;
                display: flex;
                gap: 12px;
                flex-wrap: wrap;
            }
            .admin-hero .hero-actions a {
                padding: 12px 22px;
                border-radius: 999px;
                font-weight: 600;
                font-size: 14px;
            }
            .hero-metrics {
                display: grid;
                grid-template-columns: repeat(2, minmax(160px, 1fr));
                gap: 12px;
                min-width: 260px;
            }
            .hero-metric {
                background: rgba(255,255,255,0.9);
                border-radius: 22px;
                padding: 16px 18px;
                border: 1px solid rgba(229,231,235,0.8);
                text-align: left;
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.8);
            }
            .hero-metric span {
                display: block;
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: #94a3b8;
                margin-bottom: 6px;
            }
            .hero-metric strong {
                font-size: 26px;
                font-weight: 800;
                color: #312e81;
            }
            .admin-stat-grid {
                margin-top: 28px;
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 20px;
            }
            .admin-stat-card {
                border-radius: 24px;
                padding: 24px;
                border: 1px solid rgba(226,232,240,0.9);
                background: rgba(255,255,255,0.96);
                box-shadow: 0 10px 35px rgba(79,70,229,0.1);
            }
            .admin-stat-card h3 {
                font-size: 13px;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: #9ca3af;
                margin-bottom: 10px;
            }
            .admin-stat-card p {
                font-size: 34px;
                font-weight: 800;
                color: #312e81;
                margin-bottom: 6px;
            }
            .admin-stat-card small {
                font-size: 12px;
                color: #6b7280;
            }
            .admin-grid {
                margin-top: 32px;
                display: grid;
                gap: 24px;
            }
            @media (min-width: 1100px) {
                .admin-grid {
                    grid-template-columns: 2fr 1fr;
                }
            }
            .admin-card {
                border-radius: 28px;
                border: 1px solid rgba(226,232,240,0.9);
                background: rgba(255,255,255,0.98);
                padding: 28px;
                box-shadow: 0 18px 50px rgba(99,102,241,0.12);
            }
            .admin-card h4 {
                font-size: 20px;
                font-weight: 800;
                color: #1f2937;
                margin-bottom: 18px;
            }
            .list-entry {
                border-radius: 18px;
                border: 1px solid rgba(226,232,240,0.9);
                padding: 16px 18px;
                background: rgba(249,250,251,0.95);
                display: flex;
                justify-content: space-between;
                gap: 16px;
            }
            .list-entry + .list-entry {
                margin-top: 12px;
            }
            .list-entry span {
                font-size: 14px;
                font-weight: 600;
                color: #1f2937;
            }
            .list-entry small {
                display: block;
                margin-top: 4px;
                color: #6b7280;
                font-size: 12px;
            }
            .badge {
                padding: 6px 14px;
                border-radius: 999px;
                font-size: 12px;
                font-weight: 600;
                background: rgba(99,102,241,0.12);
                color: #4338ca;
            }
            .admin-secondary-grid {
                margin-top: 24px;
                display: grid;
                gap: 24px;
            }
            @media (min-width: 1100px) {
                .admin-secondary-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }
        </style>

        <div class="admin-hero">
            <div>
                <p class="text-xs uppercase tracking-[0.5em] text-slate-400">Hola, {{ $user->name }}</p>
                <h2>Panel general de SkillNest</h2>
                <p>Supervisa los cursos enviados a revisión, el estado de la comunidad y las mentorías activas. Desde aquí puedes tomar decisiones rápidas sin perder coherencia con el diseño principal.</p>
                <div class="hero-actions">
                    <a href="{{ route('admin.courses.index', ['status' => 'pendiente']) }}" class="btn-primary">Ver cursos pendientes</a>
                    <a href="{{ route('admin.dashboard') }}" class="btn-secondary border border-slate-200">Abrir panel clásico</a>
                </div>
            </div>
            <div class="hero-metrics">
                <div class="hero-metric">
                    <span>Cursos activos</span>
                    <strong>{{ number_format($activeCourses) }}</strong>
                </div>
                <div class="hero-metric">
                    <span>En revisión</span>
                    <strong>{{ number_format($pendingCoursesCount) }}</strong>
                </div>
                <div class="hero-metric">
                    <span>Mentorías confirmadas</span>
                    <strong>{{ number_format($mentorshipsConfirmed) }}</strong>
                </div>
                <div class="hero-metric">
                    <span>Mentorías pendientes</span>
                    <strong>{{ number_format($mentorshipsPending) }}</strong>
                </div>
            </div>
        </div>

        <div class="admin-stat-grid">
            <div class="admin-stat-card">
                <h3>Cursos aprobados</h3>
                <p>{{ number_format($activeCourses) }}</p>
                <small>Publicados y visibles</small>
            </div>
            <div class="admin-stat-card">
                <h3>En revisión</h3>
                <p>{{ number_format($pendingCoursesCount) }}</p>
                <small>Esperando tu decisión</small>
            </div>
            <div class="admin-stat-card">
                <h3>Borradores</h3>
                <p>{{ number_format($draftCourses) }}</p>
                <small>Listos para enviar</small>
            </div>
            <div class="admin-stat-card">
                <h3>Rechazados</h3>
                <p>{{ number_format($rejectedCourses) }}</p>
                <small>Requieren revisión de mentor</small>
            </div>
        </div>

        <div class="admin-grid">
            <div class="admin-card">
                <h4>En revisión ({{ number_format($pendingCoursesCount) }})</h4>
                @forelse($pendingCourses ?? [] as $course)
                    <div class="list-entry">
                        <div>
                            <span>{{ $course->title }}</span>
                            <small>Mentor: {{ $course->mentor?->name ?? 'Sin asignar' }}</small>
                        </div>
                        <span class="badge">Pendiente</span>
                    </div>
                @empty
                    <div class="list-entry" style="justify-content:center;">
                        <span class="text-sm text-slate-500">No hay cursos pendientes en este momento.</span>
                    </div>
                @endforelse
            </div>

            <div class="admin-card">
                <h4>Nuevos usuarios</h4>
                @forelse($recentUsers ?? [] as $recentUser)
                    <div class="list-entry">
                        <div>
                            <span>{{ $recentUser->name }}</span>
                            <small>{{ ucfirst($recentUser->role ?? 'usuario') }}</small>
                        </div>
                    </div>
                @empty
                    <div class="list-entry" style="justify-content:center;">
                        <span class="text-sm text-slate-500">Sin registros recientes.</span>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="admin-secondary-grid">
            <div class="admin-card">
                <h4>Cursos actualizados</h4>
                @forelse($recentCourses ?? [] as $course)
                    <div class="list-entry">
                        <div>
                            <span>{{ $course->title }}</span>
                            <small>{{ $course->updated_at?->diffForHumans() }}</small>
                        </div>
                        <span class="badge" style="background:rgba(16,185,129,0.12);color:#047857;">
                            {{ ucfirst($course->status ?? 'borrador') }}
                        </span>
                    </div>
                @empty
                    <div class="list-entry" style="justify-content:center;">
                        <span class="text-sm text-slate-500">Aún no hay cursos registrados.</span>
                    </div>
                @endforelse
            </div>

            <div class="admin-card">
                <h4>Mentorías próximas</h4>
                @forelse($upcomingMentorships ?? [] as $session)
                    <div class="list-entry">
                        <div>
                            <span>{{ $session->titulo ?? $session->title ?? 'Mentoría' }}</span>
                            <small>{{ $session->fecha_mentoria?->format('d M · H:i') ?? 'Sin fecha definida' }}</small>
                        </div>
                        <span class="badge">{{ strtoupper($session->estado ?? 'pendiente') }}</span>
                    </div>
                @empty
                    <div class="list-entry" style="justify-content:center;">
                        <span class="text-sm text-slate-500">No hay sesiones programadas.</span>
                    </div>
                @endforelse
            </div>
        </div>
    @else
        <p class="text-sm text-slate-500">Este panel está disponible únicamente para administradores.</p>
    @endif
@endsection
