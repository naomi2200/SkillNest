@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">
        <div>
            <p class="text-sm uppercase tracking-wide text-slate-400">Mentorías</p>
            <h1 class="text-3xl font-bold text-secondary">Editar mentoría</h1>
            <p class="text-sm text-slate-500">Actualiza los datos de tu servicio.</p>
        </div>

        <div class="card">
            <form action="{{ route('mentorias.update', $mentoria) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm font-medium text-slate-600" for="titulo">Título</label>
                    <input id="titulo" name="titulo" value="{{ old('titulo', $mentoria->titulo) }}" required
                           class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-slate-600" for="modalidad">Modalidad</label>
                        <select id="modalidad" name="modalidad" class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                            <option value="virtual" @selected($mentoria->modalidad === 'virtual')>Virtual</option>
                            <option value="presencial" @selected($mentoria->modalidad === 'presencial')>Presencial</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-600" for="precio">Precio</label>
                        <input id="precio" name="precio" type="number" step="0.01" value="{{ old('precio', $mentoria->precio) }}" required
                               class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-slate-600" for="duracion_minutos">Duración (minutos)</label>
                        <input id="duracion_minutos" name="duracion_minutos" type="number" value="{{ old('duracion_minutos', $mentoria->duracion_minutos) }}" required
                               class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-600" for="fecha_mentoria">Fecha de mentoría</label>
                        <input id="fecha_mentoria" name="fecha_mentoria" type="datetime-local"
                               value="{{ old('fecha_mentoria', optional($mentoria->fecha_mentoria)->format('Y-m-d\TH:i')) }}"
                               class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-slate-600" for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="4" required
                              class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">{{ old('descripcion', $mentoria->descripcion) }}</textarea>
                </div>

                <div class="flex items-center gap-2">
                    <input id="estado_confirmada" name="estado" type="checkbox" value="confirmada"
                           class="rounded border-slate-300 text-primary focus:ring-primary" @checked($mentoria->estado === 'confirmada')>
                    <label for="estado_confirmada" class="text-sm text-slate-600">Marcar como confirmada</label>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('mentorias.index') }}" class="btn-secondary">Cancelar</a>
                    <button class="btn-primary">Actualizar mentoría</button>
                </div>
            </form>
        </div>
    </div>
@endsection
