@extends('layouts.guest')

@section('title', 'Crea tu cuenta')
@section('subtitle', 'Únete a SkillNest y comienza a aprender o enseñar')

@section('form')
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <div>
            <label class="text-sm font-medium text-slate-600" for="name">Nombre completo</label>
            <input id="name" name="name" type="text" required
                   class="mt-1 w-full rounded-lg border-slate-200 text-slate-700 focus:border-primary focus:ring-primary" />
        </div>

        <div>
            <label class="text-sm font-medium text-slate-600" for="email">Correo</label>
            <input id="email" name="email" type="email" required
                   class="mt-1 w-full rounded-lg border-slate-200 text-slate-700 focus:border-primary focus:ring-primary" />
        </div>

        <div>
            <label class="text-sm font-medium text-slate-600" for="password">Contraseña</label>
            <input id="password" name="password" type="password" required
                   class="mt-1 w-full rounded-lg border-slate-200 text-slate-700 focus:border-primary focus:ring-primary" />
        </div>

        <div>
            <label class="text-sm font-medium text-slate-600" for="password_confirmation">Confirma tu contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                   class="mt-1 w-full rounded-lg border-slate-200 text-slate-700 focus:border-primary focus:ring-primary" />
        </div>

        <div>
            <label class="text-sm font-medium text-slate-600" for="role">Soy</label>
            <select id="role" name="role" class="mt-1 w-full rounded-lg border-slate-200 text-slate-700 focus:border-primary focus:ring-primary">
                <option value="student">Estudiante</option>
                <option value="mentor">Mentor</option>
            </select>
        </div>

        <button class="btn-primary w-full">Crear cuenta</button>

        <p class="text-center text-sm text-slate-500">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="font-semibold text-primary">Inicia sesión</a>
        </p>
    </form>
@endsection
