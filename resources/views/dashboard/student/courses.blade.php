@extends('layouts.dashboard')

@section('dashboard-title', 'Mis cursos')

@section('dashboard-content')
    <div class="card">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-secondary">Cursos en los que estás inscrito</h2>
                <p class="text-sm text-slate-500">Gestiona tu progreso y continúa aprendiendo.</p>
            </div>
            <a href="{{ route('cursos.index') }}" class="btn-secondary">Explorar cursos</a>
        </div>

        <div class="mt-6 space-y-4">
            @forelse($courses as $course)
                <article class="rounded-2xl border border-slate-100 p-5">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-secondary">{{ $course->title }}</h3>
                            <p class="text-sm text-slate-500">{{ $course->category }} · {{ $course->level }}</p>
                        </div>
                        <span class="badge bg-primary/10 text-primary">
                            Progreso {{ $course->pivot->progress ?? 0 }}%
                        </span>
                    </div>
                    <p class="mt-3 text-sm text-slate-600">{{ Str::limit($course->description, 140) }}</p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('cursos.show', $course) }}" class="btn-primary">Continuar</a>
                        <a href="{{ route('student.mentorias') }}" class="btn-secondary">Solicitar mentoría</a>
                    </div>
                </article>
            @empty
                <p class="rounded-2xl border border-dashed border-slate-200 p-6 text-center text-sm text-slate-500">
                    Aún no estás inscrito en ningún curso.
                </p>
            @endforelse
        </div>
    </div>
@endsection
