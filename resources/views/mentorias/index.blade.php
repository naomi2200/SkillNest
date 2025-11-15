@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-6xl space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-wide text-slate-400">Mentorías</p>
                <h1 class="text-3xl font-bold text-secondary">Agenda una sesión personalizada</h1>
                <p class="text-sm text-slate-500">Encuentra al mentor ideal según tu necesidad.</p>
            </div>
            @can('create', App\Models\Mentoria::class)
                <a href="{{ route('mentorias.create') }}" class="btn-primary">Ofrecer mentoría</a>
            @endcan
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            @forelse($mentorias as $mentoria)
                <article class="card">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-secondary">{{ $mentoria->titulo }}</h2>
                            <p class="text-sm text-slate-500">{{ $mentoria->mentor->name ?? 'Mentor no asignado' }}</p>
                        </div>
                        <span class="badge bg-primary/10 text-primary">S/ {{ number_format($mentoria->precio, 2) }}</span>
                    </div>
                    <p class="mt-4 text-sm text-slate-600">{{ Str::limit($mentoria->descripcion, 160) }}</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('mentorias.show', $mentoria) }}" class="btn-primary">Ver detalles</a>
                        @auth
                            <a href="{{ route('student.mentorias') }}" class="btn-secondary">Agendar</a>
                        @endauth
                    </div>
                </article>
            @empty
                <p class="col-span-2 rounded-2xl border border-dashed border-slate-200 p-6 text-center text-sm text-slate-500">
                    No hay mentorías disponibles por ahora.
                </p>
            @endforelse
        </div>
    </div>
@endsection
