@extends('layouts.mentor')

@section('mentor-title', 'Mis estudiantes')
@section('mentor-subtitle', 'Personas inscritas en tus cursos Lovable')

@section('mentor-content')
    <div class="card">
        <h2 class="text-xl font-semibold text-secondary">Estudiantes inscritos en tus cursos</h2>
        <p class="text-sm text-slate-500">Haz seguimiento del avance y progreso.</p>

        <div class="mt-6 space-y-4">
            @forelse($students as $student)
                <article class="rounded-2xl border border-slate-100 p-5">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-lg font-semibold text-secondary">{{ $student->name }}</p>
                            <p class="text-sm text-slate-500">{{ $student->email }}</p>
                        </div>
                        <span class="badge bg-primary/10 text-primary">{{ $student->courses_count }} cursos</span>
                    </div>
                    <p class="mt-3 text-sm text-slate-500">
                        Última actividad: {{ optional($student->last_activity_at)->diffForHumans() ?? 'Sin actividad reciente' }}
                    </p>
                </article>
            @empty
                <p class="rounded-2xl border border-dashed border-slate-200 p-6 text-center text-sm text-slate-500">
                    Aún no tienes estudiantes asignados.
                </p>
            @endforelse
        </div>
    </div>
@endsection
