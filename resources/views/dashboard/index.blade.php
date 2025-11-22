@extends('layouts.dashboard')

@php
    $user = auth()->user();
    $activeCourses = $stats['courses_active'] ?? 0;
    $pendingCourses = $stats['courses_pending'] ?? 0;
    $draftCourses = $stats['courses_drafts'] ?? 0;
    $mentorshipsUpcoming = $stats['mentorships_upcoming'] ?? 0;
    $totalPipeline = max(1, $activeCourses + $pendingCourses + $draftCourses);
@endphp

@section('dashboard-title', 'Panel principal')

@section('dashboard-actions')
    <div class="flex flex-wrap gap-3">
        <form action="{{ route('cursos.create-draft') }}" method="POST">
            @csrf
            <button type="submit" class="btn-primary rounded-full px-5 py-3 text-sm font-semibold shadow-lg shadow-primary/20">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14"/>
                </svg>
                Nuevo curso
            </button>
        </form>
        <a href="{{ route('mentorias.create') }}" class="btn-secondary px-5 py-3 text-sm font-semibold">
            Programar mentoría
        </a>
        <a href="{{ route('cursos.index') }}" class="btn-secondary border border-slate-200 px-5 py-3 text-sm font-semibold">
            Ver biblioteca
        </a>
    </div>
@endsection

