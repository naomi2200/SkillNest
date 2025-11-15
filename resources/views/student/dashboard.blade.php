@extends('layouts.student')

@section('student-title', 'Panel principal')
@section('student-subtitle', 'Revisa tus próximas sesiones y cursos activos')

@section('student-widgets')
    <div class="card">
        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Cursos activos</p>
        <p class="mt-2 text-4xl font-bold text-secondary">{{ $stats['courses'] ?? 0 }}</p>
        <p class="mt-1 text-sm text-slate-500">Cursos que puedes continuar ahora mismo.</p>
    </div>
    <div class="card">
        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Mentorías agendadas</p>
        <p class="mt-2 text-4xl font-bold text-secondary">{{ $stats['mentorias'] ?? 0 }}</p>
        <p class="mt-1 text-sm text-slate-500">Sesiones confirmadas en los próximos días.</p>
    </div>
@endsection

@section('student-content')
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="card h-full">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-secondary">Continuar curso</h2>
                <a href="{{ route('student.courses') }}" class="text-sm font-medium text-primary">Ver todos</a>
            </div>

            @if($nextCourse)
                <div class="mt-4 rounded-2xl border border-slate-100 bg-slate-50/60 p-4">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Progreso {{ $nextCourse->pivot->progress ?? 0 }}%</p>
                    <h3 class="mt-2 text-xl font-semibold text-secondary">{{ $nextCourse->title }}</h3>
                    <p class="text-sm text-slate-500">{{ $nextCourse->category }} • {{ ucfirst($nextCourse->level) }}</p>
                    <a href="{{ route('courses.classroom', $nextCourse) }}"
                       class="mt-4 inline-flex items-center gap-2 rounded-full bg-primary px-5 py-2 text-sm font-semibold text-white shadow-lg shadow-primary/20 transition hover:translate-y-0.5">
                        Reanudar curso
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
            @else
                <div class="mt-4 rounded-2xl border border-dashed border-slate-200 p-6 text-center text-sm text-slate-500">
                    Todavía no te has inscrito en ningún curso.
                </div>
            @endif
        </div>

        <div class="card h-full">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-secondary">Próximas mentorías</h2>
                <a href="{{ route('student.mentorias') }}" class="text-sm font-medium text-primary">Ver agenda</a>
            </div>

            <ul class="mt-4 space-y-3">
                @forelse($upcomingMentorias as $mentoria)
                    <li class="rounded-2xl border border-slate-100 px-4 py-3">
                        <p class="font-semibold text-secondary">{{ $mentoria->tema ?? $mentoria->titulo ?? 'Mentoría' }}</p>
                        <p class="text-sm text-slate-500">
                            {{ optional($mentoria->fecha_mentoria)->format('d M Y') }}
                            · {{ $mentoria->hora_mentoria }}
                        </p>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-primary mt-1">{{ ucfirst($mentoria->estado) }}</p>
                    </li>
                @empty
                    <li class="rounded-2xl border border-dashed border-slate-200 px-4 py-6 text-center text-sm text-slate-500">
                        No hay sesiones programadas por ahora.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
