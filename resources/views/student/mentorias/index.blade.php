@extends('layouts.student')

@php
    $newSessionUrl = Route::has('student.mentorias.create')
        ? route('student.mentorias.create')
        : '#';

    $mentorsCards = [
        [
            'name' => 'Ana García',
            'role' => 'Full Stack Developer',
            'rate' => '$45/h',
            'experience' => '5+ años',
            'emoji' => '👩‍💻',
        ],
        [
            'name' => 'Carlos Ruiz',
            'role' => 'UX/UI Designer',
            'rate' => '$40/h',
            'experience' => '7+ años',
            'emoji' => '👨‍🎨',
        ],
        [
            'name' => 'Laura Martínez',
            'role' => 'Data Scientist',
            'rate' => '$50/h',
            'experience' => '6+ años',
            'emoji' => '👩‍💼',
        ],
    ];
@endphp

@section('student-title', 'Mis mentorías')
@section('student-subtitle', 'Explora y gestiona todo tu ecosistema SkillNest')

@push('styles')
    <style>
        .mentorias-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 16px 18px;
            background: #fff;
            border: 1px solid rgba(124,58,237,0.12);
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(124,58,237,0.08);
        }
        .pill-group {
            display: inline-flex;
            gap: 8px;
            background: #f8fafc;
            padding: 6px;
            border-radius: 14px;
        }
        .pill {
            border: none;
            background: transparent;
            padding: 10px 14px;
            border-radius: 10px;
            font-weight: 700;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .pill:hover { color: #4b5563; }
        .pill.active {
            background: linear-gradient(135deg, #7c3aed, #8b5cf6);
            color: #fff;
            box-shadow: 0 10px 25px rgba(124,58,237,0.18);
        }
        .btn-gradient {
            background: linear-gradient(135deg, #7c3aed, #8b5cf6);
            color: #fff;
            padding: 12px 18px;
            border-radius: 12px;
            font-weight: 800;
            border: none;
            box-shadow: 0 10px 25px rgba(124,58,237,0.18);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-gradient[aria-disabled="true"] { opacity: 0.6; cursor: not-allowed; }

        .mentor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
            margin-top: 12px;
        }
        .mentor-card {
            background: #fff;
            border: 1px solid rgba(124,58,237,0.1);
            border-radius: 20px;
            padding: 18px;
            box-shadow: 0 12px 28px rgba(124,58,237,0.08);
            text-align: center;
        }
        .mentor-card h3 { margin: 8px 0 4px; font-weight: 800; color: #1f2937; }
        .mentor-card p { margin: 0; color: #6b7280; }
        .mentor-meta {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin: 12px 0;
            color: #4b5563;
            font-weight: 700;
            font-size: 13px;
        }
        .mentor-action {
            background: linear-gradient(135deg, #7c3aed, #8b5cf6);
            color: #fff;
            padding: 10px 14px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 10px 25px rgba(124,58,237,0.18);
        }
    </style>
@endpush

@section('student-content')
    <div class="mentorias-bar">
        <div class="pill-group">
            <button class="pill active" type="button">Todas</button>
            <button class="pill" type="button">Confirmadas</button>
            <button class="pill" type="button">Pendientes</button>
        </div>
        <a href="{{ $newSessionUrl }}" class="btn-gradient" aria-disabled="{{ $newSessionUrl === '#' ? 'true' : 'false' }}">
            Nueva Sesión
        </a>
    </div>

    <div class="content-card" style="margin-top:18px;">
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
                                   class="btn-gradient inline-flex items-center justify-center px-4 py-2 text-xs"
                                   style="box-shadow:none;">
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

    <div class="content-card" style="margin-top:22px;">
        <h2 style="font-size:22px; font-weight:900; color:#1f2937; margin-bottom:4px;">Busca un Mentor</h2>
        <p style="color:#6b7280; margin-bottom:12px;">Encuentra al mentor ideal y agenda tu próxima sesión.</p>
        <div class="mentor-grid">
            @foreach($mentorsCards as $mentor)
                <div class="mentor-card">
                    <div style="font-size:28px;">{{ $mentor['emoji'] }}</div>
                    <h3>{{ $mentor['name'] }}</h3>
                    <p>{{ $mentor['role'] }}</p>
                    <div class="mentor-meta">
                        <span>Tarifa {{ $mentor['rate'] }}</span>
                        <span>Exp. {{ $mentor['experience'] }}</span>
                    </div>
                    <a href="{{ $newSessionUrl }}" class="mentor-action" aria-disabled="{{ $newSessionUrl === '#' ? 'true' : 'false' }}">Contactar</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
