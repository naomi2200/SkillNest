@extends('layouts.mentor')

@section('mentor-title', 'Mi perfil')
@section('mentor-subtitle', 'Actualiza tu información y tarifas')

@section('mentor-content')
    <div class="grid gap-6 lg:grid-cols-2">
        @php
            $profile = $user->mentorProfile;
            $skillValue = old('skills', $profile ? (is_array($profile->display_skills) ? implode(', ', $profile->display_skills) : ($profile->skills ?? '')) : '');
            $categoryValue = old('categorias', $profile->categorias ?? '');
            $experienceOptions = [
                'junior' => 'Junior (0-2 aÃ±os)',
                'mid' => 'Mid (3-6 aÃ±os)',
                'senior' => 'Senior (7+ aÃ±os)',
            ];
        @endphp
        <div class="card">
            <h2 class="text-xl font-semibold text-secondary">Información general</h2>
            <form action="{{ route('mentor.profile.update') }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="text-sm font-semibold text-secondary">Nombre completo</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-secondary">Profesión</label>
                    <input type="text" name="profesion" value="{{ old('profesion', $profile->profesion ?? '') }}" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3">
                </div>
                <div>
                    <label class="text-sm font-semibold text-secondary">Descripción</label>
                    <textarea name="descripcion" rows="4" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3">{{ old('descripcion', $profile->descripcion ?? '') }}</textarea>
                </div>
                <div>
                    <label class="text-sm font-semibold text-secondary">Habilidades (separadas por comas)</label>
                    <input type="text" name="skills" value="{{ $skillValue }}" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3">
                </div>
                <div>
                    <label class="text-sm font-semibold text-secondary">Categorías (separadas por comas)</label>
                    <input type="text" name="categorias" value="{{ $categoryValue }}" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3">
                    <p class="mt-1 text-xs text-slate-400">Usa palabras clave como “frontend”, “datos”, “ux/ui”.</p>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-secondary">Años de experiencia</label>
                        <input type="number" name="experiencia_anios" value="{{ old('experiencia_anios', $profile->experiencia_anios ?? 0) }}" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-secondary">Precio por hora (S/)</label>
                        <input type="number" step="0.1" name="precio_hora" value="{{ old('precio_hora', $profile->precio_hora ?? 0) }}" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>
                </div>
                <div>
                    <label class="text-sm font-semibold text-secondary">Nivel de experiencia</label>
                    <select name="nivel_experiencia" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3">
                        <option value="">Selecciona el nivel</option>
                        @foreach($experienceOptions as $value => $label)
                            <option value="{{ $value }}" @selected(old('nivel_experiencia', $profile->nivel_experiencia ?? '') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn-primary rounded-full px-6">Guardar cambios</button>
            </form>
        </div>

        <div class="card">
            <h2 class="text-xl font-semibold text-secondary">Consejos de visibilidad</h2>
            <p class="mt-2 text-sm text-slate-500">Describe tu nivel y categorías para que los estudiantes encuentren tu perfil en el catálogo público.</p>
        </div>
    </div>
@endsection
