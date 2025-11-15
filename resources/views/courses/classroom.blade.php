@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-6xl space-y-8 py-10">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-wide text-slate-400">Aula virtual</p>
                <h1 class="text-3xl font-bold text-secondary">{{ $course->title }}</h1>
                <p class="text-sm text-slate-500">Progreso personalizado para {{ auth()->user()->name }}</p>
            </div>
            <a href="{{ route('cursos.show', $course->id) }}" class="btn-secondary rounded-full px-6">Volver al curso</a>
        </div>

        <div class="rounded-[28px] border border-slate-100 bg-white shadow-card">
            <div class="grid gap-8 p-6 lg:grid-cols-3">
                <div class="space-y-4 lg:col-span-2">
                    @foreach($course->modules as $module)
                        @php
                            $moduleKey = "module_{$module->id}_lesson_";
                            $moduleProgress = $progress->filter(fn($value, $key) => str_contains($key, "module_{$module->id}_lesson_"));
                            $completedLessons = $moduleProgress->filter(fn($records) => optional($records->first())->status === 'completed')->count();
                            $totalLessons = $module->lessons->count();
                            $moduleUnlocked = $progress->has("module_{$module->id}_lesson_");
                        @endphp
                        <article class="rounded-2xl border border-slate-100 p-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm uppercase tracking-wide text-slate-400">Módulo {{ $loop->iteration }}</p>
                                    <h2 class="text-xl font-semibold text-secondary">{{ $module->title }}</h2>
                                </div>
                                <span class="badge {{ $moduleUnlocked ? 'bg-success/10 text-success' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $moduleUnlocked ? 'Desbloqueado' : 'Bloqueado' }}
                                </span>
                            </div>
                            <p class="mt-2 text-sm text-slate-500">{{ $module->description }}</p>

                            <div class="mt-4 space-y-2">
                                @foreach($module->lessons as $lesson)
                                    @php
                                        $key = "module_{$module->id}_lesson_{$lesson->id}";
                                        $lessonProgress = optional($progress->get($key)[0] ?? null);
                                        $status = $lessonProgress->status ?? 'locked';
                                    @endphp
                                    <div class="flex items-center justify-between rounded-xl border border-slate-200 px-4 py-3">
                                        <div>
                                            <p class="text-sm font-semibold text-secondary">{{ $lesson->title }}</p>
                                            <p class="text-xs text-slate-500">{{ ucfirst($lesson->type) }} · {{ $lesson->duration_minutes ?? 10 }} min</p>
                                        </div>
                                        <button
                                            class="text-sm font-semibold {{ $status === 'completed' ? 'text-success' : 'text-primary' }}"
                                            @if($moduleUnlocked) data-lesson="{{$lesson->id}}" data-status="{{$status}}" class="start-lesson btn-secondary" @endif
                                        >
                                            {{ $status === 'completed' ? 'Completado' : 'Iniciar' }}
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="space-y-6">
                    <div class="rounded-2xl border border-slate-100 p-5">
                        <h3 class="text-lg font-semibold text-secondary">Notas del curso</h3>
                        <p class="mt-3 text-sm text-slate-500">
                            Completa cada módulo y aprueba el quiz final para desbloquear el siguiente. Tu progreso se guarda automáticamente.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 p-5">
                        <h3 class="text-lg font-semibold text-secondary">Soporte</h3>
                        <p class="mt-3 text-sm text-slate-500">¿Necesitas ayuda? Escribe a soporte@skillnest.com con el nombre del curso.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.start-lesson').forEach(button => {
            button.addEventListener('click', () => {
                const lessonId = button.dataset.lesson;
                fetch(`/lessons/${lessonId}/progress`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status: 'completed' })
                }).then(() => window.location.reload());
            });
        });
    </script>
@endsection
