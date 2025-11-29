@extends('layouts.student')

@section('student-title', 'Panel del estudiante')
@section('student-subtitle', 'Revisa tus cursos y mentorías')

@push('styles')
    <style>
        /* Ajustes de tarjetas a la paleta morada y sin íconos/switch de tema */
        .hero-card {
            border-radius: 14px;
            padding: 20px 24px;
            background: linear-gradient(90deg, rgba(124,58,237,0.14), rgba(139,92,246,0.12));
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }
        .hero-title { font-size: 20px; font-weight: 900; color: #2d2f38; }
        .hero-sub { color: #7c7f93; }

        .stats-grid { gap: 18px; margin-top: 8px; }
        .stat-card {
            background: #fff;
            border: 1px solid rgba(124,58,237,0.12);
            color: #1f2937;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px;
            border-radius: 16px;
            box-shadow: 0 12px 28px rgba(124,58,237,0.12);
        }
        .stat-label { color: #94a3b8; font-weight:700; text-transform: uppercase; letter-spacing: 0.08em; font-size: 12px; }
        .stat-value { font-size: 28px; font-weight:900; color: #7c3aed; }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 20px;
            align-items: start;
        }
        .course-list .content-card {
            background: #fff;
            border: 1px solid rgba(124,58,237,0.12);
            box-shadow: 0 12px 28px rgba(124,58,237,0.08);
        }
        .progress-bar-wrap { background: rgba(124,58,237,0.08); height:10px; border-radius:6px; overflow:hidden; }
        .progress-bar { height:10px; border-radius:6px; background: linear-gradient(90deg,#7c3aed,#8b5cf6); }

        .theme-toggle { display:none !important; } /* remover botón de cambio de tema */
    </style>
@endpush

@section('student-widgets')
    <div class="stat-card">
        <div>
            <div class="stat-label">Cursos Activos</div>
            <div class="stat-value">5</div>
        </div>
    </div>
    <div class="stat-card">
        <div>
            <div class="stat-label">Completados</div>
            <div class="stat-value">12</div>
        </div>
    </div>
    <div class="stat-card">
        <div>
            <div class="stat-label">Progreso Promedio</div>
            <div class="stat-value">68%</div>
        </div>
    </div>
    <div class="stat-card">
        <div>
            <div class="stat-label">Horas Totales</div>
            <div class="stat-value">124h</div>
        </div>
    </div>
@endsection

@section('student-content')
    <div class="hero-card">
        <div>
            <div class="hero-title">¡Hola, {{ auth()->user()->name ?? 'Estudiante' }}! 👋</div>
            <div class="hero-sub">Continúa aprendiendo y alcanza tus metas educativas</div>
        </div>
        <div>
            <!-- espacio para acciones rápidas si se requiere -->
        </div>
    </div>

    <div class="dashboard-grid" style="margin-top:18px;">
        <div class="course-list">
            <div class="content-card">
                <h2 style="color:#1f2937;">Cursos en Progreso</h2>
                <div style="margin-top:12px; display:flex; flex-direction:column; gap:12px;">
                    <div style="padding:12px; border-radius:10px; background:rgba(124,58,237,0.05); display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <div style="font-weight:800; color:#1f2937;">Desarrollo Full Stack</div>
                            <div style="font-size:12px; color:#6b7280;">Ana García · 12 módulos</div>
                        </div>
                        <div style="text-align:right; width:120px;">
                            <div style="font-weight:800; color:#7c3aed;">65%</div>
                        </div>
                        <div style="width:100%; margin-left:16px;">
                            <div class="progress-bar-wrap">
                                <div class="progress-bar" style="width:65%;"></div>
                            </div>
                        </div>
                    </div>

                    <div style="padding:12px; border-radius:10px; background:rgba(124,58,237,0.05); display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <div style="font-weight:800; color:#1f2937;">Diseño UX/UI</div>
                            <div style="font-size:12px; color:#6b7280;">Carlos Ruiz · 8 módulos</div>
                        </div>
                        <div style="text-align:right; width:120px;">
                            <div style="font-weight:800; color:#7c3aed;">42%</div>
                        </div>
                        <div style="width:100%; margin-left:16px;">
                            <div class="progress-bar-wrap">
                                <div class="progress-bar" style="width:42%; background:linear-gradient(90deg,#a855f7,#c084fc);"></div>
                            </div>
                        </div>
                    </div>

                    <div style="padding:12px; border-radius:10px; background:rgba(124,58,237,0.05); display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <div style="font-weight:800; color:#1f2937;">Machine Learning</div>
                            <div style="font-size:12px; color:#6b7280;">Laura Martínez · 15 módulos</div>
                        </div>
                        <div style="text-align:right; width:120px;">
                            <div style="font-weight:800; color:#7c3aed;">28%</div>
                        </div>
                        <div style="width:100%; margin-left:16px;">
                            <div class="progress-bar-wrap">
                                <div class="progress-bar" style="width:28%; background:linear-gradient(90deg,#7c3aed,#a78bfa);"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="content-card">
                <h2 style="color:#1f2937;">Próximas Mentorías</h2>
                <div style="margin-top:12px; display:flex; flex-direction:column; gap:12px;">
                    <div style="padding:12px; border-radius:10px; background:rgba(124,58,237,0.05); display:flex; gap:12px; align-items:center;">
                        <div style="width:40px; height:40px; border-radius:999px; background:linear-gradient(90deg,#7c3aed,#8b5cf6); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700;">AG</div>
                        <div style="flex:1;">
                            <div style="font-weight:800; color:#1f2937;">Ana García</div>
                            <div style="font-size:12px; color:#6b7280;">Full Stack · 15 Nov · 10:00 AM</div>
                        </div>
                        <div><span style="background:#10b981; color:#03291f; padding:6px 8px; border-radius:8px; font-weight:700; font-size:12px;">Confirmada</span></div>
                    </div>

                    <div style="padding:12px; border-radius:10px; background:rgba(124,58,237,0.05); display:flex; gap:12px; align-items:center;">
                        <div style="width:40px; height:40px; border-radius:999px; background:linear-gradient(90deg,#a855f7,#c084fc); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700;">CR</div>
                        <div style="flex:1;">
                            <div style="font-weight:800; color:#1f2937;">Carlos Ruiz</div>
                            <div style="font-size:12px; color:#6b7280;">UX/UI · 18 Nov · 3:00 PM</div>
                        </div>
                        <div><span style="background:#10b981; color:#03291f; padding:6px 8px; border-radius:8px; font-weight:700; font-size:12px;">Confirmada</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
