@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">
        <div>
            <p class="text-sm uppercase tracking-wide text-slate-400">Mentorías</p>
            <h1 class="text-3xl font-bold text-secondary">Ofrecer nueva mentoría</h1>
            <p class="text-sm text-slate-500">Define los detalles de tu sesión personalizada.</p>
        </div>

        <div class="card">
            <form action="{{ route('mentorias.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="text-sm font-medium text-slate-600" for="titulo">Título</label>
                    <input id="titulo" name="titulo" value="{{ old('titulo') }}" required
                           class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-600" for="especialidad">Especialidad</label>
                    <input id="especialidad" name="especialidad" type="text" value="{{ old('especialidad') }}" required
                           class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary"
                           placeholder="Ej: Matemáticas, Backend, Inglés">
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-slate-600" for="modalidad">Modalidad</label>
                        <select id="modalidad" name="modalidad" class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                            <option value="virtual">Virtual</option>
                            <option value="presencial">Presencial</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-600" for="precio">Precio</label>
                        <input id="precio" name="precio" type="number" step="0.01" value="{{ old('precio') }}" required
                               class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-slate-600" for="duracion_minutos">Duración (minutos)</label>
                    <input id="duracion_minutos" name="duracion_minutos" type="number" value="{{ old('duracion_minutos', 60) }}" required
                           class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                </div>

                <div>
                    <label class="text-sm font-medium text-slate-600" for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="4" required
                              class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">{{ old('descripcion') }}</textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('mentorias.index') }}" class="btn-secondary">Cancelar</a>
                    <button class="btn-primary">Guardar mentoría</button>
                </div>
            </form>
        </div>
    </div>
@endsection
