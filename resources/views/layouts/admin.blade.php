<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel Administrativo') · SkillNest</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --color-primary: #6c47ff;
            --color-primary-hover: #5a38e6;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #1f2937;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background:
                radial-gradient(circle at 20% 50%, rgba(108, 71, 255, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(168, 85, 247, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .admin-shell {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        aside {
            width: 280px;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.25);
            padding: 32px 0;
            height: 100vh;
            position: sticky;
            top: 0;
            overflow-y: auto;
            box-shadow: 4px 0 24px rgba(0,0,0,0.08);
        }

        .sidebar-logo {
            padding: 0 24px 32px;
            border-bottom: 1px solid rgba(108, 71, 255, 0.1);
            margin-bottom: 32px;
        }

        .sidebar-logo h2 {
            font-size: 30px;
            font-weight: 900;
            background: linear-gradient(135deg, var(--color-primary) 0%, #8b5cf6 50%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.02em;
        }

        .sidebar-logo p {
            font-size: 11px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            margin-top: 8px;
            font-weight: 600;
        }

        nav {
            padding: 0 16px;
        }

        nav a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 18px;
            margin-bottom: 6px;
            border-radius: 16px;
            text-decoration: none;
            color: #4b5563;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        nav a::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(108, 71, 255, 0.12), transparent);
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }

        nav a:hover::before {
            transform: translateX(100%);
        }

        nav a:hover {
            background: linear-gradient(135deg, rgba(108, 71, 255, 0.08), rgba(139, 92, 246, 0.08));
            color: var(--color-primary);
            transform: translateX(6px);
            box-shadow: 0 4px 12px rgba(108, 71, 255, 0.15);
        }

        nav a.active {
            background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 8px 24px rgba(108, 71, 255, 0.35);
        }

        .nav-icon {
            width: 24px;
            text-align: center;
        }

        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: vertical;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.2);
            padding: 28px 48px;
            position: sticky;
            top: 0;
            z-index: 10;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-title {
            position: relative;
            padding-left: 20px;
        }

        .header-title::before {
            content: "";
            position: absolute;
            left: 0;
            top: -8px;
            width: 4px;
            height: calc(100% + 16px);
            background: linear-gradient(180deg, var(--color-primary), #8b5cf6);
            border-radius: 2px;
            box-shadow: 0 0 12px rgba(108, 71, 255, 0.5);
        }

        .header-title h1 {
            font-size: 30px;
            font-weight: 900;
            background: linear-gradient(135deg, #1f2937, #4b5563);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.02em;
        }

        .header-title p {
            font-size: 13px;
            letter-spacing: 0.08em;
            color: #9ca3af;
            text-transform: uppercase;
            margin-top: 6px;
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 12px 20px;
            background: rgba(108, 71, 255, 0.05);
            border-radius: 20px;
            border: 1px solid rgba(108, 71, 255, 0.1);
        }

        .header-user .user-info {
            text-align: right;
        }

        .header-user .user-info p:first-child {
            font-weight: 700;
            color: #1f2937;
        }

        .header-user .user-info p:last-child {
            font-size: 12px;
            color: #9ca3af;
        }

        .user-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
            color: #fff;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #fff;
            box-shadow: 0 8px 24px rgba(108, 71, 255, 0.35);
            position: relative;
        }

        .user-avatar::after {
            content: "";
            position: absolute;
            right: 4px;
            bottom: 4px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #10b981;
            border: 2px solid #fff;
        }

        main {
            flex: 1;
            padding: 48px;
        }

        @media (max-width: 1024px) {
            aside {
                display: none;
            }

            main,
            header {
                padding: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-shell">
        <aside>
            <div class="sidebar-logo">
                <h2>SkillNest</h2>
                <p>Admin Panel</p>
            </div>
            <nav>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">📊</span>
                    Dashboard
                </a>
                <a href="{{ route('admin.courses.index') }}" class="{{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                    <span class="nav-icon">📚</span>
                    Cursos
                </a>
                <a href="#">
                    <span class="nav-icon">👥</span>
                    Usuarios
                </a>
                <a href="#">
                    <span class="nav-icon">💰</span>
                    Ventas
                </a>
                <a href="#">
                    <span class="nav-icon">📈</span>
                    Reportes
                </a>
                <a href="#">
                    <span class="nav-icon">⚙️</span>
                    Configuración
                </a>
            </nav>
        </aside>
        <div class="main-wrapper">
            <header>
                <div class="header-content">
                    <div class="header-title">
                        <h1>@yield('header-title', 'Panel Administrativo')</h1>
                        <p>@yield('header-subtitle', 'Monitorea la actividad general de SkillNest')</p>
                    </div>
                    <div class="header-user">
                        <div class="user-info">
                            <p>{{ auth()->user()->name ?? 'Administrador' }}</p>
                            <p>{{ auth()->user()->email ?? 'admin@skillnest.com' }}</p>
                        </div>
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>
            <main>
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
