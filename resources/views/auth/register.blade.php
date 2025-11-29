@extends('layouts.guest')

@section('title', 'Crea tu cuenta')
@section('subtitle', '&Uacute;nete a SkillNest y comienza a aprender o ense&ntilde;ar')

@section('form')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="auth-field">
            <label for="name">Nombre completo</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required class="auth-input">
            @error('name')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-field">
            <label for="email">Correo electr&oacute;nico</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required class="auth-input">
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

        <div class="auth-field">
            <label for="password_confirmation">Confirma tu contrase&ntilde;a</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required class="auth-input">
        </div>

        <div class="auth-field">
            <label for="role">Soy</label>
            <select id="role" name="role" class="auth-input">
                <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Estudiante</option>
                <option value="mentor" {{ old('role') === 'mentor' ? 'selected' : '' }}>Mentor</option>
            </select>
        </div>

        <button class="btn-submit" type="submit">Crear cuenta</button>

        <p class="text-sm" style="text-align: center; color: #6b7280; margin-top: 10px;">
            &iquest;Ya tienes cuenta?
            <a href="{{ route('login') }}" class="auth-link">Inicia sesi&oacute;n</a>
        </p>
    </form>
@endsection
