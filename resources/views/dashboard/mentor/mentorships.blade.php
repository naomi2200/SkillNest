@extends('layouts.mentor')

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

    $listMentorias = $mentorias ?? collect();
    if ($listMentorias->isEmpty()) {
        $listMentorias = collect();
        if (isset($createdMentorias)) {
            $listMentorias = $listMentorias->merge($createdMentorias);
        }
        if (isset($publishedMentorias)) {
            $listMentorias = $listMentorias->merge($publishedMentorias);
        }
        $listMentorias = $listMentorias->unique('id');
    }
@endphp

@section('mentor-title', 'Mis mentorías')
@section('mentor-subtitle', 'Define tus sesiones y tarifas personalizadas')

@Push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }
    .stat-card {
        background: #fff;
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.06);
        border: 1px solid rgba(108,71,255,0.08);
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .stat-card .stat-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #6b7280;
        font-weight: 600;
    }
    .stat-card .stat-value {
        font-size: 2.2rem;
        font-weight: 800;
        background: linear-gradient(135deg, #6c47ff, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 32px;
    }
    .filter-btn {
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        background: #fff;
        color: #6b7280;
        border: 2px solid #e5e7eb;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .filter-btn.active {
        border-color: transparent;
        color: #fff;
        background: linear-gradient(135deg, #6c47ff, #8b5cf6);
    }
    .cards-grid, .requests-grid {
        display: grid;
        gap: 24px;
    }
    .item-card, .request-card {
        background: #fff;
        border-radius: 24px;
        padding: 28px;
        border: 1px solid rgba(108,71,255,0.08);
        box-shadow: 0 10px 40px rgba(0,0,0,0.06);
    }
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        gap: 24px;
    }
    .card-title {
        margin: 0 0 8px;
        font-size: 1.35rem;
        font-weight: 700;
        color: #1f2937;
    }
    .card-price {
        font-size: 1.8rem;
        font-weight: 800;
        background: linear-gradient(135deg, #6c47ff, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .info-grid {
        padding: 20px;
        border-radius: 16px;
        border: 1px solid rgba(108,71,255,0.1);
        background: linear-gradient(135deg, rgba(108,71,255,0.02), rgba(139,92,246,0.03));
        display: grid;
        gap: 16px;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        margin-bottom: 24px;
    }
    .info-item .info-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #6b7280;
        font-weight: 600;
    }
    .info-item .info-value {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1f2937;
    }
    .actions-row {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }
    .actions-row .btn {
        padding: 10px 20px;
        border-radius: 12px;
        border-width: 2px;
        border-style: solid;
        font-weight: 600;
        font-size: .9rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-primary {
        background: linear-gradient(135deg, #6c47ff, #8b5cf6);
        color: #fff;
        border-color: transparent;
    }
    .btn-secondary {
        border-color: rgba(108,71,255,0.2);
        color: #6c47ff;
        background: transparent;
    }
    .btn-outline {
        border-color: #d1d5db;
        color: #6b7280;
        background: transparent;
    }
</style>
@endpush

@section('mentor-actions')
    <a href="{{ route('mentorias.create') }}" class="btn btn-primary" style="border-radius: 999px; padding: 12px 32px;">
        ✨ Crear mentoría
    </a>
@endsection

@section('mentor-content')
    <div class="space-y-8">
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-label">Borradores</span>
                <span class="stat-value">{{ $listMentorias->where('estado', 'borrador')->count() }}</span>
            </div>
            <div class="stat-card">
                <span class="stat-label">Publicadas</span>
                <span class="stat-value">{{ $listMentorias->where('estado', 'publicada')->count() }}</span>
            </div>
            <div class="stat-card">
                <span class="stat-label">Ingresos del mes</span>
                <span class="stat-value">S/ {{ number_format($ingresosDelMes ?? 0, 0) }}</span>
            </div>
            <div class="stat-card">
                <span class="stat-label">Valoración promedio</span>
                <span class="stat-value">{{ number_format($valoracionPromedio ?? 0, 1) }}</span>
            </div>
        </div>

        <div class="filter-bar">
            <button class="filter-btn active" data-filter="todas">Todas</button>
            <button class="filter-btn" data-filter="borrador">Borradores</button>
            <button class="filter-btn" data-filter="publicada">Publicadas</button>
            <button class="filter-btn" data-filter="virtual">Virtual</button>
            <button class="filter-btn" data-filter="presencial">Presencial</button>
        </div>

        <div class="cards-grid">
            @forelse($listMentorias as $mentoria)
                <article class="item-card" data-estado="{{ $mentoria->estado }}" data-modalidad="{{ $mentoria->modalidad }}">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">{{ $mentoria->titulo }}</h3>
                            <p class="card-subtitle">
                                {{ ucfirst($mentoria->categoria) }} · {{ ucfirst($mentoria->modalidad) }}
                            </p>
                        </div>
                        <div class="card-price">S/ {{ number_format($mentoria->precio, 2) }}</div>
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Duración</span>
                            <span class="info-value">{{ $mentoria->duracion_minutos ?? $mentoria->duracion }} minutos</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Modalidad</span>
                            <span class="info-value">{{ ucfirst($mentoria->modalidad) }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                {{ $mentoria->estado === 'publicada' ? 'Sesiones' : 'Creada' }}
                            </span>
                            <span class="info-value">
                                @if($mentoria->estado === 'publicada')
                                    {{ $mentoria->sesiones_count ?? 0 }} realizadas
                                @else
                                    {{ optional($mentoria->created_at)->format('d/m/Y') }}
                                @endif
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Estado</span>
                            <span class="badge {{ $mentoria->estado === 'publicada' ? 'badge-success' : ($mentoria->estado === 'borrador' ? 'badge-warning' : 'badge-slate') }}">
                                {{ ucfirst($mentoria->estado) }}
                            </span>
                        </div>
                    </div>

                    <div class="actions-row">
                        <a href="{{ route('mentorias.edit', $mentoria) }}" class="btn btn-primary">✏️ Editar</a>

                        @if($mentoria->estado === 'borrador')
                            <form action="{{ route('mentor.mentorias.publicar', $mentoria) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-secondary">🚀 Publicar</button>
                            </form>
                        @endif

                        <a href="{{ route('mentorias.show', $mentoria) }}" class="btn btn-outline" target="_blank">👁️ {{ $mentoria->estado === 'borrador' ? 'Vista previa' : 'Ver público' }}</a>

                        @if($mentoria->estado === 'borrador')
                            <form action="{{ route('mentor.mentorias.destroy', $mentoria) }}" method="POST" onsubmit="return confirm('¿Eliminar esta mentoría?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline">🗑️ Eliminar</button>
                            </form>
                        @endif
                    </div>
                </article>
            @empty
                <div class="item-card">
                    <div class="text-center">
                        <p class="text-4xl mb-2">📚</p>
                        <h3 class="text-lg font-semibold text-secondary">No tienes mentorías creadas</h3>
                        <p class="text-sm text-slate-500 mb-4">Comienza a compartir tu experiencia creando mentorías personalizadas.</p>
                        <a href="{{ route('mentorias.create') }}" class="btn btn-primary">Crear mi primera mentoría</a>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="request-section">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h3 class="text-xl font-semibold text-secondary">Solicitudes recibidas</h3>
                </div>
                <span class="text-sm text-slate-500">{{ $stats['total'] ?? 0 }} registro(s)</span>
            </div>

            <div class="requests-grid">
                @forelse ($requests as $session)
                    @php
                        $badge = $statusClasses[$session->estado] ?? 'bg-slate-100 text-slate-600';
                        $scheduleDate = $session->fecha_programada ?? $session->fecha_mentoria;
                        $scheduleTime = $session->hora_programada ?? optional($session->fecha_mentoria)?->format('H:i');
                        $amount = $session->monto ?? $session->precio;
                        $canJoinNow = $session->session_link && in_array($session->estado, ['pagada', 'confirmada', 'completada']);
                    @endphp
                    <article class="request-card">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <p class="text-sm text-slate-500">Estudiante: {{ $session->estudiante->name ?? 'No asignado' }}</p>
                                <h4 class="text-lg font-semibold text-secondary">{{ $session->titulo }}</h4>
                                <p class="text-xs text-slate-500">Solicitada {{ optional($session->fecha_solicitud)->format('d/m/Y H:i') ?? 'sin fecha' }}</p>
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

                        <div class="actions-row" style="margin-top: 20px">
                            <a href="{{ route('mentorias.show', $session) }}" class="btn btn-secondary">Ver detalles</a>

                            @if ($session->estado === 'pendiente')
                                <form method="POST" action="{{ route('mentor.mentorias.accept', $session) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" style="background:#10b981; border-color:#10b981;">Aceptar</button>
                                </form>
                                <form method="POST" action="{{ route('mentor.mentorias.reject', $session) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline" style="color:#dc2626; border-color:#fecaca;">Rechazar</button>
                                </form>
                            @endif

                            @if (in_array($session->estado, ['pagada', 'confirmada']))
                                <form method="POST" action="{{ route('mentor.mentorias.completar', $session) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Completar sesión</button>
                                </form>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="request-card text-center text-sm text-slate-500">
                        Aún no tienes solicitudes de estudiantes.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            document.querySelectorAll('.item-card').forEach(card => {
                if (filter === 'todas') {
                    card.style.display = 'block';
                } else if (filter === 'virtual' || filter === 'presencial') {
                    card.style.display = card.dataset.modalidad === filter ? 'block' : 'none';
                } else {
                    card.style.display = card.dataset.estado === filter ? 'block' : 'none';
                }
            });
        });
    });
</script>
@endpush