@section('dashboard-widgets')
    <div class="lg:col-span-2 rounded-[32px] bg-gradient-to-r from-indigo-500 via-sky-500 to-cyan-400 p-[1px] shadow-2xl">
        <div class="rounded-[30px] bg-white/95 px-8 py-7 backdrop-blur">
            <div class="flex flex-wrap items-center justify-between gap-6">
                <div>
                    <p class="text-xs uppercase tracking-[0.6em] text-slate-400">Hola, {{ $user->name }}</p>
                    <h2 class="text-3xl font-semibold text-secondary">Bienvenido(a) al panel creativo</h2>
                    <p class="mt-2 max-w-2xl text-sm text-slate-600">
                        Revisa el estado de tus cursos, mentorías y pendientes en un solo lugar. Cada acción se sincroniza con tu nuevo editor visual.
                    </p>
                </div>
                <div class="rounded-3xl border border-slate-100 bg-white px-6 py-4 shadow-inner">
                    <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Última sincronización</p>
                    <p class="mt-1 text-2xl font-semibold text-secondary">{{ now()->format('d M · H:i') }}</p>
                    <p class="text-xs text-slate-400">Todo al día</p>
                </div>
            </div>
            <div class="mt-6 grid gap-4 md:grid-cols-4">
                <div class="rounded-2xl border border-slate-100 bg-white px-4 py-3 shadow-inner">
                    <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Activos</p>
                    <p class="mt-1 text-2xl font-bold text-secondary">{{ $activeCourses }}</p>
                    <p class="text-xs text-emerald-500">+2 esta semana</p>
                </div>
                <div class="rounded-2xl border border-slate-100 bg-white px-4 py-3 shadow-inner">
                    <p class="text-xs uppercase tracking-[0.4em] text-slate-400">En revisión</p>
                    <p class="mt-1 text-2xl font-bold text-secondary">{{ $pendingCourses }}</p>
                    <p class="text-xs text-amber-500">Listos para aprobación</p>
                </div>
                <div class="rounded-2xl border border-slate-100 bg-white px-4 py-3 shadow-inner">
                    <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Borradores</p>
                    <p class="mt-1 text-2xl font-bold text-secondary">{{ $draftCourses }}</p>
                    <p class="text-xs text-slate-400">Edita en el modo Canva</p>
                </div>
                <div class="rounded-2xl border border-slate-100 bg-white px-4 py-3 shadow-inner">
                    <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Mentorías</p>
                    <p class="mt-1 text-2xl font-bold text-secondary">{{ $mentorshipsUpcoming }}</p>
                    <p class="text-xs text-slate-400">Próximos 7 días</p>
                </div>
            </div>
        </div>
    </div>

    <div class="rounded-[28px] border border-slate-100 bg-white/90 p-6 shadow-card">
        <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Focus semanal</p>
        <ul class="mt-4 space-y-3 text-sm text-slate-600">
            <li class="flex items-center gap-3 rounded-2xl border border-slate-100 px-4 py-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3"/>
                    </svg>
                </span>
                Lanza al menos un curso a revisión.
            </li>
            <li class="flex items-center gap-3 rounded-2xl border border-slate-100 px-4 py-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-2xl bg-amber-100 text-amber-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </span>
                Sube recursos visuales a tus borradores.
            </li>
            <li class="flex items-center gap-3 rounded-2xl border border-slate-100 px-4 py-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"/>
                    </svg>
                </span>
                Confirma las mentorías críticas para mentores VIP.
            </li>
        </ul>
    </div>

    <div class="rounded-[28px] border border-slate-100 bg-white/90 p-6 shadow-card">
        <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Insights de comunidad</p>
        <div class="mt-4 space-y-4">
            <div>
                <div class="flex items-center justify-between text-xs font-semibold text-secondary">
                    <span>Feedback positivo</span>
                    <span>92%</span>
                </div>
                <div class="mt-1 h-2 rounded-full bg-slate-100">
                    <div class="h-2 w-[92%] rounded-full bg-emerald-400"></div>
                </div>
            </div>
            <div>
                <div class="flex items-center justify-between text-xs font-semibold text-secondary">
                    <span>Respuestas a foros</span>
                    <span>64%</span>
                </div>
                <div class="mt-1 h-2 rounded-full bg-slate-100">
                    <div class="h-2 w-[64%] rounded-full bg-indigo-400"></div>
                </div>
            </div>
            <div>
                <div class="flex items-center justify-between text-xs font-semibold text-secondary">
                    <span>Mentorías completadas</span>
                    <span>78%</span>
                </div>
                <div class="mt-1 h-2 rounded-full bg-slate-100">
                    <div class="h-2 w-[78%] rounded-full bg-sky-400"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('dashboard-content')
    <div class="grid gap-6 xl:grid-cols-3">
        <div class="space-y-6 xl:col-span-2">
            <div class="rounded-[28px] border border-slate-100 bg-white/90 p-6 shadow-card">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Estado de tus cursos</p>
                        <h2 class="text-lg font-semibold text-secondary">Pipeline creativo</h2>
                    </div>
                    <span class="rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-500">Total {{ $totalPipeline }}</span>
                </div>
                <div class="mt-5 space-y-4">
                    <div>
                        <div class="flex items-center justify-between text-xs font-semibold text-secondary">
                            <span>Borradores</span>
                            <span>{{ $draftCourses }}</span>
                        </div>
                        <div class="mt-1 h-2 rounded-full bg-slate-100">
                            <div class="h-2 rounded-full bg-slate-400" style="width: {{ ($draftCourses / $totalPipeline) * 100 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between text-xs font-semibold text-secondary">
                            <span>En revisión</span>
                            <span>{{ $pendingCourses }}</span>
                        </div>
                        <div class="mt-1 h-2 rounded-full bg-slate-100">
                            <div class="h-2 rounded-full bg-amber-400" style="width: {{ ($pendingCourses / $totalPipeline) * 100 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between text-xs font-semibold text-secondary">
                            <span>Publicados</span>
                            <span>{{ $activeCourses }}</span>
                        </div>
                        <div class="mt-1 h-2 rounded-full bg-slate-100">
                            <div class="h-2 rounded-full bg-emerald-400" style="width: {{ ($activeCourses / $totalPipeline) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
                <p class="mt-4 text-xs text-slate-400">Actualiza los borradores en el editor visual y envíalos cuando estén listos.</p>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-[28px] border border-slate-100 bg-white/90 p-6 shadow-card">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-secondary">Últimos cursos</h2>
                        <a href="{{ route('cursos.index') }}" class="text-sm font-medium text-primary">Ver todos</a>
                    </div>
                    <ul class="mt-5 space-y-4">
                        @forelse($recentCourses ?? [] as $course)
                            <li class="rounded-2xl border border-slate-100 px-4 py-3 shadow-inner">
                                <p class="font-semibold text-secondary">{{ $course->title }}</p>
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $course->category }} · {{ $course->level }}</p>
                                <div class="mt-2 flex items-center gap-3 text-xs text-slate-500">
                                    <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-1">
                                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                                        {{ ucfirst($course->status ?? 'borrador') }}
                                    </span>
                                    <span>{{ $course->updated_at?->diffForHumans() }}</span>
                                </div>
                            </li>
                        @empty
                            <li class="rounded-2xl border border-dashed border-slate-200 px-4 py-6 text-center text-sm text-slate-500">
                                Aún no tienes cursos registrados.
                            </li>
                        @endforelse
                    </ul>
                </div>

                <div class="rounded-[28px] border border-slate-100 bg-white/90 p-6 shadow-card">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-secondary">Próximas mentorías</h2>
                        <a href="{{ route('mentorias.index') }}" class="text-sm font-medium text-primary">Ver agenda</a>
                    </div>
                    <ul class="mt-5 space-y-4">
                        @forelse($upcomingMentorships ?? [] as $session)
                            <li class="flex items-start justify-between rounded-2xl border border-slate-100 px-4 py-3 shadow-inner">
                                <div>
                                    <p class="font-semibold text-secondary">{{ $session->title }}</p>
                                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $session->mentor?->name ?? 'Mentoría' }}</p>
                                    <p class="mt-1 text-sm text-slate-500">
                                        @if($session->scheduled_at)
                                            {{ $session->scheduled_at->format('d M, H:i') }}
                                        @else
                                            Sin fecha programada
                                        @endif
                                    </p>
                                </div>
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">
                                    {{ strtoupper($session->status ?? 'pendiente') }}
                                </span>
                            </li>
                        @empty
                            <li class="rounded-2xl border border-dashed border-slate-200 px-4 py-6 text-center text-sm text-slate-500">
                                No hay sesiones programadas todavía.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-[28px] border border-slate-100 bg-white/90 p-6 shadow-card">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-secondary">Checklist de lanzamiento</h2>
                    <span class="text-xs font-semibold text-emerald-500">Actualizado</span>
                </div>
                <ul class="mt-4 space-y-3 text-sm text-slate-600">
                    <li class="flex items-center gap-3">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </span>
                        Añade objetivos claros al curso.
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </span>
                        Revisa recursos descargables.
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2 2m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                        Agenda mentorías complementarias.
                    </li>
                </ul>
            </div>

            <div class="rounded-[28px] border border-slate-100 bg-white/90 p-6 shadow-card">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-secondary">Actividad reciente</h2>
                    <button class="text-xs font-semibold text-primary">Descargar reporte</button>
                </div>
                <div class="mt-4 space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="rounded-2xl bg-indigo-50 p-3 text-indigo-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-secondary">Has actualizado un módulo desde el editor visual.</p>
                            <p class="text-xs text-slate-400">Hace 8 minutos</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="rounded-2xl bg-sky-50 p-3 text-sky-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-secondary">Nuevo estudiante inscrito en “{{ $recentCourses[0]->title ?? 'Curso destacado' }}”.</p>
                            <p class="text-xs text-slate-400">Hace 2 horas</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="rounded-2xl bg-emerald-50 p-3 text-emerald-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-secondary">Una mentoría ha sido confirmada para esta semana.</p>
                            <p class="text-xs text-slate-400">Hace 1 día</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
