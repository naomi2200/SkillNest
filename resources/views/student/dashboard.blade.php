@extends('layouts.student')

@section('student-title', 'Dashboard estudiante')
@section('student-subtitle', 'Visualiza tu progreso y proximas mentorias')

@push('styles')
    <style>
        .student-main { background: transparent; border: none; box-shadow: none; padding: 0; }
        .student-header { display: none; }
        .student-content { gap: 0; }
        .student-dashboard-premium {
            background: linear-gradient(135deg, #f8f9ff 0%, #f1f4ff 100%);
            border-radius: 36px;
            padding: 28px;
            font-family: 'Inter', sans-serif;
        }
        .student-dashboard-premium * { font-family: 'Inter', sans-serif; }
        .student-dashboard-premium .font-poppins { font-family: 'Poppins', sans-serif; }
        .student-dashboard-premium .dashboard-container { max-width: 1400px; margin: 0 auto; }
        .student-dashboard-premium .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }
        .student-dashboard-premium .user-welcome h1 { font-size: 32px; font-weight: 700; color: #1f2937; margin-bottom: 8px; }
        .student-dashboard-premium .user-welcome p { color: #6b7280; font-size: 16px; }
        .student-dashboard-premium .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .student-dashboard-premium .date-badge {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .student-dashboard-premium .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }
        .student-dashboard-premium .stat-card {
            background: #fff;
            border-radius: 18px;
            padding: 18px;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(226, 232, 240, 0.8);
            position: relative;
            overflow: hidden;
            transition: transform .25s ease, box-shadow .25s ease;
            display: flex;
            align-items: center;
            gap: 14px;
            min-height: 120px;
        }
        .student-dashboard-premium .stat-card:hover { transform: translateY(-4px); box-shadow: 0 18px 36px rgba(99, 102, 241, 0.18); }
        .student-dashboard-premium .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            opacity: .6;
        }
        .student-dashboard-premium .stat-card > * { position: relative; z-index: 1; }
        .student-dashboard-premium .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(102,126,234,0.18), rgba(118,75,162,0.18));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #667eea;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        .student-dashboard-premium .stat-body { display: flex; flex-direction: column; gap: 4px; }
        .student-dashboard-premium .stat-value { font-size: 28px; font-weight: 800; color: #1f2937; }
        .student-dashboard-premium .stat-label { color: #94a3b8; font-size: 12px; text-transform: uppercase; letter-spacing: .08em; font-weight: 700; white-space: nowrap; }
        .student-dashboard-premium .stat-trend {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 2px;
            font-size: 12px;
            font-weight: 600;
        }
        .student-dashboard-premium .trend-up { color: #10b981; }
        .student-dashboard-premium .trend-down { color: #ef4444; }
        .student-dashboard-premium .dashboard-main { display: grid; grid-template-columns: 1fr 380px; gap: 30px; }
        @media (max-width: 1024px) { .student-dashboard-premium .dashboard-main { grid-template-columns: 1fr; } }
        .student-dashboard-premium .section-card {
            background: #fff;
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(226, 232, 240, 0.8);
            margin-bottom: 30px;
        }
        .student-dashboard-premium .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .student-dashboard-premium .section-title { font-size: 24px; font-weight: 700; color: #1f2937; }
        .student-dashboard-premium .view-all {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: color .3s ease;
        }
        .student-dashboard-premium .view-all:hover { color: #764ba2; }
        .student-dashboard-premium .course-card {
            background: rgba(102,126,234,0.05);
            border-radius: 18px;
            padding: 24px;
            margin-bottom: 16px;
            border: 1px solid rgba(102,126,234,0.1);
            transition: transform .3s ease, background .3s ease;
        }
        .student-dashboard-premium .course-card:hover { transform: translateY(-3px); background: rgba(102,126,234,0.08); }
        .student-dashboard-premium .course-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; gap: 16px; flex-wrap: wrap; }
        .student-dashboard-premium .course-info h3 { font-size: 18px; font-weight: 700; color: #1f2937; margin-bottom: 6px; }
        .student-dashboard-premium .course-meta { display: flex; flex-wrap: wrap; align-items: center; gap: 16px; color: #6b7280; font-size: 14px; }
        .student-dashboard-premium .course-meta i { margin-right: 5px; }
        .student-dashboard-premium .course-progress { width: 120px; text-align: center; }
        .student-dashboard-premium .progress-value { font-size: 24px; font-weight: 700; color: #667eea; margin-bottom: 4px; }
        .student-dashboard-premium .progress-bar { height: 8px; background: rgba(226,232,240,0.8); border-radius: 4px; overflow: hidden; margin-top: 16px; }
        .student-dashboard-premium .progress-fill { height: 100%; border-radius: 4px; background: linear-gradient(135deg,#667eea,#764ba2); transition: width .5s ease; }
        .student-dashboard-premium .mentorship-card {
            background: linear-gradient(135deg, rgba(102,126,234,0.1), rgba(118,75,162,0.1));
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 16px;
            border: 1px solid rgba(102,126,234,0.2);
            transition: transform .3s ease;
        }
        .student-dashboard-premium .mentorship-card:hover { transform: translateY(-3px); }
        .student-dashboard-premium .mentorship-header { display: flex; align-items: center; gap: 16px; margin-bottom: 16px; }
        .student-dashboard-premium .mentor-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 18px;
        }
        .student-dashboard-premium .mentorship-details { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; }
        .student-dashboard-premium .session-status { padding: 8px 16px; border-radius: 50px; font-weight: 600; font-size: 12px; }
        .student-dashboard-premium .status-confirmed { background: rgba(16,185,129,0.2); color: #047857; }
        .student-dashboard-premium .status-pending { background: rgba(245,158,11,0.2); color: #92400e; }
        .student-dashboard-premium .quick-actions { display: grid; grid-template-columns: repeat(2,1fr); gap: 16px; margin-top: 24px; }
        .student-dashboard-premium .action-btn {
            background: #fff;
            border: 1px solid rgba(102,126,234,0.2);
            border-radius: 14px;
            padding: 20px;
            text-align: center;
            transition: all .3s ease;
            text-decoration: none;
            color: #1f2937;
        }
        .student-dashboard-premium .action-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(102,126,234,0.15); border-color: #667eea; }
        .student-dashboard-premium .action-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(102,126,234,0.1), rgba(118,75,162,0.1));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            color: #667eea;
            font-size: 20px;
        }
        @media (max-width: 768px) {
            .student-dashboard-premium .dashboard-header { flex-direction: column; align-items: flex-start; }
            .student-dashboard-premium .stats-grid { grid-template-columns: 1fr; }
            .student-dashboard-premium .quick-actions { grid-template-columns: 1fr; }
            .student-dashboard-premium .course-progress { width: 100%; text-align: left; }
            .student-dashboard-premium .mentorship-details { flex-direction: column; align-items: flex-start; }
        }
        @media (max-width: 480px) { .student-dashboard-premium { padding: 20px; } }
    </style>
@endpush

@php
    $stats = $stats ?? [];
    $dashboardStats = [
        'active_courses' => $stats['active_courses'] ?? 5,
        'completed_courses' => $stats['completed_courses'] ?? 12,
        'average_progress' => $stats['average_progress'] ?? 68,
        'total_hours' => $stats['total_hours'] ?? 124,
    ];
    $statCards = [
        [
            'label' => 'Cursos activos',
            'value' => $dashboardStats['active_courses'],
            'icon' => 'fa-book-open',
            'color' => 'linear-gradient(135deg,#667eea,#764ba2)',
            'trend' => '+2 este mes',
            'trend_color' => '#10b981',
            'trend_icon' => 'fa-arrow-up'
        ],
        [
            'label' => 'Completados',
            'value' => $dashboardStats['completed_courses'],
            'icon' => 'fa-circle-check',
            'color' => 'linear-gradient(135deg,#34d399,#10b981)',
            'trend' => '+3 este mes',
            'trend_color' => '#10b981',
            'trend_icon' => 'fa-arrow-up'
        ],
        [
            'label' => 'Progreso promedio',
            'value' => $dashboardStats['average_progress'] . '%',
            'icon' => 'fa-chart-line',
            'color' => 'linear-gradient(135deg,#38bdf8,#818cf8)',
            'trend' => '+8% este mes',
            'trend_color' => '#0ea5e9',
            'trend_icon' => 'fa-arrow-up'
        ],
        [
            'label' => 'Horas totales',
            'value' => $dashboardStats['total_hours'] . 'h',
            'icon' => 'fa-clock',
            'color' => 'linear-gradient(135deg,#a855f7,#7c3aed)',
            'trend' => '+18h esta semana',
            'trend_color' => '#7c3aed',
            'trend_icon' => 'fa-arrow-up'
        ],
    ];
    $courseProgress = $courseProgress ?? [
        ['title' => 'Desarrollo Full Stack con React', 'mentor' => 'Ana Garcia', 'modules' => 12, 'hours' => 45, 'progress' => 65, 'color' => 'linear-gradient(135deg,#667eea,#764ba2)'],
        ['title' => 'Diseno UX/UI Avanzado', 'mentor' => 'Carlos Ruiz', 'modules' => 8, 'hours' => 32, 'progress' => 42, 'color' => 'linear-gradient(135deg,#a855f7,#c084fc)'],
        ['title' => 'Machine Learning Fundamentals', 'mentor' => 'Laura Martinez', 'modules' => 15, 'hours' => 60, 'progress' => 28, 'color' => 'linear-gradient(135deg,#7c3aed,#a78bfa)'],
    ];
    $mentorships = $mentorships ?? [
        ['name' => 'Ana Garcia', 'avatar' => 'AG', 'specialty' => 'Full Stack Developer', 'date' => '15 Noviembre', 'hour' => '10:00 AM - 11:30 AM', 'status' => 'confirmada'],
        ['name' => 'Carlos Ruiz', 'avatar' => 'CR', 'specialty' => 'UX/UI Designer', 'date' => '18 Noviembre', 'hour' => '3:00 PM - 4:00 PM', 'status' => 'confirmada'],
        ['name' => 'Laura Martinez', 'avatar' => 'LM', 'specialty' => 'Data Scientist', 'date' => '22 Noviembre', 'hour' => '2:00 PM - 3:00 PM', 'status' => 'pendiente'],
    ];
    $upcomingEvents = $upcomingEvents ?? [
        ['icon' => 'fa-flag', 'title' => 'Entrega Proyecto Final', 'subtitle' => 'Curso Full Stack • 20 Nov', 'bg' => 'linear-gradient(135deg,#667eea,#764ba2)'],
        ['icon' => 'fa-file-alt', 'title' => 'Examen UX/UI', 'subtitle' => 'Curso Diseno • 25 Nov', 'bg' => 'linear-gradient(135deg,#a855f7,#c084fc)'],
    ];
@endphp

@section('student-content')
    <div class="student-dashboard-premium">
        <div class="dashboard-container">
            <div class="dashboard-header">
                <div class="user-welcome">
                    <h1 class="font-poppins">Hola, <span class="gradient-text">{{ auth()->user()->name ?? 'Estudiante' }}</span>! 👋</h1>
                    <p>Continua aprendiendo y alcanza tus metas educativas</p>
                </div>
                <div class="date-badge">
                    <i class="fa-solid fa-calendar-alt"></i>
                    <span id="studentDashboardDate"></span>
                </div>
            </div>

            <div class="stats-grid">
                @foreach ($statCards as $card)
                    <article class="stat-card">
                        <div class="stat-icon" style="background: {{ $card['color'] }};">
                            <i class="fa-solid {{ $card['icon'] }}"></i>
                        </div>
                        <div class="stat-body">
                            <p class="stat-label">{{ $card['label'] }}</p>
                            <p class="stat-value">{{ $card['value'] }}</p>
                            @if(!empty($card['trend']))
                                <p class="stat-trend"
                                   style="color: {{ $card['trend_color'] ?? '#10b981' }};">
                                    <i class="fa-solid {{ $card['trend_icon'] ?? 'fa-arrow-up' }}"></i>
                                    {{ $card['trend'] }}
                                </p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="dashboard-main">
                <div class="dashboard-left">
                    <div class="section-card">
                        <div class="section-header">
                            <h2 class="section-title font-poppins">Cursos en progreso</h2>
                            <a href="{{ route('student.courses') }}" class="view-all">Ver todos <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                        <div class="courses-list">
                            @foreach ($courseProgress as $course)
                                <div class="course-card">
                                    <div class="course-header">
                                        <div class="course-info">
                                            <h3>{{ $course['title'] }}</h3>
                                            <div class="course-meta">
                                                <span><i class="fa-solid fa-user"></i> {{ $course['mentor'] }}</span>
                                                <span><i class="fa-solid fa-layer-group"></i> {{ $course['modules'] }} modulos</span>
                                                <span><i class="fa-solid fa-clock"></i> {{ $course['hours'] }} horas</span>
                                            </div>
                                        </div>
                                        <div class="course-progress">
                                            <div class="progress-value">{{ $course['progress'] }}%</div>
                                            <div class="progress-label">Completado</div>
                                        </div>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ $course['progress'] }}%; background: {{ $course['color'] }};"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="section-card">
                        <h2 class="section-title font-poppins" style="margin-bottom:24px;">Acciones rapidas</h2>
                        <div class="quick-actions">
                            <a href="{{ route('student.courses') }}" class="action-btn">
                                <div class="action-icon"><i class="fa-solid fa-play-circle"></i></div>
                                <div class="action-label">Continuar aprendiendo</div>
                            </a>
                            <a href="{{ route('home') }}#courses" class="action-btn">
                                <div class="action-icon"><i class="fa-solid fa-search"></i></div>
                                <div class="action-label">Buscar cursos</div>
                            </a>
                            <a href="{{ route('mentor-market.index') }}" class="action-btn">
                                <div class="action-icon"><i class="fa-solid fa-calendar-check"></i></div>
                                <div class="action-label">Agendar mentoria</div>
                            </a>
                            <a href="#" class="action-btn">
                                <div class="action-icon"><i class="fa-solid fa-certificate"></i></div>
                                <div class="action-label">Mis certificados</div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="dashboard-right">
                    <div class="section-card">
                        <div class="section-header">
                            <h2 class="section-title font-poppins">Proximas mentorias</h2>
                            <a href="{{ route('student.mentorias') }}" class="view-all">Ver todas <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                        <div class="mentorship-list">
                            @foreach ($mentorships as $mentorship)
                                <div class="mentorship-card">
                                    <div class="mentorship-header">
                                        <div class="mentor-avatar">{{ $mentorship['avatar'] }}</div>
                                        <div class="mentor-info">
                                            <h4>{{ $mentorship['name'] }}</h4>
                                            <div class="mentor-specialty">{{ $mentorship['specialty'] }}</div>
                                        </div>
                                    </div>
                                    <div class="mentorship-details">
                                        <div class="session-time">
                                            <div class="session-date">{{ $mentorship['date'] }}</div>
                                            <div class="session-hour">{{ $mentorship['hour'] }}</div>
                                        </div>
                                        <span class="session-status {{ $mentorship['status'] === 'confirmada' ? 'status-confirmed' : 'status-pending' }}">
                                            {{ ucfirst($mentorship['status']) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="section-card">
                        <h2 class="section-title font-poppins" style="margin-bottom:24px;">Proximas fechas</h2>
                        <div style="display:flex;flex-direction:column;gap:16px;">
                            @foreach ($upcomingEvents as $event)
                                <div style="display:flex;align-items:center;gap:16px;padding:12px;background:rgba(102,126,234,0.05);border-radius:12px;">
                                    <div style="width:40px;height:40px;border-radius:10px;background:{{ $event['bg'] }};display:flex;align-items:center;justify-content:center;color:#fff;">
                                        <i class="fa-solid {{ $event['icon'] }}"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight:600;color:#1f2937;">{{ $event['title'] }}</div>
                                        <div style="font-size:14px;color:#6b7280;">{{ $event['subtitle'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dateEl = document.getElementById('studentDashboardDate');
            if (dateEl) {
                const formatter = new Intl.DateTimeFormat('es-PE', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                const formatted = formatter.format(new Date());
                dateEl.textContent = formatted.charAt(0).toUpperCase() + formatted.slice(1);
            }

            document.querySelectorAll('.student-dashboard-premium .action-btn').forEach(button => {
                button.addEventListener('click', () => {
                    button.style.transform = 'scale(0.98)';
                    setTimeout(() => button.style.transform = '', 180);
                });
            });

            document.querySelectorAll('.student-dashboard-premium .progress-fill').forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => { bar.style.width = width; }, 300);
            });
        });
    </script>
@endpush
