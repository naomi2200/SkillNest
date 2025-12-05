@extends('layouts.mentor')

@section('mentor-title', 'Mis cursos')
@section('mentor-subtitle', 'Gestiona y organiza todos tus cursos creados')

@push('styles')
    <style>
        .mis-cursos-page * {
            font-family: 'Inter', sans-serif;
        }

        .mis-cursos-page .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        .mis-cursos-page .fa,
        .mis-cursos-page .fa-solid,
        .mis-cursos-page .fas {
            font-family: 'Font Awesome 6 Free' !important;
            font-weight: 900;
        }

        .mis-cursos-page .fa-regular {
            font-family: 'Font Awesome 6 Free' !important;
            font-weight: 400;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .mis-cursos-page .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        .mis-cursos-page .shadow-soft {
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.25);
        }

        .mis-cursos-page .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .mis-cursos-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            align-items: center;
        }

        .mis-cursos-search {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 14px;
            border: 1px solid rgba(99, 102, 241, 0.18);
            background: #fff;
            box-shadow: 0 12px 25px rgba(15, 23, 42, 0.06);
        }

        .mis-cursos-search input {
            border: none;
            outline: none;
            min-width: 220px;
        }

        .mis-cursos-actions .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            transition: all 0.3s ease;
        }

        .mis-cursos-actions .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(102, 126, 234, 0.35);
        }

        .mis-cursos-page {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .mis-cursos-header {
            background: #fff;
            border-radius: 24px;
            padding: 26px 30px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }

        .mis-cursos-header .date-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 999px;
            background: rgba(102, 126, 234, 0.12);
            color: #4c1d95;
            font-weight: 600;
        }

        .mis-cursos-header .header-icon {
            width: 52px;
            height: 52px;
            border-radius: 18px;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.3rem;
            margin-bottom: 12px;
        }

        .mis-cursos-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 10px;
        }

        .mis-cursos-stats .stats-card {
            background: #fff;
            border-radius: 18px;
            padding: 18px;
            border: 1px solid rgba(226,232,240,0.85);
            box-shadow: 0 12px 24px rgba(15,23,42,0.08);
            display: flex;
            align-items: center;
            gap: 12px;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .mis-cursos-stats .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 32px rgba(99,102,241,0.18);
        }

        .mis-cursos-stats .stats-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #fff;
            flex-shrink: 0;
        }

        .mis-cursos-stats .stats-card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .mis-cursos-stats .stats-card-label {
            color: #94a3b8;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .08em;
            font-weight: 700;
        }

        .mis-cursos-stats .stats-card-value {
            font-size: 28px;
            font-weight: 800;
            color: #1f2937;
        }

        .mis-cursos-stats .stats-card-trend {
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .mis-cursos-filters {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 22px;
            padding: 18px;
            border: 1px solid rgba(99, 102, 241, 0.1);
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 16px;
        }

        .mis-cursos-filter-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .mis-cursos-filter-btn {
            padding: 8px 18px;
            border-radius: 999px;
            border: 1px solid rgba(99, 102, 241, 0.25);
            background: transparent;
            color: #4b5563;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .mis-cursos-filter-btn.active,
        .mis-cursos-filter-btn:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.18), rgba(118, 75, 162, 0.18));
            color: #5b21b6;
            border-color: transparent;
        }

        .mis-cursos-table {
            background: #fff;
            border-radius: 26px;
            box-shadow: 0 25px 50px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .mis-cursos-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .mis-cursos-table thead {
            background: linear-gradient(135deg, #f8f9ff, #f1f4ff);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.04em;
            color: #94a3b8;
        }

        .mis-cursos-table th,
        .mis-cursos-table td {
            padding: 18px 20px;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            text-align: left;
        }

        .mis-cursos-table tbody tr {
            transition: background 0.2s ease;
        }

        .mis-cursos-table tbody tr:hover {
            background: rgba(102, 126, 234, 0.06);
        }

        .mis-cursos-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .badge-published { background: rgba(34, 197, 94, 0.18); color: #047857; }
        .badge-review { background: rgba(250, 176, 5, 0.2); color: #a16207; }
        .badge-draft { background: rgba(99, 102, 241, 0.16); color: #4338ca; }
        .badge-archived { background: rgba(248, 113, 113, 0.18); color: #b91c1c; }

        .mis-cursos-progress {
            width: 120px;
            height: 8px;
            border-radius: 999px;
            background: rgba(148, 163, 184, 0.25);
            overflow: hidden;
        }

        .mis-cursos-progress-fill {
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .mis-cursos-rating {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #fbbf24;
        }

        .mis-cursos-action-btn {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            border: none;
            background: rgba(99, 102, 241, 0.12);
            color: #4c51bf;
            cursor: pointer;
            transition: transform 0.2s ease, background 0.2s ease;
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .mis-cursos-action-group {
            display: flex;
            gap: 6px;
            align-items: center;
            justify-content: center;
        }

        .mis-cursos-action-group form {
            margin: 0;
        }

        .mis-cursos-action-btn:hover {
            transform: translateY(-2px);
            background: rgba(99, 102, 241, 0.2);
        }

        .mis-cursos-action-btn.delete {
            background: rgba(248, 113, 113, 0.15);
            color: #b91c1c;
        }

        .mis-cursos-action-btn.delete:hover {
            background: rgba(248, 113, 113, 0.25);
            color: #991b1b;
        }

        .mis-cursos-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .mis-cursos-summary-card {
            padding: 24px;
            border-radius: 22px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .mis-cursos-summary-card::after {
            content: "";
            position: absolute;
            inset: 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 18px;
        }

        .mis-cursos-summary-card .summary-icon {
            width: 44px;
            height: 44px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        @media (max-width: 768px) {
            .mis-cursos-actions {
                flex-direction: column;
                align-items: flex-start;
            }
            .mis-cursos-search,
            .mis-cursos-search input {
                width: 100%;
            }
            .mis-cursos-filters {
                flex-direction: column;
                align-items: flex-start;
            }
            .mis-cursos-table {
                overflow-x: auto;
            }
            .mis-cursos-table table {
                min-width: 820px;
            }
        }
    </style>
@endpush

@section('mentor-actions')
    <div class="mis-cursos-actions">
        <form action="{{ route('mentor.courses') }}" method="GET" class="mis-cursos-search">
            <i class="fa-solid fa-search text-gray-400"></i>
            <input type="text"
                   name="q"
                   value="{{ request('q') }}"
                   placeholder="Buscar cursos..."
                   aria-label="Buscar cursos">
        </form>
        <a href="{{ route('mentor.courses.create') }}" class="btn-primary shadow-soft">
            <i class="fa-solid fa-plus"></i> Nuevo curso
        </a>
    </div>
@endsection

@section('mentor-content')
    @php
        $draftCount = $courses->where('status', 'borrador')->count();
        $pendingCount = $courses->where('status', 'pendiente')->count();
        $approvedCount = $courses->where('status', 'aprobado')->count();
        $archivedCount = $courses->where('status', 'rechazado')->count();
        $totalCourses = $courses->count();
        $totalStudents = $courses->sum(fn($course) => $course->estudiantes_count ?? $course->students_count ?? 0);
        $statusMap = [
            'aprobado' => ['class' => 'badge-published', 'label' => 'Publicado', 'icon' => 'fa-solid fa-check'],
            'pendiente' => ['class' => 'badge-review', 'label' => 'En revisión', 'icon' => 'fa-solid fa-clock'],
            'borrador' => ['class' => 'badge-draft', 'label' => 'Borrador', 'icon' => 'fa-solid fa-pen'],
            'rechazado' => ['class' => 'badge-archived', 'label' => 'Archivado', 'icon' => 'fa-solid fa-box-archive'],
        ];
        $statCards = [
            [
                'label' => 'Total cursos',
                'value' => $totalCourses,
                'icon' => 'fa-layer-group',
                'color' => 'linear-gradient(135deg,#667eea,#764ba2)',
                'trend' => '+2 este mes',
                'trend_color' => '#10b981',
                'trend_icon' => 'fa-arrow-up',
            ],
            [
                'label' => 'Publicados',
                'value' => $approvedCount,
                'icon' => 'fa-badge-check',
                'color' => 'linear-gradient(135deg,#34d399,#10b981)',
                'trend' => 'Cursos disponibles',
                'value_color' => '#059669',
                'trend_color' => '#6b7280',
                'trend_icon' => 'fa-book',
            ],
            [
                'label' => 'En revisión',
                'value' => $pendingCount,
                'icon' => 'fa-clock',
                'color' => 'linear-gradient(135deg,#fbbf24,#f97316)',
                'trend' => 'Esperando aprobación',
                'value_color' => '#d97706',
                'trend_color' => '#d97706',
                'trend_icon' => 'fa-hourglass-half',
            ],
            [
                'label' => 'Borradores',
                'value' => $draftCount,
                'icon' => 'fa-pen',
                'color' => 'linear-gradient(135deg,#a855f7,#7c3aed)',
                'trend' => 'En proceso',
                'value_color' => '#7c3aed',
                'trend_color' => '#7c3aed',
                'trend_icon' => 'fa-spinner',
            ],
        ];
    @endphp

    <div class="mis-cursos-page animate-fade-in-up">
        <section class="mis-cursos-header card-hover">
            <div>
                <p class="date-pill">
                    <i class="fa-solid fa-calendar-alt"></i>
                    <span id="misCursosCurrentDate"></span>
                </p>
                <h2 class="font-poppins text-2xl mt-2">Resumen general</h2>
                <p class="text-gray-500 mt-1">Monitorea el estado y rendimiento de tus cursos publicados y en progreso.</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Estudiantes activos</p>
                <p class="text-3xl font-bold gradient-text">{{ $totalStudents }}</p>
            </div>
        </section>

        <section class="mis-cursos-stats">
            @foreach ($statCards as $card)
                <article class="stats-card">
                    <div class="stats-card-icon" style="background: {{ $card['color'] }};">
                        <i class="fa-solid {{ $card['icon'] }}"></i>
                    </div>
                    <div class="stats-card-body">
                        <p class="stats-card-label">{{ $card['label'] }}</p>
                        <p class="stats-card-value" style="color: {{ $card['value_color'] ?? '#1f2937' }};">
                            {{ $card['value'] }}
                        </p>
                        @if (!empty($card['trend']))
                            <p class="stats-card-trend" style="color: {{ $card['trend_color'] ?? '#94a3b8' }};">
                                @if (!empty($card['trend_icon']))
                                    <i class="fa-solid {{ $card['trend_icon'] }}"></i>
                                @endif
                                {{ $card['trend'] }}
                            </p>
                        @endif
                    </div>
                </article>
            @endforeach
        </section>

        <section class="mis-cursos-filters">
            <div class="mis-cursos-filter-buttons">
                <button class="mis-cursos-filter-btn active" data-filter="all">Todos</button>
                <button class="mis-cursos-filter-btn" data-filter="aprobado">Publicados</button>
                <button class="mis-cursos-filter-btn" data-filter="borrador">Borradores</button>
                <button class="mis-cursos-filter-btn" data-filter="pendiente">En revisión</button>
                <button class="mis-cursos-filter-btn" data-filter="rechazado">Archivados</button>
            </div>
            <div>
                <label class="text-gray-500 text-sm mr-3">Ordenar por:</label>
                <select class="border border-gray-200 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="recent">Recientes</option>
                    <option value="students">Más estudiantes</option>
                    <option value="rating">Mejor valoración</option>
                </select>
            </div>
        </section>

        <section class="mis-cursos-table">
            <table>
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Estado</th>
                        <th>Estudiantes</th>
                        <th>Progreso</th>
                        <th>Valoración</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        @php
                            $courseStatus = $course->status ?? 'borrador';
                            $reviewState = $course->review_status ?? null;
                            $visibleStatus = match($reviewState) {
                                'pending' => 'pendiente',
                                'approved' => 'aprobado',
                                'rejected' => 'rechazado',
                                default => $courseStatus,
                            };
                            $badge = $statusMap[$visibleStatus] ?? $statusMap['borrador'];
                            $studentCount = $course->estudiantes_count ?? $course->students_count ?? 0;
                            $progress = $course->progress_percentage ?? ($visibleStatus === 'aprobado' ? 100 : ($visibleStatus === 'pendiente' ? 60 : ($visibleStatus === 'borrador' ? 20 : 0)));
                            $progress = max(0, min(100, $progress));
                            $rating = $course->rating ?? $course->average_rating ?? null;
                            $reviews = $course->reviews_count ?? $course->total_reviews ?? 0;
                            $reviewBadgeClass = match($course->review_status) {
                                'approved' => 'badge-published',
                                'rejected' => 'badge-archived',
                                'pending' => 'badge-review',
                                default => 'badge-draft',
                            };
                            $reviewLabel = ucfirst($course->review_status ?? 'pendiente');
                        @endphp
                        <tr data-status="{{ $visibleStatus }}" data-course-id="{{ $course->id }}">
                            <td>
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-xl flex items-center justify-center text-xl gradient-text text-white" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                                        <i class="fa-solid fa-layer-group"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $course->title }}</strong>
                                        <p class="text-sm text-gray-500 mt-1">{{ $course->category }} • {{ $course->level ?? 'General' }}</p>
                                        <span class="mis-cursos-badge {{ $reviewBadgeClass }} mt-1 inline-flex items-center gap-2">
                                            <i class="fa-solid fa-clipboard-check"></i> {{ $reviewLabel }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="mis-cursos-badge {{ $badge['class'] }}">
                                    <i class="{{ $badge['icon'] }}"></i>
                                    {{ $badge['label'] }}
                                </span>
                            </td>
                            <td>
                                <div>
                                    <p class="font-bold text-lg text-gray-800">{{ $studentCount }}</p>
                                    <p class="text-xs text-gray-500">inscritos</p>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="flex justify-between text-sm text-gray-500 mb-1">
                                        <span>Completado</span>
                                        <span class="font-semibold text-purple-600">{{ $progress }}%</span>
                                    </div>
                                    <div class="mis-cursos-progress">
                                        <div class="mis-cursos-progress-fill" style="width: {{ $progress }}%;"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($rating)
                                    <div class="mis-cursos-rating">
                                        <i class="fa-solid fa-star"></i>
                                        <span class="font-semibold text-gray-800">{{ number_format($rating, 1) }}</span>
                                        <span class="text-gray-400 text-sm">({{ $reviews }})</span>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">Sin valoraciones</span>
                                @endif
                            </td>
                            <td>
                                <div class="mis-cursos-action-group">
                                    <a href="{{ route('cursos.editor', $course) }}" class="mis-cursos-action-btn" title="Editar curso">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    @if(Route::has('courses.classroom'))
                                        <a href="{{ route('courses.classroom', $course) }}" class="mis-cursos-action-btn" title="Ver aula">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('cursos.editor', $course) }}#stats" class="mis-cursos-action-btn" title="Estadísticas">
                                        <i class="fa-solid fa-chart-line"></i>
                                    </a>
                                    <button type="button"
                                            class="mis-cursos-action-btn delete mis-cursos-delete-btn"
                                            data-delete-url="{{ route('cursos.destroy', $course) }}"
                                            title="Eliminar curso">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-gray-500">
                                Aún no has creado cursos.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <section class="mis-cursos-summary">
            <div class="mis-cursos-summary-card shadow-hover" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                <h4>Ingresos últimos 30 días</h4>
                <h2>S/ 2,450</h2>
            </div>
            <div class="mis-cursos-summary-card shadow-hover" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                <h4>Nuevos estudiantes</h4>
                <h2>12</h2>
            </div>
            <div class="mis-cursos-summary-card shadow-hover" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                <h4>Valoración promedio</h4>
                <h2>4.7 / 5</h2>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dateEl = document.getElementById('misCursosCurrentDate');
            if (dateEl) {
                const formatter = new Intl.DateTimeFormat('es-PE', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                const formatted = formatter.format(new Date());
                dateEl.textContent = formatted.charAt(0).toUpperCase() + formatted.slice(1);
            }

            const filterButtons = document.querySelectorAll('.mis-cursos-filter-btn');
            const rows = document.querySelectorAll('.mis-cursos-table tbody tr[data-status]');

            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    const filter = button.dataset.filter;
                    rows.forEach(row => {
                        const matches = filter === 'all' || row.dataset.status === filter;
                        row.style.display = matches ? '' : 'none';
                    });
                });
            });

            // Eliminación sin recargar la página (botón directo)
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            document.querySelectorAll('.mis-cursos-delete-btn').forEach(button => {
                button.addEventListener('click', () => {
                    if (!confirm('¿Seguro que deseas eliminar este curso?')) return;
                    const url = button.dataset.deleteUrl;
                    const row = button.closest('tr');
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: new URLSearchParams({ _method: 'DELETE' }),
                    }).then(response => {
                        if (!response.ok) throw new Error('Error al eliminar');
                        row?.remove();
                    }).catch(err => {
                        console.error(err);
                        alert('No se pudo eliminar el curso. Intenta nuevamente.');
                    });
                });
            });
        });
    </script>
@endpush
