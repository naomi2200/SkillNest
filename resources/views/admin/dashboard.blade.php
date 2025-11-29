@extends('layouts.app')

@push('styles')
    <style>
        :root {
            --primary: #6c47ff;
            --primary-light: #f0edff;
            --secondary: #1f2937;
            --accent: #8b5cf6;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --white: #ffffff;
            --radius: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        body {
            background: linear-gradient(135deg, #f8faff 0%, #f5f7ff 100%);
        }

        .dashboard-layout {
            min-height: calc(100vh - 96px);
            background: var(--gray-50);
            padding: clamp(16px, 3vw, 32px);
        }

        .dashboard-shell {
            display: flex;
            gap: 24px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .dashboard-sidebar {
            width: 280px;
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-200);
            position: sticky;
            top: clamp(100px, 16vh, 140px);
            align-self: flex-start;
        }

        .sidebar-header {
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--gray-200);
        }

        .sidebar-header h2 {
            font-size: 24px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 4px;
        }

        .sidebar-header p {
            font-size: 12px;
            color: var(--gray-400);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 600;
        }

        .dashboard-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: var(--radius);
            text-decoration: none;
            color: var(--gray-600);
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-item:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .nav-item.active {
            background: var(--primary);
            color: var(--white);
            font-weight: 600;
        }

        .dashboard-main {
            flex: 1;
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: clamp(20px, 3vw, 32px);
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-200);
        }

        .dashboard-hero {
            background: linear-gradient(135deg, rgba(108, 71, 255, 0.07), rgba(139, 92, 246, 0.12));
            border-radius: var(--radius-xl);
            padding: clamp(20px, 3vw, 32px);
            margin-bottom: 32px;
            border: 1px solid rgba(108, 71, 255, 0.15);
        }

        .hero-badge {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 12px;
        }

        .hero-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .hero-text h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 8px;
        }

        .hero-text p {
            color: var(--gray-600);
            max-width: 520px;
        }

        .hero-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border-radius: var(--radius);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .btn-primary {
            background: var(--primary);
            color: var(--white);
        }

        .btn-secondary {
            background: var(--white);
            color: var(--primary);
            border: 1px solid var(--gray-300);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 20px;
            border: 1px solid var(--gray-200);
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--gray-500);
        }

        .content-section {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 24px;
            border: 1px solid var(--gray-200);
            margin-bottom: 16px;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 16px;
        }

        @media (max-width: 1024px) {
            .dashboard-shell {
                flex-direction: column;
            }
            .dashboard-sidebar {
                width: 100%;
                position: static;
            }
        }

        @media (max-width: 768px) {
            .hero-content {
                flex-direction: column;
                align-items: flex-start;
            }
            .hero-actions {
                width: 100%;
            }
            .btn {
                flex: 1;
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-layout">
        <div class="dashboard-shell">
            <aside class="dashboard-sidebar">
                <div class="sidebar-header">
                    <h2>SkillNest</h2>
                    <p>Dashboard</p>
                </div>
                <nav class="dashboard-nav">
                    <a href="{{ route('admin.dashboard') }}" class="nav-item active">
                        <span>�Y"S</span> <span>Resumen</span>
                    </a>
                    <a href="{{ route('admin.courses.index', ['status' => 'aprobado', 'view' => 'tabla']) }}" class="nav-item">
                        <span>�Y"s</span> <span>Cursos</span>
                    </a>
                    <a href="#" class="nav-item">
                        <span>�sT��?</span> <span>Configuraci��n</span>
                    </a>
                </nav>
            </aside>

            <main class="dashboard-main">
                <header class="dashboard-hero">
                    <div class="hero-badge">Hola, {{ auth()->user()->name }}</div>
                    <div class="hero-content">
                        <div class="hero-text">
                            <h1>Panel general de SkillNest</h1>
                            <p>Supervisa los cursos enviados a revisi��n, el estado de la comunidad y las mentor��as activas.</p>
                        </div>
                        <div class="hero-user">
                            <div class="user-info">
                                <p>{{ auth()->user()->name ?? 'Administrador' }}</p>
                                <p>{{ auth()->user()->email ?? 'admin@skillnest.com' }}</p>
                            </div>
                            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                        </div>
                    </div>
                    <div class="hero-actions">
                        <a href="{{ route('admin.courses.index', ['status' => 'pendiente', 'view' => 'solicitudes']) }}" class="btn btn-primary">Ver cursos pendientes</a>
                        <a href="{{ route('admin.courses.index', ['status' => 'aprobado', 'view' => 'tabla']) }}" class="btn btn-secondary">Gestionar cursos</a>
                    </div>
                </header>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value">{{ number_format($stats['courses_active'] ?? 0) }}</div>
                        <div class="stat-label">Cursos activos</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ number_format($stats['courses_pending'] ?? 0) }}</div>
                        <div class="stat-label">En revisi��n</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ number_format($stats['courses_drafts'] ?? 0) }}</div>
                        <div class="stat-label">Borradores</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ number_format($stats['courses_rejected'] ?? 0) }}</div>
                        <div class="stat-label">Rechazados</div>
                    </div>
                </div>

                <div class="content-section">
                    <h3 class="section-title">Cursos pendientes ({{ ($pendingCourses ?? collect())->count() }})</h3>
                    @forelse($pendingCourses ?? [] as $course)
                        <div class="rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 mb-3">
                            <p class="font-semibold text-secondary">{{ $course->title }}</p>
                            <p class="text-xs text-gray-500">Mentor: {{ $course->mentor->name ?? 'Sin asignar' }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No hay cursos pendientes en este momento.</p>
                    @endforelse
                </div>

                <div class="content-section">
                    <h3 class="section-title">Nuevos usuarios</h3>
                    @forelse($recentUsers ?? [] as $recentUser)
                        <div class="flex justify-between rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 mb-2">
                            <span class="font-semibold text-secondary">{{ $recentUser->name }}</span>
                            <span class="text-sm text-gray-500">{{ ucfirst($recentUser->role ?? 'usuario') }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Sin registros recientes.</p>
                    @endforelse
                </div>
            </main>
        </div>
    </div>
@endsection
