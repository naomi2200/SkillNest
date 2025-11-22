@extends('layouts.dashboard')

@section('dashboard-title', 'Panel administrativo')

@section('dashboard-actions')
    <div class="flex flex-wrap gap-3">
        <span class="rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">
            Estado actual:
            <span class="ml-2 rounded-full bg-secondary/10 px-3 py-0.5 text-secondary capitalize">{{ $currentStatus }}</span>
        </span>
    </div>
@endsection

@section('dashboard-widgets')
    <div class="lg:col-span-2 rounded-[32px] bg-gradient-to-r from-slate-900 via-indigo-700 to-sky-500 p-[1px] text-white shadow-2xl">
        <div class="rounded-[30px] bg-slate-900/80 px-8 py-7 backdrop-blur">
            <div class="flex flex-wrap items-center justify-between gap-6">
                <div>
                    <p class="text-xs uppercase tracking-[0.5em] text-white/60">Centro de revisión</p>
                    <h2 class="text-3xl font-semibold">Supervisa todos los cursos enviados</h2>
                    <p class="mt-2 max-w-2xl text-sm text-white/80">Mantén la calidad de SkillNest validando contenidos, mentorías y recursos antes de publicarlos.</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/10 px-6 py-4 shadow-inner">
                    <p class="text-xs uppercase tracking-[0.4em] text-white/70">Última verificación</p>
                    <p class="mt-1 text-2xl font-semibold">{{ now()->format('d M · H:i') }}</p>
                    <p class="text-xs text-white/70">Los datos se actualizan en tiempo real</p>
                </div>
            </div>
            <div class="mt-6 grid gap-4 md:grid-cols-4 text-slate-900">
                <div class="rounded-2xl bg-white px-4 py-3 shadow-inner">
                    <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Pendientes</p>
                    <p class="mt-1 text-3xl font-bold text-secondary">{{ $pendingCount }}</p>
                    <p class="text-xs text-amber-500">Cursos esperando revisión</p>
                </div>
                <div class="rounded-2xl bg-white px-4 py-3 shadow-inner">
                    <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Aprobados</p>
                    <p class="mt-1 text-3xl font-bold text-secondary">{{ $approvedCount }}</p>
                    <p class="text-xs text-emerald-500">Listos para estudiantes</p>
                </div>
                <div class="rounded-2xl bg-white px-4 py-3 shadow-inner">
                    <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Rechazados</p>
                    <p class="mt-1 text-3xl font-bold text-secondary">{{ $rejectedCount }}</p>
                    <p class="text-xs text-rose-500">Requieren ajustes</p>
                </div>
                <div class="rounded-2xl bg-white px-4 py-3 shadow-inner">
                    <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Total</p>
                    <p class="mt-1 text-3xl font-bold text-secondary">{{ $totalCourses }}</p>
                    <p class="text-xs text-slate-500">Cursos registrados</p>
                </div>
            </div>
        </div>
    </div>
    <div class="rounded-[28px] border border-slate-200 bg-white/90 p-6 shadow-card">
        <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Alertas rápidas</p>
        <ul class="mt-4 space-y-3 text-sm text-slate-600">
            <li class="flex items-center gap-3 rounded-2xl border border-slate-100 px-4 py-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-2xl bg-amber-100 text-amber-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M12 5a7 7 0 00-7 7v1.5l-1.5 1.5h17L19 13V12a7 7 0 00-7-7z"/></svg>
                </span>
                Verifica los cursos con observaciones antes de 24h.
            </li>
            <li class="flex items-center gap-3 rounded-2xl border border-slate-100 px-4 py-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </span>
                Mantén comunicación con mentores para acelerar aprobaciones.
            </li>
        </ul>
    </div>
    <div class="rounded-[28px] border border-slate-200 bg-white/90 p-6 shadow-card">
        <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Historial reciente</p>
        <div class="mt-4 space-y-3 text-sm text-slate-600">
            <div class="flex items-start gap-3">
                <span class="rounded-2xl bg-indigo-50 px-3 py-1 text-indigo-600 text-xs font-semibold">Nuevo</span>
                Se han recibido {{ $pendingCount }} cursos pendientes esta semana.
            </div>
            <div class="flex items-start gap-3">
                <span class="rounded-2xl bg-sky-50 px-3 py-1 text-sky-600 text-xs font-semibold">Moderación</span>
                Se aprobaron {{ $approvedCount }} cursos en las últimas 48h.
            </div>
        </div>
    </div>
