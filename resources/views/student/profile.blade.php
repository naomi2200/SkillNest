@extends('layouts.student')

@section('student-title', 'Mi perfil')
@section('student-subtitle', 'Actualiza tus datos personales para mantener tu experiencia personalizada')

@section('student-content')
    @php
        $avatar = $user->avatar_url
            ? (\Illuminate\Support\Str::startsWith($user->avatar_url, ['http://','https://'])
                ? $user->avatar_url
                : asset($user->avatar_url))
            : 'https://ui-avatars.com/api/?name='.urlencode($user->name ?? 'SkillNest').'&background=6366f1&color=fff';
    @endphp

    <div class="space-y-6">
        <section class="rounded-[32px] bg-gradient-to-r from-indigo-500 via-sky-500 to-cyan-400 p-[1px] shadow-2xl">
            <div class="rounded-[28px] bg-white/95 px-8 py-6 backdrop-blur">
                <div class="flex flex-wrap items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <img src="{{ $avatar }}" alt="Avatar" class="h-16 w-16 rounded-3xl object-cover shadow-lg">
                        <div>
                            <p class="text-xs uppercase tracking-[0.5em] text-slate-400">Hola, {{ $user->name ?? 'estudiante' }}</p>
                            <h1 class="text-3xl font-semibold text-secondary">Mi perfil</h1>
                            <p class="text-sm text-slate-500">Personaliza tu experiencia y mantén tu cuenta al día.</p>
                        </div>
                    </div>
                    <label for="avatar-input" class="cursor-pointer rounded-full border border-slate-200 px-5 py-2 text-sm font-semibold text-slate-600 transition hover:border-primary hover:text-primary">
                        Cambiar foto
                    </label>
                </div>
                <div class="mt-6 grid gap-4 md:grid-cols-3">
                    <div class="rounded-2xl border border-slate-100 bg-white px-4 py-3 shadow-inner">
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Cursos activos</p>
                        <p class="mt-1 text-2xl font-bold text-secondary">{{ $user->cursosInscritos?->count() ?? 0 }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-100 bg-white px-4 py-3 shadow-inner">
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Mentorías reservadas</p>
                        <p class="mt-1 text-2xl font-bold text-secondary">{{ $user->mentoriasComoEstudiante?->count() ?? 0 }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-100 bg-white px-4 py-3 shadow-inner">
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Nivel de experiencia</p>
                        <p class="mt-1 text-2xl font-bold text-secondary">{{ ucfirst($user->profile_level ?? 'principiante') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" class="grid gap-6 md:grid-cols-2">
            @csrf
            @method('PUT')
            <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*">

            <div class="rounded-[28px] border border-slate-100 bg-white/90 p-6 shadow-card space-y-4">
                <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Información principal</p>
                <div class="space-y-4 text-sm text-slate-600">
                    <label class="block">
                        <span class="text-xs uppercase tracking-[0.3em] text-slate-400">Nombre completo</span>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" required>
                    </label>
                    <label class="block">
                        <span class="text-xs uppercase tracking-[0.3em] text-slate-400">Correo electrónico</span>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" required>
                    </label>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block">
                            <span class="text-xs uppercase tracking-[0.3em] text-slate-400">Zona horaria</span>
                            <input type="text" name="timezone" value="{{ old('timezone', $user->timezone) }}" class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" placeholder="Ej: America/Lima">
                        </label>
                        <label class="block">
                            <span class="text-xs uppercase tracking-[0.3em] text-slate-400">Notificaciones</span>
                            <select name="notification_channel" class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm">
                                <option value="email" @selected(old('notification_channel', $user->notification_channel ?? 'email') === 'email')>Email</option>
                                <option value="push" @selected(old('notification_channel', $user->notification_channel ?? 'email') === 'push')>Push</option>
                            </select>
                        </label>
                    </div>
                    <label class="block">
                        <span class="text-xs uppercase tracking-[0.3em] text-slate-400">Nivel de experiencia</span>
                        <select name="profile_level" class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm">
                            @foreach(['principiante','intermedio','avanzado'] as $level)
                                <option value="{{ $level }}" @selected(old('profile_level', $user->profile_level ?? 'principiante') === $level)>{{ ucfirst($level) }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </div>

            <div class="rounded-[28px] border border-slate-100 bg-white/90 p-6 shadow-card space-y-4">
                <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Preferencias</p>
                <div class="space-y-3">
                    <div class="flex items-center justify-between rounded-2xl border border-slate-100 px-4 py-3">
                        <div>
                            <p class="text-sm font-semibold text-secondary">Resúmenes semanales</p>
                            <p class="text-xs text-slate-400">Recibe tips y avances en tu correo.</p>
                        </div>
                        <span class="rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary">Próximamente</span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl border border-slate-100 px-4 py-3">
                        <div>
                            <p class="text-sm font-semibold text-secondary">Recordatorios de mentorías</p>
                            <p class="text-xs text-slate-400">Activa alertas 24h antes de cada sesión.</p>
                        </div>
                        <span class="rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary">Próximamente</span>
                    </div>
                </div>

                <div class="rounded-2xl border border-dashed border-slate-200 px-4 py-5 text-center text-sm text-slate-500">
                    Próximamente podrás conectar tus redes profesionales y recibir recomendaciones personalizadas.
                </div>
            </div>

            <div class="md:col-span-2 flex justify-end">
                <button type="submit" class="btn-primary rounded-full px-8 py-3">Guardar cambios</button>
            </div>
        </form>

        <section class="rounded-[28px] border border-slate-100 bg-white/90 p-6 shadow-card">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Actividad reciente</p>
                    <h2 class="text-lg font-semibold text-secondary">Tu evolución en SkillNest</h2>
                </div>
                <span class="rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-500">Modo vista previa</span>
            </div>
            <div class="mt-5 space-y-3">
                <div class="flex items-center gap-3 rounded-2xl border border-slate-100 px-4 py-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3"/>
                        </svg>
                    </span>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-secondary">Completa tu primer módulo</p>
                        <p class="text-xs text-slate-400">Obtén medallas de consistencia al finalizar tus bloques.</p>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs text-slate-500">Objetivo disponible</span>
                </div>
                <div class="flex items-center gap-3 rounded-2xl border border-slate-100 px-4 py-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                    </span>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-secondary">Mantén tus datos actualizados</p>
                        <p class="text-xs text-slate-400">Estamos preparando formularios editables para personalizar tu experiencia.</p>
                    </div>
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs text-emerald-600">Muy pronto</span>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.getElementById('avatar-input')?.addEventListener('change', (event) => {
            const file = event.target.files?.[0];
            if (!file) return;
            const preview = document.querySelector('img[alt="Avatar"]');
            if (preview) {
                const url = URL.createObjectURL(file);
                preview.src = url;
                setTimeout(() => URL.revokeObjectURL(url), 5000);
            }
        });
    </script>
@endsection
