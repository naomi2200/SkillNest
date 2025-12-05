@extends('layouts.admin')

@section('admin-title', 'Curso: ' . $course->title)
@section('admin-subtitle', 'Revision y acciones administrativas del curso')

@section('admin-actions')
    <a href="{{ route('admin.courses.index') }}"
       class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:border-primary hover:text-primary">
        Volver al listado
    </a>
@endsection

@section('admin-content')
    <div class="space-y-8">
        <div class="rounded-[32px] border border-slate-200 bg-white/95 p-6 shadow-card">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Detalle del curso</p>
                    <h1 class="text-3xl font-bold text-secondary">{{ $course->title }}</h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Mentor: <span class="font-semibold text-secondary">{{ $course->mentor->name ?? 'Sin asignar' }}</span>
                    </p>
                    <p class="text-sm text-slate-500">
                        Creado el {{ $course->created_at?->format('d/m/Y H:i') ?? 'Sin fecha' }}
                    </p>
                </div>
                <span class="rounded-full px-4 py-1 text-sm font-semibold capitalize
                    @class([
                        'bg-amber-100 text-amber-700' => $course->status === 'pendiente',
                        'bg-emerald-100 text-emerald-700' => $course->status === 'aprobado',
                        'bg-rose-100 text-rose-600' => $course->status === 'rechazado',
                    ])">
                    {{ $course->status }}
                </span>
            </div>
            @if($course->rejection_reason)
                <div class="mt-4 rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-600">
                    <p class="font-semibold">Motivo de rechazo:</p>
                    <p>{{ $course->rejection_reason }}</p>
                </div>
            @endif
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-[32px] border border-slate-200 bg-white/95 p-6 shadow-card space-y-3">
                <h2 class="text-lg font-semibold text-secondary">Información general</h2>
                <p><span class="font-semibold text-secondary">Descripción:</span> {{ $course->description }}</p>
                <p><span class="font-semibold text-secondary">Categoría:</span> {{ $course->category }}</p>
                <p><span class="font-semibold text-secondary">Nivel:</span> {{ $course->level }}</p>
                <p><span class="font-semibold text-secondary">Duración:</span> {{ $course->duration }} horas</p>
                <p><span class="font-semibold text-secondary">Precio:</span> S/ {{ number_format($course->price, 2) }}</p>
                @if($course->objectives)
                    <p><span class="font-semibold text-secondary">Objetivos:</span> {{ $course->objectives }}</p>
                @endif
                @if($course->requirements)
                    <p><span class="font-semibold text-secondary">Requisitos:</span> {{ $course->requirements }}</p>
                @endif
            </div>
            <div class="rounded-[32px] border border-slate-200 bg-white/95 p-6 shadow-card space-y-4">
                <h2 class="text-lg font-semibold text-secondary">Acciones</h2>
                <div class="space-y-3">
                    @if($course->status === 'pendiente')
                        <form action="{{ route('admin.courses.approve', $course->id) }}" method="POST" class="flex flex-col gap-3">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="rounded-full bg-emerald-100 px-6 py-2 text-sm font-semibold text-emerald-700 shadow-card hover:bg-emerald-200">
                                Aprobar curso
                            </button>
                        </form>
                        <form action="{{ route('admin.courses.reject', $course->id) }}" method="POST" class="flex flex-col gap-3">
                            @csrf
                            @method('PATCH')
                            <label for="rejection_reason" class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">
                                Motivo del rechazo
                            </label>
                            <textarea id="rejection_reason" name="rejection_reason" rows="3" required
                                      class="rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none"
                                      placeholder="Describe los cambios solicitados..."></textarea>
                            <button type="submit"
                                    class="rounded-full bg-rose-100 px-6 py-2 text-sm font-semibold text-rose-600 shadow-card hover:bg-rose-200">
                                Rechazar curso
                            </button>
                        </form>
                    @endif
                    @if(in_array($course->status, ['rechazado', 'aprobado'], true))
                        <form action="{{ route('admin.courses.reset', $course->id) }}" method="POST" class="flex flex-col gap-3">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="rounded-full bg-amber-100 px-6 py-2 text-sm font-semibold text-amber-700 shadow-card hover:bg-amber-200">
                                Volver a revisión
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="pt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="rounded-full bg-slate-100 px-6 py-2 text-sm font-semibold text-slate-600 shadow-card hover:bg-slate-200"
                                onclick="return confirm('¿Estás seguro de eliminar este curso?');">
                            Eliminar curso
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="rounded-[32px] border border-slate-200 bg-white/95 p-6 shadow-card">
            <h2 class="text-lg font-semibold text-secondary">Módulos y lecciones</h2>
            <div class="mt-4 space-y-4">
                @forelse($course->modules as $module)
                    <div class="rounded-2xl border border-slate-100 bg-slate-50/70 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Módulo {{ $module->position }}</p>
                                <h3 class="text-base font-semibold text-secondary">{{ $module->title }}</h3>
                            </div>
                            <span class="text-xs text-slate-500">{{ $module->lessons->count() }} lecciones</span>
                        </div>
                        <p class="mt-2 text-sm text-slate-600">{{ $module->description ?? 'Sin descripción.' }}</p>
                        <ul class="mt-3 list-disc space-y-1 pl-5 text-sm text-slate-500">
                            @forelse($module->lessons as $lesson)
                                <li>
                                    {{ $lesson->title }}
                                    <span class="text-xs uppercase text-slate-400">({{ $lesson->type }})</span>
                                </li>
                            @empty
                                <li class="italic text-slate-400">Sin lecciones registradas.</li>
                            @endforelse
                        </ul>
                    </div>
                @empty
                    <p class="rounded-2xl border border-dashed border-slate-200 p-4 text-center text-sm text-slate-500">
                        No se han configurado módulos para este curso.
                    </p>
                @endforelse
            </div>
        </div>
    </div>
@endsection





