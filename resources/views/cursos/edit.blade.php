@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">
        <div>
            <p class="text-sm uppercase tracking-wide text-slate-400">Cursos</p>
            <h1 class="text-3xl font-bold text-secondary">Editar curso</h1>
            <p class="text-sm text-slate-500">Actualiza la información del curso.</p>
        </div>

        <div class="card">
            <form action="{{ route('cursos.update', $curso) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-slate-600" for="title">Título</label>
                        <input id="title" name="title" value="{{ old('title', $curso->title) }}" required
                               class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-600" for="category">Categoría</label>
                        <input id="category" name="category" value="{{ old('category', $curso->category) }}" required
                               class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-slate-600" for="description">Descripción</label>
                    <textarea id="description" name="description" rows="4" required
                              class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">{{ old('description', $curso->description) }}</textarea>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="text-sm font-medium text-slate-600" for="price">Precio</label>
                        <input id="price" name="price" type="number" step="0.01" value="{{ old('price', $curso->price) }}" required
                               class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-600" for="duration">Duración (hrs)</label>
                        <input id="duration" name="duration" type="number" value="{{ old('duration', $curso->duration) }}" required
                               class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-600" for="status">Estado</label>
                        <select id="status" name="status" class="mt-1 w-full rounded-lg border-slate-200 focus:border-primary focus:ring-primary">
                            <option value="draft" @selected($curso->status === 'draft')>Borrador</option>
                            <option value="published" @selected($curso->status === 'published')>Publicado</option>
                            <option value="archived" @selected($curso->status === 'archived')>Archivado</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('cursos.index') }}" class="btn-secondary">Cancelar</a>
                    <button class="btn-primary">Actualizar curso</button>
                </div>
            </form>
        </div>
    </div>
@endsection
