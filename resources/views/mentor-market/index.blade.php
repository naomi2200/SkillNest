@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('content')
    <div class="mx-auto max-w-6xl space-y-8">
        <header class="space-y-2 text-center">
            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Mentorías verificadas</p>
            <h1 class="text-4xl font-semibold text-secondary">Encuentra tu próxima mentoría</h1>
            <p class="text-slate-500">Filtra por especialidad, experiencia y modalidad para elegir la sesión ideal.</p>
        </header>

        <section class="rounded-[32px] border border-slate-100 bg-white/90 p-6 shadow-card">
            <form method="GET" class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Categoría</label>
                    <select name="categoria" class="form-input mt-2">
                        <option value="">Todas</option>
                        @foreach($categories as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['categoria'] ?? '') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Experiencia</label>
                    <select name="nivel" class="form-input mt-2">
                        <option value="">Cualquier nivel</option>
                        @foreach($experienceLevels as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['nivel'] ?? '') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Modalidad</label>
                    <select name="modalidad" class="form-input mt-2">
                        <option value="">Todas</option>
                        @foreach($modalities as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['modalidad'] ?? '') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Precio mínimo</label>
                    <input type="number" name="precio_min" step="5" min="0" class="form-input mt-2"
                           value="{{ $filters['precio_min'] ?? '' }}" placeholder="S/">
                </div>
                <div>
                    <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Precio máximo</label>
                    <input type="number" name="precio_max" step="5" min="0" class="form-input mt-2"
                           value="{{ $filters['precio_max'] ?? '' }}" placeholder="S/">
                </div>
                <div class="md:col-span-2 lg:col-span-4 flex flex-wrap gap-3">
                    <button class="btn-gradient">Aplicar filtros</button>
                    <a href="{{ route('mentor-market.index') }}" class="btn-secondary">Limpiar</a>
                </div>
            </form>
        </section>

        <section class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($publicMentorias as $mentoria)
                @php
                    $mentorUser = $mentoria->mentor;
                    $mentorProfile = $mentorUser?->mentorProfile;
                    $price = $mentoria->monto ?? $mentoria->precio;
                @endphp
                <article class="flex h-full flex-col rounded-[30px] border border-slate-100 bg-white/95 p-6 shadow-card">
                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary/10 text-xl font-semibold text-primary">
                            {{ strtoupper(Str::substr($mentorUser->name ?? 'S', 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-secondary">{{ $mentorUser->name ?? 'Mentor SkillNest' }}</h2>
                            <p class="text-sm text-slate-500">Mentor verificado</p>
                        </div>
                    </div>

                    <div class="mt-4 grid gap-2 text-sm text-slate-600">
                        <p>
                            <strong class="text-secondary">Especialidad:</strong>
                            {{ $mentorProfile->profesion ?? $mentoria->especialidad ?? 'Generalista' }}
                        </p>
                        @if($mentorProfile?->nivel_experiencia)
                            <p>
                                <strong class="text-secondary">Nivel:</strong>
                                {{ $experienceLevels[$mentorProfile->nivel_experiencia] ?? ucfirst($mentorProfile->nivel_experiencia) }}
                            </p>
                        @endif
                        @if($mentorProfile?->categorias)
                            <p>
                                <strong class="text-secondary">Categorias:</strong>
                                {{ $mentorProfile->categorias }}
                            </p>
                        @endif
                        <p><strong class="text-secondary">Precio:</strong> S/ {{ number_format($price ?? 0, 2) }}</p>
                        <p><strong class="text-secondary">Duración:</strong> {{ $mentoria->duracion_minutos }} min</p>
                        <p><strong class="text-secondary">Modalidad:</strong> {{ ucfirst($mentoria->modalidad) }}</p>
                    </div>

                    <div class="mt-6 flex gap-3">
                        @if($mentorUser)
                            <a href="{{ route('mentor.public.show', $mentorUser->id) }}" class="btn-primary flex-1 justify-center">
                                Ver perfil
                            </a>
                            <a href="{{ route('mentor.book.form', $mentorUser->id) }}" class="btn-secondary flex-1 justify-center">
                                Agendar mentoría
                            </a>
                        @else
                            <span class="text-xs text-slate-400">Mentor no disponible</span>
                        @endif
                    </div>
                </article>
            @empty
                <div class="md:col-span-2 lg:col-span-3 rounded-[30px] border border-dashed border-slate-200 p-12 text-center text-slate-500">
                    No encontramos mentorías con esos filtros. Ajusta los criterios e inténtalo de nuevo.
                </div>
            @endforelse
        </section>

    </div>
@endsection
