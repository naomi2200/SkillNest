@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Route;

    $mentor = auth()->user();
    $navLinks = [
        [
            'label' => 'Dashboard',
            'icon' => 'fa-solid fa-gauge-high',
            'url' => (Route::has('dashboard') ? route('dashboard') : '#'),
            'active' => request()->routeIs('dashboard'),
        ],
        [
            'label' => 'Mis cursos',
            'icon' => 'fa-solid fa-book-open',
            'url' => route('mentor.courses'),
            'active' => request()->routeIs('mentor.courses'),
        ],
        [
            'label' => 'Crear curso',
            'icon' => 'fa-solid fa-circle-plus',
            'url' => route('mentor.courses.create'),
            'active' => request()->routeIs('mentor.courses.create'),
        ],
        [
            'label' => 'Mis mentor?as',
            'icon' => 'fa-solid fa-chalkboard-user',
            'url' => route('mentor.mentorias.index'),
            'active' => request()->routeIs('mentor.mentorias.*'),
        ],
        [
            'label' => 'Crear mentor?a',
            'icon' => 'fa-solid fa-user-plus',
            'url' => route('mentorias.create'),
            'active' => request()->routeIs('mentorias.create'),
        ],
        [
            'label' => 'Mi perfil',
            'icon' => 'fa-solid fa-user-circle',
            'url' => route('mentor.profile'),
            'active' => request()->routeIs('mentor.profile'),
        ],
    ];
@endphp

@push('styles')
    <style>
        :root {
            --primary: #7c3aed;
            --primary-2: #8b5cf6;
        }

        .app-main { padding: 0; background: transparent; }
        .app-container { max-width: none; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: radial-gradient(circle at 20% 20%, rgba(124,58,237,0.08), transparent 35%),
                        radial-gradient(circle at 80% 0%, rgba(124,58,237,0.06), transparent 30%),
                        #f4f3ff;
            min-height: 100vh;
            color: #111827;
        }

        .mentor-shell {
            display: flex;
            gap: 32px;
            min-height: calc(100vh - 96px);
            padding: clamp(24px, 3vw, 48px);
            align-items: stretch;
            width: 100%;
        }

        .mentor-sidebar {
            position: sticky;
            top: clamp(96px, 12vh, 128px);
            align-self: flex-start;
            width: 260px;
            border-radius: 32px;
            background: linear-gradient(180deg, #ede9fe 0%, #ddd6fe 100%);
            border: 1px solid rgba(124,58,237,0.15);
            box-shadow: 0 20px 60px rgba(124,58,237,0.18);
            padding: 32px 24px;
            display: flex;
            flex-direction: column;
            max-height: calc(100vh - 64px);
            overflow-y: auto;
        }
        .mentor-brand h2 {
            font-size: 26px;
            font-weight: 900;
            margin: 6px 0 0;
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .mentor-brand p {
            font-size: 11px;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: #a1a1aa;
        }
        .mentor-nav {
            margin-top: 28px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .mentor-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 14px;
            font-weight: 600;
            color: #3f3f46;
            text-decoration: none;
            transition: all 0.25s ease;
        }
        .mentor-nav-icon {
            width: 38px;
            height: 38px;
            border-radius: 14px;
            background: rgba(124,58,237,0.12);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 16px;
            transition: all 0.2s ease;
        }
        .mentor-nav-link:hover {
            background: rgba(124,58,237,0.12);
            color: var(--primary);
        }
        .mentor-nav-link:hover .mentor-nav-icon {
            background: rgba(124,58,237,0.2);
        }
        .mentor-nav-link.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            color: #fff;
            box-shadow: 0 10px 25px rgba(124,58,237,0.25);
        }
        .mentor-nav-link.active .mentor-nav-icon {
            background: rgba(255,255,255,0.25);
            color: #fff;
        }

        .mentor-main {
            flex: 1;
            border-radius: 32px;
            background: #fff;
            border: 1px solid rgba(124,58,237,0.12);
            box-shadow: 0 30px 60px rgba(124,58,237,0.12);
            padding: 40px;
            backdrop-filter: blur(12px);
            min-height: calc(100vh - 96px);
            display: flex;
            flex-direction: column;
        }
        .mentor-header {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
            gap: 18px;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(15,23,42,0.08);
            margin-bottom: 32px;
        }
        .mentor-header h1 { font-size: 32px; font-weight: 900; color: #1f2937; }
        .mentor-header p { font-size: 14px; color: #6b7280; }
        .mentor-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            width: 100%;
        }

        .mentor-content { display: flex; flex-direction: column; gap: 24px; }
        .mentor-content > * { width: 100%; }

        /* Cards and table styling aligned with student */
        .mentor-card {
            border-radius: 24px;
            border: 1px solid rgba(124,58,237,0.12);
            background: #fff;
            padding: 28px;
            box-shadow: 0 16px 40px rgba(124,58,237,0.08);
        }
        .mentor-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .mentor-table thead {
            background: #f8fafc;
            color: #7c7f98;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.05em;
        }
        .mentor-table th,
        .mentor-table td {
            padding: 14px;
            border-bottom: 1px solid rgba(226,232,240,0.8);
            text-align: left;
        }
        .mentor-table tbody tr:hover { background: rgba(124,58,237,0.05); }

        .mentor-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 700;
        }
        .badge-draft {background: rgba(148,163,184,0.2); color: #475569;}
        .badge-pending {background: rgba(251,191,36,0.2); color: #b45309;}
        .badge-approved {background: rgba(16,185,129,0.2); color: #047857;}
        .badge-rejected {background: rgba(248,113,113,0.2); color: #b91c1c;}

        @media (max-width: 1200px) {
            .mentor-shell { flex-direction: column; }
            .mentor-sidebar { width: 100%; position: relative; top: 0; max-height: none; }
            .mentor-main { min-height: auto; }
        }
        @media (max-width: 640px) {
            .mentor-shell { padding: 20px; }
            .mentor-main { padding: 28px 20px; }
        }
    </style>
@endpush

@section('content')
    <div class="mentor-shell">
        <aside class="mentor-sidebar">
            <div class="mentor-brand">
                <p>Mentor panel</p>
                <h2>SkillNest</h2>
            </div>
            <nav class="mentor-nav">
                @foreach($navLinks as $link)
                    <a href="{{ $link['url'] }}" class="mentor-nav-link {{ $link['active'] ? 'active' : '' }}">
                        <span class="mentor-nav-icon" aria-hidden="true">
                            <i class="{{ $link['icon'] }}"></i>
                        </span>
                        <span>{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </nav>
            <div style="margin-top:auto; font-size:12px; color:#6b7280;">
                <p style="font-size:11px; letter-spacing:0.25em; text-transform:uppercase;">Sesión</p>
                <p style="font-weight:700; color:#111827;">{{ $mentor->name }}</p>
                <p>{{ $mentor->email }}</p>
            </div>
        </aside>

        <div class="mentor-main">
            <div class="mentor-header">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Panel mentor</p>
                    <h1>@yield('mentor-title', 'Mi panel de mentor')</h1>
                    <p>@yield('mentor-subtitle', 'Gestiona tus cursos y mentorías')</p>
                </div>
                <div class="mentor-actions">
                    @yield('mentor-actions')
                </div>
            </div>

            <div class="mentor-content">
                @yield('mentor-content')
            </div>
        </div>
    </div>
@endsection
