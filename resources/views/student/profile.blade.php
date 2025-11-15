@extends('layouts.student')

@section('student-title', 'Mi perfil')
@section('student-subtitle', 'Actualiza tus datos personales para mantener tu experiencia personalizada')

@section('student-content')
    <div class="card max-w-2xl space-y-4">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Nombre completo</p>
            <p class="mt-1 text-lg font-semibold text-secondary">{{ $user->name ?? 'Estudiante' }}</p>
        </div>

        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Correo electrónico</p>
            <p class="mt-1 font-medium text-slate-600">{{ $user->email ?? 'correo@skillnest.com' }}</p>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="rounded-2xl border border-slate-100 p-4">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Zona horaria</p>
                <p class="mt-1 font-medium text-secondary">{{ $user->timezone ?? 'Por configurar' }}</p>
            </div>
            <div class="rounded-2xl border border-slate-100 p-4">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Notificaciones</p>
                <p class="mt-1 font-medium text-secondary">{{ ucfirst($user->notification_channel ?? 'email') }}</p>
            </div>
        </div>

        <div class="rounded-2xl border border-dashed border-slate-200 p-6 text-center text-sm text-slate-500">
            Muy pronto podrás editar tus datos directamente desde aquí.
        </div>
    </div>
@endsection
