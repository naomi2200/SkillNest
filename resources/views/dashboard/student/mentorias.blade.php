@extends('layouts.dashboard')

@section('dashboard-title', 'Mis mentorias')

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

@section('dashboard-content')
    <div class="card">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-secondary">Sesiones agendadas</h2>
                <p class="text-sm text-slate-500">Revisa tus proximas mentorias y sus detalles.</p>
            </div>
            <a href="{{ route('mentor-market.index') }}" class="btn-secondary">Explorar mentores</a>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead>
                <tr class="text-left text-xs uppercase tracking-wide text-slate-400">
                    <th class="px-4 py-3">Tema</th>
                    <th class="px-4 py-3">Mentor</th>
                    <th class="px-4 py-3">Especialidad</th>
                    <th class="px-4 py-3">Fecha programada</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @forelse($mentorias as $mentoria)
                    @php
                        $badge = $statusClasses[$mentoria->estado] ?? 'bg-slate-100 text-slate-600';
                        $scheduleDate = $mentoria->fecha_programada ?? $mentoria->fecha_mentoria;
                    @endphp
                    <tr class="text-slate-600">
                        <td class="px-4 py-4 font-medium text-secondary">{{ $mentoria->titulo }}</td>
                        <td class="px-4 py-4">{{ $mentoria->mentor->name ?? 'Por asignar' }}</td>
                        <td class="px-4 py-4">{{ $mentoria->especialidad ?? 'General' }}</td>
                        <td class="px-4 py-4">{{ optional($scheduleDate)->format('d/m/Y H:i') ?? 'Por definir' }}</td>
                        <td class="px-4 py-4">
                            <span class="badge {{ $badge }} capitalize">{{ $mentoria->estado }}</span>
                        </td>
                        @php
                            $displayName = urlencode(auth()->user()?->name ?? 'Invitado');
                            $subject = urlencode('SkillNest - Sesión de Mentoría');
                            $joinUrl = $mentoria->jitsi_room
                                ? "{$mentoria->jitsi_room}#userInfo.displayName={$displayName}&config.requireDisplayName=true&subject={$subject}"
                                : null;
                        @endphp
                        <td class="px-4 py-4 space-y-1">
                            @if($mentoria->estado === 'aceptada' && $mentoria->payment_status === 'pending')
                                <a href="{{ route('payments.show', $mentoria->id) }}" class="btn-primary">
                                    Pagar mentoría
                                </a>
                            @endif

                            @if($mentoria->estado === 'pagada' && $joinUrl)
                                <a href="{{ $joinUrl }}" target="_blank" class="btn-success">
                                    Unirse a la sesión
                                </a>
                            @endif

                            @if($mentoria->estado === 'completada')
                                <span class="text-green-600 font-semibold text-xs">Sesión completada</span>
                            @endif

                            @if($mentoria->estado === 'pendiente')
                                <span class="text-xs text-slate-400">Esperando la aprobación del mentor</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-slate-500">
                            No tienes mentorías registradas todavía.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
