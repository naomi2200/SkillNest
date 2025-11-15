@extends('layouts.mentor')

@section('mentor-title', 'Mis mentorias')
@section('mentor-subtitle', 'Solicitudes recientes y sesiones confirmadas')

@php
    $statusClasses = [
        'pendiente' => 'bg-amber-100 text-amber-700',
        'aceptada' => 'bg-blue-100 text-blue-700',
        'confirmada' => 'bg-blue-100 text-blue-700',
        'rechazada' => 'bg-rose-100 text-rose-700',
        'pagada' => 'bg-emerald-100 text-emerald-700',
        'completada' => 'bg-green-100 text-green-700',
        'cancelada' => 'bg-slate-200 text-slate-600',
    ];
@endphp

@section('mentor-content')
    <div class="space-y-6">
        <div class="card">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-wide text-slate-400">Mentorias</p>
                    <h2 class="text-2xl font-semibold text-secondary">Mis mentorias</h2>
                    <p class="text-sm text-slate-500">
                        Gestiona las sesiones creadas y responde las solicitudes de tus estudiantes.
                    </p>
                </div>
                <span class="text-sm text-slate-500">{{ $stats['total'] ?? 0 }} mentorias en total</span>
            </div>
        </div>

        @if (session('status'))
            <div class="rounded-2xl border border-success/20 bg-success/5 px-4 py-3 text-sm text-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-2xl border border-slate-100 bg-white p-4">
                <p class="text-sm text-slate-500">Solicitudes pendientes</p>
                <p class="mt-2 text-2xl font-semibold text-secondary">{{ $stats['pending'] ?? 0 }}</p>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-white p-4">
                <p class="text-sm text-slate-500">Aceptadas</p>
                <p class="mt-2 text-2xl font-semibold text-secondary">{{ $stats['accepted'] ?? 0 }}</p>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-white p-4">
                <p class="text-sm text-slate-500">Activas / proximas</p>
                <p class="mt-2 text-2xl font-semibold text-secondary">{{ $stats['active'] ?? 0 }}</p>
            </div>
        </div>

        <div class="card space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h3 class="text-xl font-semibold text-secondary">Mis mentorías creadas</h3>
                    <p class="text-sm text-slate-500">Gestiona tus borradores o sesiones publicadas sin estudiante.</p>
                </div>
                <span class="text-sm text-slate-500">{{ $createdMentorias->count() }} registradas</span>
            </div>

            @forelse($createdMentorias as $mentoria)
                <article class="rounded-2xl border border-slate-100 p-5">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h4 class="text-lg font-semibold text-secondary">{{ $mentoria->titulo }}</h4>
                            <p class="text-sm text-slate-500">
                                {{ $mentoria->especialidad ?? 'Especialidad no definida' }} · {{ ucfirst($mentoria->estado) }}
                            </p>
                        </div>
                        <span class="text-sm font-semibold text-secondary">
                            S/ {{ number_format($mentoria->precio ?? 0, 2) }}
                        </span>
                    </div>

                    <dl class="mt-4 grid gap-4 text-sm text-slate-500 sm:grid-cols-4">
                        <div>
                            <dt class="font-medium text-slate-600">Duración</dt>
                            <dd>{{ $mentoria->duracion_minutos }} min</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-600">Modalidad</dt>
                            <dd class="capitalize">{{ $mentoria->modalidad }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-600">Creada</dt>
                            <dd>{{ optional($mentoria->created_at)->format('d/m/Y') }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-600">Estado</dt>
                            <dd class="font-semibold">{{ ucfirst($mentoria->estado) }}</dd>
                        </div>
                    </dl>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <a href="{{ route('mentor.mentorias.edit', $mentoria) }}" class="btn-secondary">
                            Editar
                        </a>
                        <form action="{{ route('mentor.mentorias.destroy', $mentoria) }}" method="POST" onsubmit="return confirm('¿Eliminar esta mentoría?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-secondary bg-rose-50 text-rose-600 border-rose-200">
                                Eliminar
                            </button>
                        </form>
                        @if($mentoria->estado === 'borrador')
                            <form action="{{ route('mentor.mentorias.publicar', $mentoria) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-primary">
                                    Publicar
                                </button>
                            </form>
                        @endif
                    </div>
                </article>
            @empty
                <p class="rounded-2xl border border-dashed border-slate-200 p-6 text-center text-sm text-slate-500">
                    Aún no has creado mentorías.
                </p>
            @endforelse
        </div>

        <div class="card space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h3 class="text-xl font-semibold text-secondary">Mis mentorías publicadas</h3>
                    <p class="text-sm text-slate-500">Actualmente visibles para los estudiantes.</p>
                </div>
                <span class="text-sm text-slate-500">{{ $publishedMentorias->count() }} publicadas</span>
            </div>

            @forelse($publishedMentorias as $mentoria)
                <article class="rounded-2xl border border-slate-100 p-5">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h4 class="text-lg font-semibold text-secondary">{{ $mentoria->titulo }}</h4>
                            <p class="text-sm text-slate-500">
                                {{ $mentoria->especialidad ?? 'Especialidad no definida' }} · Publicada {{ optional($mentoria->updated_at)->format('d/m/Y') }}
                            </p>
                        </div>
                        <span class="text-sm font-semibold text-secondary">
                            S/ {{ number_format($mentoria->precio ?? 0, 2) }}
                        </span>
                    </div>

                    <dl class="mt-4 grid gap-4 text-sm text-slate-500 sm:grid-cols-3">
                        <div>
                            <dt class="font-medium text-slate-600">Duración</dt>
                            <dd>{{ $mentoria->duracion_minutos }} min</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-600">Modalidad</dt>
                            <dd class="capitalize">{{ $mentoria->modalidad }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-600">Estado</dt>
                            <dd class="text-success font-semibold">Publicada</dd>
                        </div>
                    </dl>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <a href="{{ route('mentor.mentorias.edit', $mentoria) }}" class="btn-secondary">
                            Editar
                        </a>
                        <form action="{{ route('mentor.mentorias.destroy', $mentoria) }}" method="POST" onsubmit="return confirm('¿Eliminar esta mentoría?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-secondary bg-rose-50 text-rose-600 border-rose-200">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </article>
            @empty
                <p class="rounded-2xl border border-dashed border-slate-200 p-6 text-center text-sm text-slate-500">
                    No tienes mentorías publicadas.
                </p>
            @endforelse
        </div>

        <div class="card space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h3 class="text-xl font-semibold text-secondary">Solicitudes recibidas</h3>
                    <p class="text-sm text-slate-500">Acepta o rechaza cada solicitud y consulta los detalles de la sesión.</p>
                </div>
                <span class="text-sm text-slate-500">{{ $stats['total'] ?? 0 }} registro(s)</span>
            </div>

            @forelse ($requests as $session)
                @php
                    $badge = $statusClasses[$session->estado] ?? 'bg-slate-100 text-slate-600';
                    $scheduleDate = $session->fecha_programada ?? $session->fecha_mentoria;
                    $scheduleTime = $session->hora_programada ?? optional($session->fecha_mentoria)?->format('H:i');
                    $amount = $session->monto ?? $session->precio;
                    $canJoinNow = $session->session_link && in_array($session->estado, ['pagada', 'confirmada', 'completada']);
                @endphp
                <article class="rounded-2xl border border-slate-100 p-5">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-sm text-slate-500">Estudiante: {{ $session->estudiante->name ?? 'No asignado' }}</p>
                            <h4 class="text-lg font-semibold text-secondary">{{ $session->titulo }}</h4>
                            <p class="text-xs text-slate-500">Especialidad: {{ $session->especialidad ?? 'Generalista' }}</p>
                            <p class="text-sm text-slate-500">
                                Solicitada {{ optional($session->fecha_solicitud)->format('d/m/Y H:i') ?? 'sin fecha' }}
                            </p>
                        </div>
                        <span class="badge {{ $badge }}">{{ ucfirst($session->estado) }}</span>
                    </div>

                    <dl class="mt-4 grid gap-4 text-sm text-slate-500 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <dt class="font-medium text-slate-600">Fecha</dt>
                            <dd>{{ optional($scheduleDate)->format('d/m/Y') ?? 'Por definir' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-600">Hora</dt>
                            <dd>{{ $scheduleTime ?? 'Por definir' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-600">Modalidad</dt>
                            <dd class="capitalize">{{ $session->modalidad }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-600">Monto</dt>
                            <dd>S/ {{ number_format($amount ?? 0, 2) }}</dd>
                        </div>
                    </dl>

                    @if ($canJoinNow && $session->jitsi_room)
                        @php
                            $displayName = urlencode(auth()->user()?->name ?? 'Mentor');
                            $subject = urlencode('SkillNest - Sesión de Mentoría');
                            $joinUrl = "{$session->jitsi_room}#userInfo.displayName={$displayName}&config.requireDisplayName=true&subject={$subject}";
                        @endphp
                        <div class="mt-4 flex flex-wrap items-center gap-3">
                            <a href="{{ $joinUrl }}" target="_blank" class="btn-primary">
                                Unirse a la sesión
                            </a>
                            {{-- TODO: habilitar el enlace solo dentro de la ventana de 10 minutos antes/después de la sesión --}}
                        </div>
                    @endif

                    <div class="mt-5 flex flex-wrap items-center gap-3">
                        <a href="{{ route('mentorias.show', $session) }}" class="btn-secondary">
                            Ver detalles
                        </a>

                        @if ($session->estado === 'pendiente')
                            <form method="POST" action="{{ route('mentor.mentorias.accept', $session) }}">
                                @csrf
                                <button type="submit" class="btn-primary bg-emerald-500 hover:bg-emerald-600 border-emerald-500 text-white">
                                    ACEPTAR
                                </button>
                            </form>
                            <form method="POST" action="{{ route('mentor.mentorias.reject', $session) }}">
                                @csrf
                                <button type="submit" class="btn-secondary bg-rose-500 hover:bg-rose-600 text-white border-rose-500">
                                    RECHAZAR
                                </button>
                            </form>
                        @endif

                        @if (in_array($session->estado, ['pagada', 'confirmada']))
                            <form method="POST" action="{{ route('mentor.mentorias.completar', $session) }}">
                                @csrf
                                <button type="submit" class="btn-primary bg-secondary border-secondary text-white">
                                    Completar sesión
                                </button>
                            </form>
                        @endif
                    </div>
                </article>
            @empty
                <p class="rounded-2xl border border-dashed border-slate-200 p-6 text-center text-sm text-slate-500">
                    Aún no tienes solicitudes de estudiantes.
                </p>
            @endforelse
        </div>
    </div>
@endsection
