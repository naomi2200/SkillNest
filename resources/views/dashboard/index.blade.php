@extends('layouts.dashboard')

@section('dashboard-title', 'Panel principal')

@section('dashboard-actions')
    <div class="flex gap-3">
        <a href="{{ route('cursos.create') }}" class="btn-primary">Nuevo curso</a>
        <a href="{{ route('mentorias.create') }}" class="btn-secondary">Nueva mentoría</a>
    </div>
@endsection

@section('dashboard-widgets')
    <div class="card">
        <p class="text-sm uppercase tracking-wide text-slate-400">Cursos activos</p>
        <p class="mt-2 text-4xl font-bold text-secondary">{{ $stats['courses_active'] ?? 0 }}</p>
        <p class="mt-1 text-sm text-slate-500">Cursos publicados y visibles para estudiantes</p>
    </div>
    <div class="card">
        <p class="text-sm uppercase tracking-wide text-slate-400">Mentorías agendadas</p>
        <p class="mt-2 text-4xl font-bold text-secondary">{{ $stats['mentorships_upcoming'] ?? 0 }}</p>
        <p class="mt-1 text-sm text-slate-500">Sesiones confirmadas para los próximos 7 días</p>
    </div>
@endsection

@section('dashboard-content')
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="card">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-secondary">Últimos cursos</h2>
                <a href="{{ route('cursos.index') }}" class="text-sm font-medium text-primary">Ver todos</a>
            </div>
            <ul class="mt-4 space-y-3">
                @forelse($recentCourses ?? [] as $course)
                    <li class="rounded-lg border border-slate-100 px-4 py-3">
                        <p class="font-semibold text-secondary">{{ $course->title }}</p>
                        <p class="text-sm text-slate-500">{{ $course->category }} · {{ $course->level }}</p>
                    </li>
                @empty
                    <li class="rounded-lg border border-dashed border-slate-200 px-4 py-6 text-center text-sm text-slate-500">
                        Aún no tienes cursos registrados.
                    </li>
                @endforelse
            </ul>
        </div>

        <div class="card">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-secondary">Próximas mentorías</h2>
                <a href="{{ route('mentorias.index') }}" class="text-sm font-medium text-primary">Ver agenda</a>
            </div>
            <ul class="mt-4 space-y-3">
                @forelse($upcomingMentorships ?? [] as $session)
                    <li class="rounded-lg border border-slate-100 px-4 py-3">
                        <p class="font-semibold text-secondary">{{ $session->title }}</p>
                        <p class="text-sm text-slate-500">{{ $session->scheduled_at->format('d M, H:i') }}</p>
                    </li>
                @empty
                    <li class="rounded-lg border border-dashed border-slate-200 px-4 py-6 text-center text-sm text-slate-500">
                        No hay sesiones programadas todavía.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
