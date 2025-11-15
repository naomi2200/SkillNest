@extends('layouts.guest')

@section('title', 'Recupera tu contraseña')
@section('subtitle', 'Te enviaremos un correo con instrucciones para restablecerla')

@section('form')
    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf
        <div>
            <label class="text-sm font-medium text-slate-600" for="email">Correo</label>
            <input id="email" name="email" type="email" required
                   class="mt-1 w-full rounded-lg border-slate-200 text-slate-700 focus:border-primary focus:ring-primary" />
        </div>

        <button class="btn-primary w-full">Enviar enlace</button>

        <p class="text-center text-sm text-slate-500">
            <a href="{{ route('login') }}" class="font-semibold text-primary">Volver al login</a>
        </p>
    </form>
@endsection
