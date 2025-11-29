<?php $__env->startSection('student-title', 'Panel del estudiante'); ?>
<?php $__env->startSection('student-subtitle', 'Revisa tus cursos y mentorías'); ?>

<?php $__env->startSection('student-actions'); ?>
    <button id="theme-toggle" class="theme-toggle" title="Cambiar tema">
        <span class="toggle-sun">☀️</span>
        <span class="toggle-moon">🌙</span>
    </button>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* Tema oscuro personalizado que adapta el dashboard a las imágenes */
        body.dark {
            background: linear-gradient(130deg, #0f1724 0%, #071025 45%, #071429 100%) !important;
            color: #cbd5e1;
        }
        body.dark .student-sidebar {
            background: linear-gradient(180deg, #07142a 0%, #071022 100%);
            border-color: rgba(255,255,255,0.03);
            color: #cbd5e1;
            box-shadow: none;
        }
        body.dark .student-brand p, body.dark .student-brand h2 { color: #e6eefc; }
        body.dark .student-nav-link { color: #cbd5e1; }
        body.dark .student-nav-link.active { background: linear-gradient(90deg,#6c47ff,#8b5cf6); color: #fff; }
        body.dark .student-main {
            background: linear-gradient(180deg, rgba(8,10,20,0.6), rgba(7,10,20,0.6));
            border: 1px solid rgba(255,255,255,0.03);
            box-shadow: none;
            color: #e6eefc;
        }
        body.dark .student-header { border-bottom-color: rgba(255,255,255,0.02); }

        /* Hero / greeting banner */
        .hero-card {
            border-radius: 14px;
            padding: 20px 24px;
            background: linear-gradient(90deg, rgba(104,78,255,0.14), rgba(139,92,246,0.08));
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }
        .hero-title { font-size: 20px; font-weight: 900; color: #f8fafc; }
        .hero-sub { color: #c7d2fe; }

        /* Estadísticas - estilo oscuro */
        .stats-grid { gap: 18px; margin-top: 8px; }
        .stat-card {
            background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
            border: 1px solid rgba(255,255,255,0.03);
            color: #e6eefc;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px;
            border-radius: 12px;
        }
        .stat-label { color: #9ca3af; font-weight:700; }
        .stat-value { font-size: 28px; font-weight:900; color: #fff; }
        .stat-pill { width:36px; height:36px; border-radius:8px; }

        /* Layout principal: columnas como en la imagen */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 20px;
            align-items: start;
        }
        .course-list .content-card {
            background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
            border: 1px solid rgba(255,255,255,0.03);
        }
        .progress-bar-wrap { background: rgba(255,255,255,0.03); height:10px; border-radius:6px; overflow:hidden; }
        .progress-bar { height:10px; border-radius:6px; }

        /* Theme toggle */
        .theme-toggle { background: transparent; border: 1px solid rgba(255,255,255,0.06); padding:8px 10px; border-radius:12px; color: #e6eefc; cursor:pointer; display:inline-flex; gap:8px; align-items:center; }
        .theme-toggle .toggle-moon { display:none; }
        body.dark .theme-toggle .toggle-sun { display:none; }
        body.dark .theme-toggle .toggle-moon { display:inline; }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('student-widgets'); ?>
    <div class="stat-card">
        <div>
            <div class="stat-label">Cursos Activos</div>
            <div class="stat-value">5</div>
        </div>
        <div class="stat-pill" style="background:linear-gradient(90deg,#4f46e5,#8b5cf6);"></div>
    </div>
    <div class="stat-card">
        <div>
            <div class="stat-label">Completados</div>
            <div class="stat-value">12</div>
        </div>
        <div class="stat-pill" style="background:linear-gradient(90deg,#10b981,#34d399);"></div>
    </div>
    <div class="stat-card">
        <div>
            <div class="stat-label">Progreso Promedio</div>
            <div class="stat-value">68%</div>
        </div>
        <div class="stat-pill" style="background:linear-gradient(90deg,#7c3aed,#c084fc);"></div>
    </div>
    <div class="stat-card">
        <div>
            <div class="stat-label">Horas Totales</div>
            <div class="stat-value">124h</div>
        </div>
        <div class="stat-pill" style="background:linear-gradient(90deg,#f97316,#fb923c);"></div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('student-content'); ?>
    <div class="hero-card">
        <div>
            <div class="hero-title">¡Hola, <?php echo e(auth()->user()->name ?? 'Estudiante'); ?>! 👋</div>
            <div class="hero-sub">Continúa aprendiendo y alcanza tus metas educativas</div>
        </div>
        <div>
            <!-- espacio para acciones rápidas si se requiere -->
        </div>
    </div>

    <div class="dashboard-grid" style="margin-top:18px;">
        <div class="course-list">
            <div class="content-card">
                <h2 style="color:#e6eefc;">Cursos en Progreso</h2>
                <div style="margin-top:12px; display:flex; flex-direction:column; gap:12px;">
                    <div style="padding:12px; border-radius:10px; background:rgba(255,255,255,0.02); display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <div style="font-weight:800; color:#fff;">Desarrollo Full Stack</div>
                            <div style="font-size:12px; color:#9ca3af;">Ana García · 12 módulos</div>
                        </div>
                        <div style="text-align:right; width:120px;">
                            <div style="font-weight:800; color:#e6eefc;">65%</div>
                        </div>
                        <div style="width:100%; margin-left:16px;">
                            <div class="progress-bar-wrap">
                                <div class="progress-bar" style="width:65%; background:linear-gradient(90deg,#6c47ff,#8b5cf6);"></div>
                            </div>
                        </div>
                    </div>

                    <div style="padding:12px; border-radius:10px; background:rgba(255,255,255,0.02); display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <div style="font-weight:800; color:#fff;">Diseño UX/UI</div>
                            <div style="font-size:12px; color:#9ca3af;">Carlos Ruiz · 8 módulos</div>
                        </div>
                        <div style="text-align:right; width:120px;">
                            <div style="font-weight:800; color:#e6eefc;">42%</div>
                        </div>
                        <div style="width:100%; margin-left:16px;">
                            <div class="progress-bar-wrap">
                                <div class="progress-bar" style="width:42%; background:linear-gradient(90deg,#f472b6,#a78bfa);"></div>
                            </div>
                        </div>
                    </div>

                    <div style="padding:12px; border-radius:10px; background:rgba(255,255,255,0.02); display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <div style="font-weight:800; color:#fff;">Machine Learning</div>
                            <div style="font-size:12px; color:#9ca3af;">Laura Martínez · 15 módulos</div>
                        </div>
                        <div style="text-align:right; width:120px;">
                            <div style="font-weight:800; color:#e6eefc;">28%</div>
                        </div>
                        <div style="width:100%; margin-left:16px;">
                            <div class="progress-bar-wrap">
                                <div class="progress-bar" style="width:28%; background:linear-gradient(90deg,#60a5fa,#7c3aed);"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="content-card">
                <h2 style="color:#e6eefc;">Próximas Mentorías</h2>
                <div style="margin-top:12px; display:flex; flex-direction:column; gap:12px;">
                    <div style="padding:12px; border-radius:10px; background:rgba(255,255,255,0.02); display:flex; gap:12px; align-items:center;">
                        <div style="width:40px; height:40px; border-radius:999px; background:linear-gradient(90deg,#6366f1,#8b5cf6); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700;">AG</div>
                        <div style="flex:1;">
                            <div style="font-weight:800; color:#fff;">Ana García</div>
                            <div style="font-size:12px; color:#9ca3af;">Full Stack · 15 Nov · 10:00 AM</div>
                        </div>
                        <div><span style="background:#10b981; color:#03291f; padding:6px 8px; border-radius:8px; font-weight:700; font-size:12px;">Confirmada</span></div>
                    </div>

                    <div style="padding:12px; border-radius:10px; background:rgba(255,255,255,0.02); display:flex; gap:12px; align-items:center;">
                        <div style="width:40px; height:40px; border-radius:999px; background:linear-gradient(90deg,#f472b6,#a78bfa); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700;">CR</div>
                        <div style="flex:1;">
                            <div style="font-weight:800; color:#fff;">Carlos Ruiz</div>
                            <div style="font-size:12px; color:#9ca3af;">UX/UI · 18 Nov · 3:00 PM</div>
                        </div>
                        <div><span style="background:#10b981; color:#03291f; padding:6px 8px; border-radius:8px; font-weight:700; font-size:12px;">Confirmada</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Script simple para alternar tema y persistir en localStorage
        (function(){
            const key = 'skillnest-theme';
            const btn = document.getElementById('theme-toggle');
            function applyTheme(t){
                if(t === 'dark') document.documentElement.classList.add('dark');
                else document.documentElement.classList.remove('dark');
            }
            // Inicial: preferencia guardada o modo sistema
            const saved = localStorage.getItem(key);
            if(saved) applyTheme(saved);
            else {
                const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                applyTheme(prefersDark ? 'dark' : 'light');
            }
            if(btn){
                btn.addEventListener('click', function(){
                    const isDark = document.documentElement.classList.contains('dark');
                    const next = isDark ? 'light' : 'dark';
                    applyTheme(next);
                    localStorage.setItem(key, next);
                });
            }
        })();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/student/dashboard.blade.php ENDPATH**/ ?>