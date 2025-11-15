@extends('layouts.guest')

@section('title', 'Inicia sesión')
@section('subtitle', 'Accede con tu cuenta para continuar')

@section('form')
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="text-sm font-medium text-slate-600" for="email">Correo</label>
            <input id="email" name="email" type="email" required autofocus
                   class="mt-1 w-full rounded-lg border-slate-200 text-slate-700 focus:border-primary focus:ring-primary" />
        </div>

        <div>
            <label class="text-sm font-medium text-slate-600" for="password">Contraseña</label>
            <input id="password" name="password" type="password" required
                   class="mt-1 w-full rounded-lg border-slate-200 text-slate-700 focus:border-primary focus:ring-primary" />
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="inline-flex items-center gap-2 text-slate-500">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-primary focus:ring-primary">
                Recordarme
            </label>
            <a href="{{ route('password.request') }}" class="font-medium text-primary hover:text-primary/80">
                ¿Olvidaste tu contraseña?
            </a>
        </div>

        <button class="btn-primary w-full">Ingresar</button>

        <p class="text-center text-sm text-slate-500">
            ¿Aún no tienes cuenta?
            <a href="{{ route('register') }}" class="font-semibold text-primary">Crear cuenta</a>
        </p>
    </form>
@endsection
