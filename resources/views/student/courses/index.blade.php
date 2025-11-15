@extends('layouts.student')

@section('student-title', 'Mis cursos')
@section('student-subtitle', 'Encuentra los cursos que has adquirido')

@section('student-content')
    <div class="card">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-lg font-semibold text-secondary">Cursos activos</h2>
            <span class="text-sm text-slate-500">{{ $courses->count() }} cursos</span>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-2">
            @forelse($courses as $course)
                <article class="rounded-3xl border border-slate-100 bg-white/80 p-5 shadow-card">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $course->category }}</p>
                    <h3 class="mt-1 text-xl font-semibold text-secondary">{{ $course->title }}</h3>
                    <p class="text-sm text-slate-500">Nivel {{ ucfirst($course->level) }} · {{ $course->lessons_count ?? 0 }} lecciones</p>

                    <div class="mt-4 flex items-center justify-between text-sm text-slate-500">
                        <span>Progreso</span>
                        <span class="font-semibold text-secondary">{{ $course->pivot->progress ?? 0 }}%</span>
                    </div>
                    <div class="mt-2 h-2 rounded-full bg-slate-100">
                        <div class="h-2 rounded-full bg-primary" style="width: {{ $course->pivot->progress ?? 0 }}%;"></div>
                    </div>

                    <div class="mt-5 flex gap-3">
                        <a href="{{ route('courses.classroom', $course) }}"
                           class="btn-primary flex-1 justify-center">Continuar</a>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-slate-200 p-10 text-center text-slate-500 md:col-span-2">
                    Aún no tienes cursos inscritos.
                </div>
            @endforelse
        </div>
    </div>
@endsection