@endsection

@section('dashboard-content')
    <div class="rounded-[32px] border border-slate-200 bg-white/95 p-6 shadow-card">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Revisión de cursos</p>
                <h2 class="text-2xl font-semibold text-secondary">Gestiona los envíos de mentores</h2>
                <p class="text-sm text-slate-500">Aprueba, rechaza o solicita cambios en un solo lugar.</p>
            </div>
            <a href="{{ route('admin.courses.index', ['status' => 'pendiente']) }}"
               class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:border-primary hover:text-primary">
                Ver pendientes
            </a>
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            @php
                $tabs = [
                    'pendiente' => 'Pendientes',
                    'aprobado' => 'Aprobados',
                    'rechazado' => 'Rechazados',
                ];
            @endphp
            @foreach($tabs as $status => $label)
                <a href="{{ route('admin.courses.index', ['status' => $status]) }}"
                   class="rounded-full px-5 py-2 text-sm font-semibold transition
                      {{ $currentStatus === $status ? 'bg-indigo-600 text-white shadow-card' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="mt-8 space-y-4">
            @forelse($courses as $course)
                <article class="rounded-[32px] border border-slate-100 bg-slate-50/80 p-6 shadow-inner">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div class="space-y-1">
                            <p class="text-xs uppercase tracking-[0.4em] text-slate-400">{{ $course->category }}</p>
                            <h3 class="text-xl font-semibold text-secondary">{{ $course->title }}</h3>
                            <p class="text-sm text-slate-500">Mentor: {{ $course->mentor->name ?? 'Sin asignar' }}</p>
                        </div>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold capitalize
                            @class([
                                'bg-amber-100 text-amber-700' => $course->status === 'pendiente',
                                'bg-emerald-100 text-emerald-700' => $course->status === 'aprobado',
                                'bg-rose-100 text-rose-600' => $course->status === 'rechazado',
                            ])">
                            {{ $course->status }}
                        </span>
                    </div>

                    <p class="mt-3 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($course->description, 220) }}</p>
                    <div class="mt-4 flex flex-wrap items-center gap-3 text-xs text-slate-500">
                        <span>{{ $course->modules_count }} módulos</span>
                        <span>•</span>
                        <span>Actualizado {{ optional($course->updated_at)->diffForHumans() ?? 'N/A' }}</span>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('admin.courses.show', $course->id) }}"
                           class="rounded-full bg-white px-5 py-2 text-sm font-semibold text-secondary shadow-card hover:bg-slate-100">
                            Ver detalle
                        </a>

                        @if($course->status === 'pendiente')
                            <form action="{{ route('admin.courses.approve', $course->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="rounded-full bg-emerald-100 px-5 py-2 text-sm font-semibold text-emerald-700 shadow-card hover:bg-emerald-200">
                                    Aprobar
                                </button>
                            </form>
                            <form action="{{ route('admin.courses.reject', $course->id) }}" method="POST" class="flex gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="text" name="rejection_reason" required
                                       class="min-w-[220px] rounded-2xl border border-slate-200 px-3 py-2 text-sm text-slate-600 focus:border-primary focus:outline-none"
                                       placeholder="Motivo de rechazo">
                                <button type="submit"
                                        class="rounded-full bg-rose-100 px-4 py-2 text-sm font-semibold text-rose-600 shadow-card hover:bg-rose-200">
                                    Rechazar
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.courses.reset', $course->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="rounded-full bg-amber-100 px-5 py-2 text-sm font-semibold text-amber-700 shadow-card hover:bg-amber-200">
                                    Volver a revisión
                                </button>
                            </form>
                        @endif
                    </div>
                </article>
            @empty
                <p class="rounded-3xl border border-dashed border-slate-200 bg-white/80 p-6 text-center text-sm text-slate-500">
                    No existen cursos para el estado seleccionado.
                </p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $courses->links() }}
        </div>
    </div>
@endsection
