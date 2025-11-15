@extends('layouts.app')

@php
    use Illuminate\Support\Str;

    $profile = $mentor->mentorProfile;
    $price = $mentoria->precio ?? 0;
    $duration = $mentoria->duracion_minutos ?? 60;
    $modalidad = $mentoria->modalidad ? ucfirst($mentoria->modalidad) : 'Modalidad no definida';

    // Comisión que la plataforma retiene DEL MENTOR (no del estudiante)
    $serviceFee = round($price * 0.05, 2);

    // El estudiante paga solo el precio base
    $total = $price;
@endphp

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">
        <a href="{{ route('mentor.public.show', $mentor) }}" class="inline-flex items-center text-sm font-semibold text-secondary hover:underline">
            ← Volver al perfil
        </a>

        <div class="rounded-[32px] border border-slate-100 bg-white/95 p-8 shadow-card">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-primary/10 text-2xl font-bold text-primary">
                    {{ strtoupper(Str::substr($mentor->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Agendar mentoría</p>
                    <h1 class="text-3xl font-semibold text-secondary">{{ $mentor->name }}</h1>
                    <p class="text-sm text-slate-500">{{ $mentoria->especialidad ?? ($profile->profesion ?? 'Generalista') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-slate-500">{{ $modalidad }}</p>
                    <p class="text-2xl font-semibold text-secondary">S/ {{ number_format($price, 2) }}</p>
                    <p class="text-xs text-slate-400">{{ $duration }} min</p>
                </div>
            </div>

            <div class="mt-6 grid gap-6 lg:grid-cols-2">
                <section class="space-y-4">
                    <h2 class="text-lg font-semibold text-secondary">Ingresa tus datos</h2>

                    @if(!auth()->check())
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4">
                            <p class="text-sm text-slate-600">Inicia sesión como estudiante para reservar una sesión.</p>
                            <a href="{{ route('login') }}" class="btn-primary mt-3 inline-flex items-center justify-center">Iniciar sesión</a>
                        </div>
                    @elseif(!auth()->user()->isStudent())
                        <div class="rounded-2xl border border-dashed border-slate-200 p-4 text-sm text-slate-600">
                            Solo los estudiantes pueden reservar mentorías.
                        </div>
                    @else
                        <form method="POST" action="{{ route('mentor-market.book', $mentor) }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="form-label">Fecha</label>
                                <input type="date" name="date" class="form-input" min="{{ now()->toDateString() }}" required>
                            </div>
                            <div>
                                <label class="form-label">Hora</label>
                                <input type="time" name="time" class="form-input" required>
                            </div>
                            <div>
                                <label class="form-label">Objetivos de la sesión (opcional)</label>
                                <textarea name="notes" class="form-input" rows="4" placeholder="Comparte tus objetivos o contexto para que el mentor se prepare."></textarea>
                            </div>
                            <button class="btn-gradient w-full justify-center">Enviar solicitud</button>
                        </form>
                    @endif
                </section>

                <aside class="rounded-2xl border border-slate-100 bg-slate-50/70 p-5 text-sm text-slate-600">
                    <h3 class="text-base font-semibold text-secondary">Resumen de la sesión</h3>
                    <dl class="mt-4 space-y-3">
                        <div class="flex justify-between">
                            <dt>Precio por sesión</dt>
                            <dd class="font-semibold text-secondary">S/ {{ number_format($price, 2) }}</dd>
                        </div>

                        <div class="flex justify-between">
                            <dt>Servicio SkillNest (5%)</dt>
                            <dd class="font-semibold text-red-500">- S/ {{ number_format($serviceFee, 2) }}</dd>
                        </div>

                        <div class="flex justify-between">
                            <dt>Duración</dt>
                            <dd class="font-semibold text-secondary">{{ $duration }} minutos</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Modalidad</dt>
                            <dd class="font-semibold text-secondary">{{ $modalidad }}</dd>
                        </div>

                        <div class="flex justify-between text-base font-semibold text-secondary">
                            <dt>Total estimado</dt>
                            <dd>S/ {{ number_format($total, 2) }}</dd>
                        </div>
                    </dl>

                    <p class="mt-4 text-xs text-slate-400">
                        El estudiante no paga comisiones adicionales.  
                        SkillNest retiene su comisión directamente del pago del mentor.
                    </p>
                </aside>
            </div>
        </div>
    </div>
@endsection
