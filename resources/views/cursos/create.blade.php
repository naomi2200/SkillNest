@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">
        <div>
            <p class="text-sm uppercase tracking-wide text-slate-400">Cursos</p>
            <h1 class="text-3xl font-bold text-secondary">Crear curso</h1>
            <p class="text-sm text-slate-500">Comparte tu conocimiento con la comunidad.</p>
        </div>

        <div class="card">
            <form action="{{ route('cursos.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-slate-600" for="title">Título</label>
                        <input id="title" name="title" value="{{ old('title') }}" required
                               class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-600" for="category">Categoría</label>
                        <input id="category" name="category" value="{{ old('category') }}" required
                               class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-slate-600" for="description">Descripción</label>
                    <textarea id="description" name="description" rows="4" required
                              class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">{{ old('description') }}</textarea>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="text-sm font-medium text-slate-600" for="price">Precio</label>
                        <input id="price" name="price" type="number" step="0.01" value="{{ old('price') }}" required
                               class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-600" for="duration">Duración (hrs)</label>
                        <input id="duration" name="duration" type="number" value="{{ old('duration') }}" required
                               class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-600" for="level">Nivel</label>
                        <select id="level" name="level" class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                            <option value="principiante">Principiante</option>
                            <option value="intermedio">Intermedio</option>
                            <option value="avanzado">Avanzado</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('cursos.index') }}" class="btn-secondary">Cancelar</a>
                    <button class="btn-primary">Guardar curso</button>
                </div>
            </form>
        </div>
    </div>
@endsection
