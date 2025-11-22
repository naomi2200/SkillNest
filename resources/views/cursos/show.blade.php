@extends('layouts.app')

@section('content')
    @php
        $cover = $curso->image_url
            ? (\Illuminate\Support\Str::startsWith($curso->image_url, ['http://','https://'])
                ? $curso->image_url
                : asset($curso->image_url))
            : null;
    @endphp

    <div class="mx-auto max-w-5xl space-y-8 py-8">
        <section class="space-y-6 rounded-[32px] bg-white p-8 shadow-card">
            <p class="text-sm font-semibold uppercase tracking-[0.4em] text-slate-400">{{ $curso->category ?? 'Curso' }}</p>
            <h1 class="text-4xl font-bold text-secondary">{{ $curso->title }}</h1>
            <p class="text-lg text-slate-600">{{ $curso->description }}</p>
            <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500">
                <span>⭐ 4.8 (1234 valoraciones)</span>
                <span>👥 {{ $curso->students_count ?? 0 }} estudiantes</span>
                <span>⏱ {{ $curso->duration }} horas</span>
                <span>🌐 Español</span>
            </div>

            <div class="grid gap-6 md:grid-cols-[2fr,1fr]">
                <div class="rounded-3xl bg-slate-50 p-4">
                    @if($cover)
                        <img src="{{ $cover }}" alt="Imagen del curso" class="h-64 w-full rounded-2xl object-cover">
                    @else
                        <div class="flex h-64 w-full items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                            Sin portada
                        </div>
                    @endif
                </div>

                <aside class="rounded-3xl border border-slate-100 bg-white p-6 shadow-card">
                    <p class="text-sm uppercase tracking-[0.4em] text-slate-400">Precio</p>
                    <p class="mt-2 text-3xl font-bold text-primary">S/ {{ number_format($curso->price, 2) }}</p>
                    <div class="mt-4 flex flex-col gap-3">
                        @auth
                            @if($curso->isPurchasedBy(auth()->user()))
                                <a href="{{ route('courses.classroom', $curso) }}" class="btn-primary w-full justify-center">Ir al aula</a>
                            @else
                                <a href="{{ route('courses.checkout', $curso) }}" class="btn-primary w-full justify-center">Comprar curso</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn-primary w-full justify-center">Ingresa para inscribirte</a>
                        @endauth
                        @can('update', $curso)
                            <a href="{{ route('cursos.editor', $curso) }}" class="btn-secondary w-full justify-center">Editar curso</a>
                        @endcan
                    </div>
                    <p class="mt-6 text-xs uppercase tracking-[0.4em] text-slate-400">Este curso incluye:</p>
                    <ul class="mt-3 space-y-2 text-sm text-slate-600">
                        <li>✓ Acceso de por vida</li>
                        <li>✓ Recursos descargables</li>
                        <li>✓ Certificado de finalización</li>
                        <li>✓ Comunidad privada</li>
                    </ul>
                </aside>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            <article class="rounded-3xl border border-slate-100 bg-white p-6 shadow-card lg:col-span-2">
                <div class="border-b border-slate-100 pb-6">
                    <h2 class="text-lg font-semibold text-secondary">Lo que aprenderás</h2>
                    <ul class="mt-4 list-disc space-y-2 pl-5 text-sm text-slate-600">
                        <li>Construir proyectos completos con {{ $curso->title }}</li>
                        <li>Buenas prácticas para escalar aplicaciones</li>
                        <li>Implementar flujos de pago, autenticación y despliegue</li>
                    </ul>
                </div>

                <div class="border-b border-slate-100 py-6">
                    <h3 class="text-lg font-semibold text-secondary">Contenido del curso</h3>
                    <p class="mt-3 text-sm text-slate-500">
                        Incluye módulos teóricos, prácticas guiadas y recursos descargables para avanzar paso a paso.
                    </p>
                </div>

                <div class="pt-6">
                    <h3 class="text-lg font-semibold text-secondary">Requisitos</h3>
                    <ul class="mt-3 space-y-2 text-sm text-slate-500">
                        <li>• Conocimientos básicos de programación</li>
                        <li>• Laptop con al menos 4GB de RAM</li>
                        <li>• Muchas ganas de aprender</li>
                    </ul>
                </div>
            </article>

            <article class="rounded-3xl border border-slate-100 bg-white p-6 shadow-card">
                <h2 class="text-lg font-semibold text-secondary">Detalles</h2>
                <dl class="mt-4 space-y-4 text-sm text-slate-600">
                    <div class="flex justify-between">
                        <dt>Duración aproximada</dt>
                        <dd>{{ $curso->duration }} horas</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Mentor</dt>
                        <dd>{{ $curso->mentor->name ?? 'No asignado' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Nivel</dt>
                        <dd>{{ ucfirst($curso->level ?? 'Todos') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Estado</dt>
                        <dd class="capitalize">{{ $curso->status }}</dd>
                    </div>
                </dl>
            </article>
        </section>

        <section class="rounded-3xl border border-slate-100 bg-white p-6 shadow-card">
            <h2 class="text-lg font-semibold text-secondary">Instructor</h2>
            <div class="mt-4 flex flex-wrap items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-primary/10 text-xl font-bold text-primary">
                    {{ substr($curso->mentor->name ?? 'SN', 0, 1) }}
                </div>
                <div>
                    <p class="text-base font-semibold text-secondary">{{ $curso->mentor->name ?? 'Mentor por asignar' }}</p>
                    <p class="text-sm text-slate-500">Especialista en {{ $curso->category ?? 'la temática del curso' }}</p>
                </div>
            </div>
        </section>
    </div>
@endsection
