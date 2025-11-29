@extends('layouts.guest')

@section('title', 'Recupera tu contraseña')
@section('subtitle', 'Te enviaremos un correo con instrucciones para restablecerla')

@section('form')
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="auth-field">
            <label for="email">Correo electrónico</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required class="auth-input">
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <button class="btn-submit" type="submit">Enviar enlace</button>

        <p class="text-sm" style="text-align: center; color: #6b7280; margin-top: 10px;">
            <a href="{{ route('login') }}" class="auth-link">Volver al login</a>
        </p>
    </form>
@endsection
