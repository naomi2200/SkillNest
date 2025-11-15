@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-4xl space-y-8">
        <div class="rounded-3xl bg-white p-8 shadow-card">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-wide text-slate-400">Mentoría</p>
                    <h1 class="text-4xl font-bold text-secondary">{{ $mentoria->titulo }}</h1>
                    <p class="mt-2 text-sm text-slate-500">{{ $mentoria->mentor->name ?? 'Mentor por asignar' }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm uppercase tracking-wide text-slate-400">Tarifa</p>
                    <p class="text-3xl font-bold text-primary">S/ {{ number_format($mentoria->precio, 2) }}</p>
                </div>
            </div>
            <p class="mt-6 text-slate-600">{{ $mentoria->descripcion }}</p>

            <div class="mt-8 flex flex-wrap gap-3">
                @auth
                    <a href="{{ route('student.mentorias') }}" class="btn-primary">Agendar sesión</a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary">Ingresa para agendar</a>
                @endauth
                @can('update', $mentoria)
                    <a href="{{ route('mentorias.edit', $mentoria) }}" class="btn-secondary">Editar mentoría</a>
                @endcan
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="card">
                <h2 class="text-lg font-semibold text-secondary">Modalidad</h2>
                <p class="mt-4 text-sm text-slate-500">{{ ucfirst($mentoria->modalidad) }}</p>
            </div>
            <div class="card">
                <h2 class="text-lg font-semibold text-secondary">Duración</h2>
                <p class="mt-4 text-sm text-slate-500">{{ $mentoria->duracion_minutos }} minutos</p>
            </div>
        </div>
    </div>
@endsection
