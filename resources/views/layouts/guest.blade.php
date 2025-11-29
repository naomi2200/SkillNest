@extends('layouts.app')

@section('content')
    @php
        $isRegister = request()->routeIs('register');
        $icon = $isRegister ? '✨' : '🔐';
        $ctaTitle = $isRegister ? '¿Ya tienes cuenta?' : '¿Aún no tienes cuenta?';
        $ctaText = $isRegister
            ? 'Ingresa para continuar con tus cursos, retomar mentorías y gestionar tus notificaciones.'
            : 'Únete a la comunidad SkillNest para acceder a cursos, mentorías y certificaciones verificables.';
        $ctaUrl = $isRegister ? route('login') : route('register');
        $ctaLabel = $isRegister ? 'Inicia sesión' : 'Crear cuenta';
        $ctaList = $isRegister
            ? ['Accede a tus cursos guardados', 'Retoma el progreso de tus mentorías', 'Administra tus notificaciones']
            : ['Cursos en vivo y on demand', 'Mentorías personalizadas', 'Certificados verificables'];
    @endphp

    <div class="auth-page">
        <div class="auth-shell">
            <div class="auth-wrapper">
                <section class="auth-card auth-card-main">
                    <div class="auth-header">
                        <div class="auth-icon">{{ $icon }}</div>
                        <h1 class="auth-title">@yield('title')</h1>
                        <p class="auth-subtitle">@yield('subtitle')</p>
                    </div>

                    @if (session('status'))
                        <div class="auth-alert">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="auth-alert error">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="7" x2="12" y2="13" />
                                <line x1="12" y1="17" x2="12.01" y2="17" />
                            </svg>
                            <span>{{ __('Por favor revisa la información ingresada.') }}</span>
                        </div>
                    @endif

                    @yield('form')
                </section>

                <section class="auth-card auth-card-side">
                    <h3>{{ $ctaTitle }}</h3>
                    <p>{{ $ctaText }}</p>

                    <ul class="auth-side-list">
                        @foreach ($ctaList as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>

                    <a href="{{ $ctaUrl }}" class="auth-side-button">{{ $ctaLabel }}</a>
                </section>
            </div>
        </div>
    </div>
@endsection
