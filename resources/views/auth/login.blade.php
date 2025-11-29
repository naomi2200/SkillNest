@extends('layouts.guest')

@section('title', 'Inicia sesión')
@section('subtitle', 'Accede con tu cuenta para continuar')

@push('styles')
    <style>
        /* Ajustes para que el contenido use correctamente el layout `layouts.guest` y no duplique paneles */
        .auth-page { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .auth-card { border-radius: 20px; overflow: hidden; }
        .auth-card-main { padding: 48px 48px; }

        /* Estilos del panel izquierdo (formulario) dentro de auth-card-main */
        .login-left {
            max-width: 420px;
            margin: 10px auto 0;
            padding-top: 8px;
        }

        .form-group { display:flex; flex-direction:column; gap:8px; margin-bottom:12px; }
        .form-group label { font-size:14px; font-weight:600; color:#374151; }
        .form-group input { padding:14px 16px; border:2px solid #e6edf3; border-radius:12px; background:#f8fafc; font-size:15px; }
        .form-group input:focus { outline:none; border-color:#667eea; box-shadow:0 0 0 4px rgba(102,126,234,0.08); }

        .form-options { display:flex; align-items:center; justify-content:space-between; margin-top:6px; }
        .remember-me { display:flex; align-items:center; gap:8px; font-size:14px; color:#4b5563; }
        .forgot-password { font-size:14px; color:#6366f1; font-weight:600; }

        .submit-btn { margin-top:16px; padding:14px; width:100%; border-radius:12px; background:linear-gradient(135deg,#667eea,#8b5cf6); color:#fff; font-weight:700; box-shadow:0 20px 50px rgba(99,102,241,0.15); border:none; }
        .submit-btn:hover { transform:translateY(-2px); }

        .signup-link { text-align:center; margin-top:18px; font-size:14px; color:#6b7280; }
        .signup-link a { color:#6366f1; font-weight:600; }

        @media (max-width: 968px) {
            .auth-card { border-radius:16px; }
            .auth-card-main { padding:32px; }
        }
        /* Panel derecho (auth-card-side) - styling para coincidir con la imagen proporcionada */
        .auth-card-side {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: #fff;
            padding: 48px 48px;
        }
        .auth-card-side h3 { font-size:32px; font-weight:800; color:#fff; margin-bottom:12px; }
        .auth-card-side p { color: rgba(255,255,255,0.9); margin-bottom:22px; }
        .auth-side-list { display:flex; flex-direction:column; gap:18px; }
        .auth-side-list li {
            position: relative;
            background: rgba(255,255,255,0.06);
            padding: 16px 18px 16px 64px; /* make space for the check */
            border-radius: 12px;
            display:flex;
            align-items:center;
            gap:12px;
            color: #fff;
            border: 1px solid rgba(255,255,255,0.06);
        }
        .auth-side-list li::before {
            content: '\2713';
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            width:28px;
            height:28px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            background:#10b981;
            color:#072018;
            border-radius:6px;
            font-weight:800;
        }
        .auth-side-button { background:#fff; color:#6366f1; padding:14px 28px; border-radius:12px; display:inline-block; font-weight:700; box-shadow:0 18px 40px rgba(99,102,241,0.12); }
    </style>
@endpush

@section('form')
    <div class="login-left">
        <form action="{{ route('login') }}" method="POST" class="login-form">
            @csrf
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus placeholder="tu@email.com">
                @error('email')<p class="auth-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input id="password" name="password" type="password" required placeholder="Ingresa tu contraseña">
                @error('password')<p class="auth-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Recordarme</span>
                </label>
                <a href="{{ route('password.request') }}" class="forgot-password">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit" class="submit-btn">Ingresar</button>
        </form>

        <div class="signup-link">¿Aún no tienes cuenta? <a href="{{ route('register') }}">Crear cuenta</a></div>
    </div>
@endsection
