@extends('layouts.guest')

@section('title', 'Inicia sesi&oacute;n')
@section('subtitle', 'Accede con tu cuenta para continuar')

@section('form')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="auth-field">
            <label for="email">Correo electr&oacute;nico</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autofocus required class="auth-input">
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-field">
            <label for="password">Contrase&ntilde;a</label>
            <input id="password" name="password" type="password" required class="auth-input">
            @error('password')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-options">
            <label class="auth-checkbox">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <span>Recordarme</span>
            </label>
            <a href="{{ route('password.request') }}" class="auth-link">&iquest;Olvidaste tu contrase&ntilde;a?</a>
        </div>

        <button class="btn-submit" type="submit">Ingresar</button>

        <p class="text-sm" style="text-align: center; color: #6b7280; margin-top: 10px;">
            &iquest;A&uacute;n no tienes cuenta?
            <a href="{{ route('register') }}" class="auth-link">Crear cuenta</a>
        </p>
    </form>
@endsection
