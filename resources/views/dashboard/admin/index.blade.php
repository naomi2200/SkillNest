@extends('layouts.admin')

@section('title', 'Panel administrativo')
@section('header-title', 'Panel administrativo')
@section('header-subtitle', 'Bienvenido de nuevo')

@section('content')
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 28px;
            margin-bottom: 48px;
        }

        .stat-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            border: 1px solid rgba(255,255,255,0.3);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: 5px;
            width: 100%;
            background: linear-gradient(90deg, var(--color-primary), #8b5cf6, #a855f7);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 30px 80px rgba(108,71,255,0.2);
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-card-content {
            position: relative;
            z-index: 1;
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(108,71,255,0.15), rgba(139,92,246,0.15));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 18px;
        }

        .stat-card-content p:first-of-type {
            font-size: 13px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .stat-card-content p:last-of-type {
            font-size: 42px;
            font-weight: 900;
            background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
        }

        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(420px, 1fr));
            gap: 32px;
        }

        .content-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 36px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            border: 1px solid rgba(255,255,255,0.3);
            position: relative;
            overflow: hidden;
        }

        .content-card h2 {
            font-size: 22px;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 28px;
            letter-spacing: -0.01em;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .content-card h2::before {
            content: "";
            width: 5px;
            height: 28px;
            background: linear-gradient(180deg, var(--color-primary), #8b5cf6);
            border-radius: 3px;
        }

        .list-container {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .list-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px;
            background: linear-gradient(135deg, rgba(250,250,250,0.85), rgba(249,250,251,0.85));
            border-radius: 16px;
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .list-item:hover {
            background: rgba(108,71,255,0.06);
            border-color: rgba(108,71,255,0.2);
            transform: translateX(6px);
            box-shadow: 0 8px 24px rgba(108,71,255,0.12);
        }

        .list-item span {
            font-size: 15px;
            color: #374151;
            font-weight: 600;
        }

        .list-item a {
            color: #fff;
            background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            padding: 10px 20px;
            border-radius: 12px;
            letter-spacing: 0.05em;
            box-shadow: 0 4px 12px rgba(108,71,255,0.3);
        }

        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: #9ca3af;
            font-size: 15px;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-content">
                <div class="stat-icon">📚</div>
                <p>Cursos activos</p>
                <p>{{ number_format($stats['courses_active'] ?? 0) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-content">
                <div class="stat-icon">💰</div>
                <p>Ventas registradas</p>
                <p>S/ {{ number_format($stats['total_sales'] ?? 0, 2) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-content">
                <div class="stat-icon">👥</div>
                <p>Inscritos</p>
                <p>{{ number_format($stats['total_students'] ?? 0) }}</p>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <div class="content-card">
            <h2>Cursos pendientes</h2>
            <div class="list-container">
                @forelse($pendingCourses ?? [] as $course)
                    <div class="list-item">
                        <span>{{ $course->title }}</span>
                        <a href="{{ route('admin.courses.show', $course->id) }}">Revisar</a>
                    </div>
                @empty
                    <div class="empty-state">No hay cursos pendientes.</div>
                @endforelse
            </div>
        </div>

        <div class="content-card">
            <h2>Nuevos usuarios</h2>
            <div class="list-container">
                @forelse($recentUsers ?? [] as $user)
                    <div class="list-item">
                        <span>{{ $user->name }} · {{ ucfirst($user->role ?? 'usuario') }}</span>
                    </div>
                @empty
                    <div class="empty-state">Sin registros recientes.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
