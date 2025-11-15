@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-6xl space-y-6 py-10">
        <div>
            <p class="text-sm uppercase tracking-wide text-slate-400">Panel administrativo</p>
            <h1 class="text-3xl font-bold text-secondary">Cursos en revisión</h1>
        </div>

        <div class="space-y-4">
            @forelse($courses as $course)
                <article class="rounded-2xl border border-slate-100 bg-white p-6 shadow-card">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-400">{{ $course->category }}</p>
                            <h2 class="text-xl font-semibold text-secondary">{{ $course->title }}</h2>
                            <p class="text-sm text-slate-500">Mentor: {{ $course->mentor->name ?? 'Sin asignar' }}</p>
                        </div>
                        <span class="badge {{ $course->review_status === 'pending' ? 'bg-warning/10 text-warning' : 'bg-danger/10 text-danger' }}">
                            {{ ucfirst($course->review_status) }}
                        </span>
                    </div>
                    <p class="mt-3 text-sm text-slate-600">{{ Str::limit($course->description, 160) }}</p>

                    <div class="mt-4 flex flex-wrap gap-3">
                        <form action="{{ route('admin.courses.approve', $course) }}" method="POST">
                            @csrf
                            <button class="btn-primary rounded-full px-5">Aprobar</button>
                        </form>
                        <form action="{{ route('admin.courses.reject', $course) }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="reason" class="rounded-full border border-slate-200 px-4 py-2 text-sm" placeholder="Motivo de rechazo" required>
                            <button class="btn-secondary rounded-full px-4 text-danger">Rechazar</button>
                        </form>
                    </div>
                </article>
            @empty
                <p class="rounded-2xl border border-dashed border-slate-200 p-6 text-center text-sm text-slate-500">
                    No hay cursos pendientes por revisar.
                </p>
            @endforelse
        </div>
    </div>
@endsection
