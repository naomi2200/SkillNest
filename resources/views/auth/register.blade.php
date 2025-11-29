@extends('layouts.guest')

@section('title', 'Crea tu cuenta')
@section('subtitle', '&Uacute;nete a SkillNest y comienza a aprender o ense&ntilde;ar')

@push('styles')
    <style>
        /* Reglas específicas para la vista de registro para igualar el mockup proporcionado */
        .auth-page { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .auth-card { border-radius: 20px; overflow: hidden; }
        .auth-card-main { padding: 48px 48px; }

        .register-left { max-width: 480px; margin: 0 auto; }

        .form-group { display:flex; flex-direction:column; gap:8px; margin-bottom:12px; }
        .form-group label { font-size:14px; font-weight:600; color:#374151; }
        .form-group input, .form-group select { padding:14px 16px; border:2px solid #e6edf3; border-radius:12px; background:#f8fafc; font-size:15px; }
        .form-group input:focus, .form-group select:focus { outline:none; border-color:#667eea; box-shadow:0 0 0 4px rgba(102,126,234,0.08); }

        .submit-btn { margin-top:12px; padding:14px; width:100%; border-radius:12px; background:linear-gradient(135deg,#667eea,#8b5cf6); color:#fff; font-weight:700; box-shadow:0 20px 50px rgba(99,102,241,0.12); border:none; }
        .submit-btn:hover { transform:translateY(-2px); }

        .login-link { text-align:center; margin-top:18px; font-size:14px; color:#6b7280; }
        .login-link a { color:#6366f1; font-weight:600; }

        /* Style for the right auth side to match the provided design */
        .auth-card-side { background: linear-gradient(135deg,#667eea 0%,#764ba2 100%) !important; color:#fff; padding:48px 48px; }
        .auth-card-side h3 { font-size:32px; font-weight:800; color:#fff; margin-bottom:12px; }
        .auth-card-side p { color: rgba(255,255,255,0.92); margin-bottom:22px; }
        .auth-side-list li { position: relative; background: rgba(255,255,255,0.06); padding: 16px 18px 16px 64px; border-radius:12px; display:flex; align-items:center; gap:12px; color:#fff; border:1px solid rgba(255,255,255,0.06); }
        .auth-side-list li::before { content:'\2713'; position:absolute; left:18px; top:50%; transform:translateY(-50%); width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center; background:#10b981; color:#072018; border-radius:6px; font-weight:800; }
        .auth-side-button { background:#fff; color:#6366f1; padding:14px 28px; border-radius:12px; display:inline-block; font-weight:700; box-shadow:0 18px 40px rgba(99,102,241,0.12); }

        @media (max-width: 968px) {
            .auth-card { border-radius:16px; }
            .auth-card-main { padding:32px; }
        }
    </style>
@endpush

@section('form')
    <div class="register-left">
        <form method="POST" action="{{ route('register') }}" class="register-form">
            @csrf
            <div class="form-group">
                <label for="name">Nombre completo</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required>
                @error('name')<p class="auth-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                @error('email')<p class="auth-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input id="password" name="password" type="password" required placeholder="Mínimo 8 caracteres">
                @error('password')<p class="auth-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirma tu contraseña</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required>
            </div>

            <div class="form-group">
                <label for="role">Soy</label>
                <select id="role" name="role" required>
                    <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Estudiante</option>
                    <option value="mentor" {{ old('role') === 'mentor' ? 'selected' : '' }}>Mentor</option>
                </select>
            </div>

            <button type="submit" class="submit-btn">Crear cuenta</button>
        </form>

        <div class="login-link">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></div>
    </div>
@endsection
