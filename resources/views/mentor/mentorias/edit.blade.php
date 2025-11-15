@extends('layouts.mentor')

@section('mentor-title', 'Editar mentoría')
@section('mentor-subtitle', 'Actualiza los detalles de tu sesión')

@section('mentor-content')
    <div class="card">
        <form action="{{ route('mentor.mentorias.update', $mentoria) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-secondary">Título</label>
                    <input type="text" name="titulo" value="{{ old('titulo', $mentoria->titulo) }}"
                           class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-secondary">Especialidad</label>
                    <input type="text" name="especialidad" value="{{ old('especialidad', $mentoria->especialidad) }}"
                           class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3">
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-secondary">Precio (S/)</label>
                    <input type="number" step="0.01" min="0" name="precio" value="{{ old('precio', $mentoria->precio) }}"
                           class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-secondary">Duración (minutos)</label>
                    <input type="number" min="1" name="duracion_minutos" value="{{ old('duracion_minutos', $mentoria->duracion_minutos) }}"
                           class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3" required>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-secondary">Modalidad</label>
                    <select name="modalidad" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3" required>
                        <option value="virtual" @selected(old('modalidad', $mentoria->modalidad) === 'virtual')>Virtual</option>
                        <option value="presencial" @selected(old('modalidad', $mentoria->modalidad) === 'presencial')>Presencial</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold text-secondary">Objetivos</label>
                    <textarea name="objetivos" rows="3" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3">{{ old('objetivos', $mentoria->objetivos) }}</textarea>
                </div>
            </div>

            <div>
                <label class="text-sm font-semibold text-secondary">Descripción</label>
                <textarea name="descripcion" rows="5" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3" required>{{ old('descripcion', $mentoria->descripcion) }}</textarea>
            </div>

            <div class="flex flex-wrap justify-end gap-3">
                <a href="{{ route('mentor.mentorias.index') }}" class="btn-secondary">Cancelar</a>
                <button class="btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
@endsection
