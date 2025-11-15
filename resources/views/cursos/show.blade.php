@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-5xl space-y-8">
        <div class="rounded-3xl bg-white p-8 shadow-card">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-wide text-slate-400">Curso</p>
                    <h1 class="text-4xl font-bold text-secondary">{{ $curso->title }}</h1>
                    <p class="mt-2 text-sm text-slate-500">{{ $curso->category }} · {{ ucfirst($curso->level) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm uppercase tracking-wide text-slate-400">Precio</p>
                    <p class="text-3xl font-bold text-primary">S/ {{ number_format($curso->price, 2) }}</p>
                </div>
            </div>
            <p class="mt-6 text-slate-600">{{ $curso->description }}</p>

            <div class="mt-8 flex flex-wrap gap-3">
                @auth
                    <form action="{{ route('cursos.enroll', $curso) }}" method="POST">
                        @csrf
                        <button class="btn-primary">Inscribirme</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-primary">Ingresa para inscribirte</a>
                @endauth
                @can('update', $curso)
                    <a href="{{ route('cursos.edit', $curso) }}" class="btn-secondary">Editar curso</a>
                @endcan
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="card">
                <h2 class="text-lg font-semibold text-secondary">Detalles</h2>
                <dl class="mt-4 space-y-3 text-sm text-slate-500">
                    <div class="flex justify-between">
                        <dt>Duración aproximada</dt>
                        <dd>{{ $curso->duration }} horas</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Mentor</dt>
                        <dd>{{ $curso->mentor->name ?? 'No asignado' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Estado</dt>
                        <dd class="capitalize">{{ $curso->status }}</dd>
                    </div>
                </dl>
            </div>

            <div class="card">
                <h2 class="text-lg font-semibold text-secondary">Requisitos</h2>
                <p class="mt-4 text-sm text-slate-500">
                    Añade aquí los requisitos o materiales que los estudiantes deben considerar antes de inscribirse.
                </p>
            </div>
        </div>
    </div>
@endsection
