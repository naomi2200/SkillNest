@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-xl space-y-6">
        <div>
            <p class="text-sm uppercase tracking-wide text-slate-400">Inscripción</p>
            <h1 class="text-3xl font-bold text-secondary">Confirmar inscripción</h1>
            <p class="text-sm text-slate-500">Curso: {{ $curso->title }}</p>
        </div>

        <div class="card space-y-4">
            <p class="text-sm text-slate-600">
                Al confirmar la inscripción tendrás acceso inmediato al contenido del curso y podrás registrar tu progreso.
            </p>

            <form action="{{ route('cursos.enroll', $curso) }}" method="POST" class="flex flex-col gap-4">
                @csrf
                <button class="btn-primary w-full">Confirmar inscripción</button>
                <a href="{{ route('cursos.show', $curso) }}" class="text-center text-sm font-semibold text-slate-500 hover:text-secondary">
                    Cancelar
                </a>
            </form>
        </div>
    </div>
@endsection
