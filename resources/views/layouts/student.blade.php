@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Route;

    $student = auth()->user();
    $navLinks = [
        [
            'label' => 'Dashboard',
            'icon' => '📊',
            'url' => route('student.dashboard'),
            'active' => request()->routeIs('student.dashboard'),
        ],
        [
            'label' => 'Mis cursos',
            'icon' => '📘',
            'url' => route('student.courses'),
            'active' => request()->routeIs('student.courses'),
        ],
        [
            'label' => 'Mis mentorías',
            'icon' => '👥',
            'url' => route('student.mentorias'),
            'active' => request()->routeIs('student.mentorias'),
        ],
        [
            'label' => 'Mi perfil',
            'icon' => '👤',
            'url' => route('student.profile'),
            'active' => request()->routeIs('student.profile'),
        ],
    ];
@endphp
@push('styles')
    <style>
        .app-main {
            padding: 0;
            background: transparent;
        }
        .app-container {
            max-width: none;
            padding: 0;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(130deg, #eef2ff 0%, #fdf4ff 45%, #e0e7ff 100%);
            min-height: 100vh;
        }
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background:
                radial-gradient(circle at 12% 30%, rgba(167,139,250,0.18) 0%, transparent 45%),
                radial-gradient(circle at 85% 80%, rgba(196,181,253,0.14) 0%, transparent 55%),
                radial-gradient(circle at 50% 10%, rgba(191,219,254,0.15) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        .student-shell {
            position: relative;
            z-index: 1;
            display: flex;
            gap: 32px;
            min-height: calc(100vh - 96px);
            padding: clamp(24px, 3vw, 48px);
            align-items: stretch;
            width: 100%;
        }
        .student-sidebar {
            position: sticky;
            top: clamp(96px, 12vh, 128px);
            align-self: flex-start;
            width: 260px;
            border-radius: 32px;
            background: rgba(255,255,255,0.96);
            border: 1px solid rgba(226,232,240,0.9);
            box-shadow: 0 20px 60px rgba(79,70,229,0.12);
            padding: 32px 24px;
            display: flex;
            flex-direction: column;
            max-height: calc(100vh - 64px);
            overflow-y: auto;
        }
        .student-brand h2 {
            font-size: 26px;
            font-weight: 900;
            margin: 6px 0 0;
            background: linear-gradient(135deg, #6c47ff, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .student-brand p {
            font-size: 11px;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: #a1a1aa;
        }
        .student-nav {
            margin-top: 28px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .student-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 14px;
            font-weight: 600;
            color: #4c4f6b;
            text-decoration: none;
            transition: all 0.25s ease;
        }
        .student-nav-link span:first-child {
            width: 20px;
            text-align: center;
        }
        .student-nav-link:hover {
            background: rgba(108,71,255,0.08);
            color: #6c47ff;
        }
        .student-nav-link.active {
            background: linear-gradient(135deg, #6c47ff, #8b5cf6);
            color: #fff;
            box-shadow: 0 10px 25px rgba(108,71,255,0.35);
        }
        .student-main {
            flex: 1;
            border-radius: 32px;
            background: rgba(255,255,255,0.98);
            border: 1px solid rgba(226,232,240,0.9);
            box-shadow: 0 30px 60px rgba(99,102,241,0.15);
            padding: 40px;
            backdrop-filter: blur(12px);
            min-height: calc(100vh - 96px);
            display: flex;
            flex-direction: column;
        }
        .student-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(15,23,42,0.08);
            margin-bottom: 32px;
        }
        .student-header h1 {
            font-size: 32px;
            font-weight: 900;
            color: #1f2937;
        }
        .student-header p {
            font-size: 14px;
            color: #6b7280;
        }
        .student-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .student-content {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        .student-content > * {
            width: 100%;
        }
        /* Estadísticas y tarjetas */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            align-items: start;
        }
        .stat-card {
            background: #fff;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid rgba(226,232,240,0.8);
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(0,0,0,0.08); }
        .stat-label { font-size: 12px; text-transform: uppercase; letter-spacing: 0.12em; color: #94a3b8; font-weight: 600; }
        .stat-value { font-size: 36px; font-weight: 900; margin-top: 8px; background: linear-gradient(135deg, #6c47ff, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .stat-description { font-size: 13px; color: #6b7280; margin-top: 8px; }

        .content-card { background: #fff; border-radius: 24px; padding: 28px; border: 1px solid rgba(226,232,240,0.8); box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .content-card h2 { font-size: 20px; font-weight: 800; color: #1f2937; margin-bottom: 16px; }
        .empty-state { text-align: center; padding: 40px 20px; }
        .empty-icon { font-size: 56px; margin-bottom: 12px; }
        .empty-text { color: #6b7280; font-size: 14px; }
        @media (max-width: 1200px) {
            .student-shell {
                flex-direction: column;
            }
            .student-sidebar {
                width: 100%;
                position: relative;
                top: 0;
                max-height: none;
            }
            .student-main {
                min-height: auto;
            }
        }
        @media (max-width: 640px) {
            .student-shell {
                padding: 20px;
            }
            .student-main {
                padding: 28px 20px;
            }
        }
    </style>
    <style>
        .student-theme-toggle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: 1px solid rgba(15,23,42,0.06);
            background: transparent;
            color: #4c4f6b;
            cursor: pointer;
            transition: all 0.18s ease;
        }
        .student-theme-toggle:hover { transform: translateY(-2px); background: rgba(108,71,255,0.06); color:#6c47ff; }
        .student-theme-toggle[aria-pressed="true"] { background: linear-gradient(135deg, #6c47ff, #8b5cf6); color: #fff; border-color: rgba(108,71,255,0.12); }
    </style>

    <!-- Dark theme CSS (provided by user). Disabled by default and toggled via JS -->
    <style id="student-dark-theme" disabled>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #0a0e27;
            color: #fff;
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: #fff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .logo i {
            color: #6366f1;
        }

        .logo-text {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: #374151;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #6366f1;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn-panel {
            color: #6366f1;
            font-weight: 600;
            background: none;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-salir {
            background: #ff5757;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 0.5rem;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-salir:hover {
            background: #ff3838;
            transform: translateY(-2px);
        }

        /* Main Layout */
        .main-layout {
            display: flex;
            min-height: calc(100vh - 70px);
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background: #0f1629;
            padding: 2rem 1rem;
            border-right: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-title {
            color: #6b7280;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.9rem 1.2rem;
            color: #9ca3af;
            text-decoration: none;
            border-radius: 0.75rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover {
            background: rgba(99, 102, 241, 0.1);
            color: #fff;
        }

        .sidebar-menu a.active {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }

        /* Content Area */
        .content {
            flex: 1;
            background: linear-gradient(135deg, #1a1f3a 0%, #0a0e27 100%);
            padding: 2rem;
            overflow-y: auto;
        }

        /* Welcome Section */
        .welcome-section {
            background: linear-gradient(135deg, #2d3561 0%, #1e2347 100%);
            border-radius: 1.5rem;
            padding: 2.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255,255,255,0.05);
            position: relative;
            overflow: hidden;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .welcome-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .welcome-subtitle {
            color: #9ca3af;
            font-size: 1rem;
        }

        .user-avatar {
            position: absolute;
            top: 2rem;
            right: 2rem;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.4);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 1.25rem;
            padding: 1.75rem;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: rgba(99, 102, 241, 0.3);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .stat-label {
            color: #9ca3af;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.75rem;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 0;
        }

        .stat-icon {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon.blue { background: #3b82f6; }
        .stat-icon.green { background: #10b981; }
        .stat-icon.purple { background: #8b5cf6; }
        .stat-icon.orange { background: #f59e0b; }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        /* Section */
        .section {
            background: rgba(30, 41, 59, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 1.25rem;
            padding: 2rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
        }

        .section-link {
            color: #6366f1;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            transition: gap 0.3s;
        }

        .section-link:hover {
            gap: 0.6rem;
        }

        /* Course Card */
        .course-card {
            background: rgba(15, 23, 42, 0.6);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1.25rem;
            border: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s;
        }

        .course-card:hover {
            border-color: rgba(99, 102, 241, 0.3);
            transform: translateX(5px);
        }

        .course-card:last-child {
            margin-bottom: 0;
        }

        .course-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 0.75rem;
        }

        .course-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .course-meta {
            color: #9ca3af;
            font-size: 0.85rem;
        }

        .course-progress-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
        }

        .progress-bar-wrapper {
            background: rgba(255,255,255,0.05);
            height: 8px;
            border-radius: 999px;
            overflow: hidden;
            margin-top: 0.75rem;
        }

        .progress-bar-fill {
            height: 100%;
            border-radius: 999px;
            transition: width 0.5s ease;
        }

        .progress-blue {
            background: linear-gradient(90deg, #3b82f6, #6366f1);
        }

        .progress-purple {
            background: linear-gradient(90deg, #8b5cf6, #a78bfa);
        }

        .progress-cyan {
            background: linear-gradient(90deg, #06b6d4, #3b82f6);
        }

        .course-action {
            color: #6366f1;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            margin-top: 0.75rem;
            transition: gap 0.3s;
        }

        .course-action:hover {
            gap: 0.6rem;
        }

        /* Mentorship Card */
        .mentorship-card {
            background: rgba(15, 23, 42, 0.6);
            border-radius: 1rem;
            padding: 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s;
        }

        .mentorship-card:hover {
            border-color: rgba(99, 102, 241, 0.3);
            transform: translateY(-2px);
        }

        .mentorship-card:last-child {
            margin-bottom: 0;
        }

        .mentor-header {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .mentor-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .mentor-avatar.blue {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
        }

        .mentor-avatar.purple {
            background: linear-gradient(135deg, #8b5cf6, #a78bfa);
        }

        .mentor-info {
            flex: 1;
        }

        .mentor-name {
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 0.15rem;
        }

        .mentor-role {
            color: #9ca3af;
            font-size: 0.8rem;
        }

        .mentor-time {
            color: #9ca3af;
            font-size: 0.85rem;
            margin-bottom: 0.75rem;
        }

        .btn-confirm {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.3);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-confirm:hover {
            background: rgba(16, 185, 129, 0.25);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .header {
                padding: 1rem;
            }

            .nav-links {
                display: none;
            }

            .welcome-section {
                padding: 1.5rem;
            }

            .user-avatar {
                position: static;
                margin-top: 1rem;
            }
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.8);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 4px;
        }
    </style>
@endpush

@section('content')
    <div class="student-shell">
        <aside class="student-sidebar">
            <div class="student-brand">
                <p>Student panel</p>
                <h2>SkillNest</h2>
            </div>
            <nav class="student-nav">
                @foreach($navLinks as $link)
                    <div style="display:flex; align-items:center; gap:8px;">
                        <a href="{{ $link['url'] }}" class="student-nav-link {{ $link['active'] ? 'active' : '' }}">
                            <span>{{ $link['icon'] }}</span>
                            <span>{{ $link['label'] }}</span>
                        </a>
                        @if($link['label'] === 'Dashboard')
                            <button id="student-theme-toggle" class="student-theme-toggle" type="button" title="Cambiar tema" aria-pressed="false">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" fill="currentColor"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                @endforeach
            </nav>
            <div style="margin-top:auto; font-size:12px; color:#94a3b8;">
                <p style="font-size:11px; letter-spacing:0.25em; text-transform:uppercase;">Sesión</p>
                <p style="font-weight:600; color:#1f2937;">{{ $student->name }}</p>
                <p>{{ $student->email }}</p>
            </div>
        </aside>

        <div class="student-main">
            <div class="student-header">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Panel estudiante</p>
                    <h1>@yield('student-title', 'Panel del estudiante')</h1>
                    <p>@yield('student-subtitle', 'Revisa tus cursos y mentorías')</p>
                </div>
                <div class="student-actions">
                    @yield('student-actions')
                </div>
            </div>

            <div class="student-content">
                @hasSection('student-widgets')
                    <div class="stats-grid">
                        @yield('student-widgets')
                    </div>
                @endif

                @yield('student-content')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function(){
            const KEY = 'student-theme';
            const btn = document.getElementById('student-theme-toggle');
            const style = document.getElementById('student-dark-theme');
            if(!btn || !style) return;

            function setDark(enabled){
                try { style.disabled = !enabled; } catch(e) { /* ignore */ }
                btn.setAttribute('aria-pressed', enabled ? 'true' : 'false');
            }

            // initialize from localStorage
            const saved = localStorage.getItem(KEY);
            const enabled = saved === 'dark';
            setDark(enabled);

            btn.addEventListener('click', function(){
                const currentEnabled = !style.disabled;
                const finalEnabled = !currentEnabled;
                setDark(finalEnabled);
                localStorage.setItem(KEY, finalEnabled ? 'dark' : 'light');
            });
        })();
    </script>
@endpush
