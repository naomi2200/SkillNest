@extends('layouts.student')

@section('student-title', 'Mis mentorías')
@section('student-subtitle', 'Consulta tus solicitudes y sesiones confirmadas')

@section('student-content')
    <div class="card space-y-4 overflow-x-auto">
        <table class="w-full min-w-[640px] border-separate border-spacing-y-2 text-sm">
            <thead>
                <tr class="text-left text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">
                    <th class="px-4 py-2">Tema</th>
                    <th class="px-4 py-2">Mentor</th>
                    <th class="px-4 py-2">Fecha</th>
                    <th class="px-4 py-2">Estado</th>
                    <th class="px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mentorias as $mentoria)
                    <tr class="rounded-3xl border border-slate-100 bg-white/80 shadow-card">
                        <td class="px-4 py-3 font-semibold text-secondary">{{ $mentoria->tema ?? 'Mentoría' }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $mentoria->mentor?->name }}</td>
                        <td class="px-4 py-3 text-slate-500">
                            {{ optional($mentoria->fecha_mentoria)->format('d M Y') }}
                            <br>
                            <span class="text-xs">{{ $mentoria->hora_mentoria }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                                @class([
                                    'bg-amber-100 text-amber-700' => $mentoria->estado === 'pendiente',
                                    'bg-emerald-100 text-emerald-700' => in_array($mentoria->estado, ['confirmada', 'pagada']),
                                    'bg-slate-100 text-slate-600' => ! in_array($mentoria->estado, ['pendiente', 'confirmada', 'pagada']),
                                ])">
                                {{ ucfirst($mentoria->estado) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if(in_array($mentoria->estado, ['confirmada', 'pagada']))
                                <a href="{{ $mentoria->session_link }}"
                                   target="_blank"
                                   class="btn-primary inline-flex items-center justify-center rounded-full px-4 py-2 text-xs">
                                    Unirse
                                </a>
                            @else
                                <button class="btn-secondary inline-flex cursor-not-allowed items-center justify-center rounded-full px-4 py-2 text-xs opacity-60"
                                        disabled>Esperando</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="rounded-3xl border border-dashed border-slate-200 px-4 py-6 text-center text-slate-500">
                            Aún no tienes mentorías registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
