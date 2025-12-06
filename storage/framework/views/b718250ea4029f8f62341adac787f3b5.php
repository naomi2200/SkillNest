<?php
    $categorias = collect($categorias ?? []);
    $cursos = collect($cursos ?? []);
    $mentores = collect($mentores ?? []);

    $statsEstudiantes = $total_estudiantes ?? '10K+';
    $statsRating = $rating_promedio ?? '4.8';
    $statsCursos = $total_cursos ?? null;

    if (!$statsCursos && class_exists(\App\Models\Curso::class)) {
        $statsCursos = \App\Models\Curso::count();
    }
    $statsCursos = $statsCursos ?: ($cursos->count() ?: '500+');

    $categoryIcons = [
        'fas fa-code',
        'fas fa-palette',
        'fas fa-chart-line',
        'fas fa-briefcase',
        'fas fa-camera',
        'fas fa-music',
    ];

    $categoryDescriptions = [
        'programacion' => 'Desarrollo web, mobile, backend y más.',
        'diseno' => 'UI/UX, gráfico, branding y más.',
        'marketing' => 'SEO, redes sociales y growth.',
        'negocios' => 'Emprendimiento, finanzas y gestión.',
        'fotografia' => 'Iluminación, edición y composición.',
        'musica' => 'Producción, teoría musical y performance.',
    ];

    if ($categorias->isEmpty() && class_exists(\App\Models\Curso::class)) {
        $categorias = \App\Models\Curso::query()
            ->selectRaw("COALESCE(NULLIF(category, ''), 'General') as categoria_nombre")
            ->selectRaw('COUNT(*) as cursos_count')
            ->groupBy('category')
            ->orderByDesc('cursos_count')
            ->limit(6)
            ->get()
            ->map(function ($categoria, $index) use ($categoryDescriptions, $categoryIcons) {
                $nombre = $categoria->categoria_nombre ?? 'General';
                $slug = \Illuminate\Support\Str::slug($nombre);
                return (object) [
                    'nombre' => $nombre,
                    'slug' => $slug,
                    'cursos_count' => $categoria->cursos_count ?? 0,
                    'descripcion' => $categoryDescriptions[$slug] ?? 'Explora cursos seleccionados para potenciar tu perfil profesional.',
                    'icono' => $categoryIcons[$index % count($categoryIcons)],
                ];
            });
    }

    if ($categorias->isEmpty()) {
        $categorias = collect([
            [
                'nombre' => 'Programación',
                'slug' => 'programacion',
                'cursos_count' => 234,
                'descripcion' => $categoryDescriptions['programacion'],
                'icono' => $categoryIcons[0],
            ],
            [
                'nombre' => 'Diseño',
                'slug' => 'diseno',
                'cursos_count' => 156,
                'descripcion' => $categoryDescriptions['diseno'],
                'icono' => $categoryIcons[1],
            ],
            [
                'nombre' => 'Marketing',
                'slug' => 'marketing',
                'cursos_count' => 98,
                'descripcion' => $categoryDescriptions['marketing'],
                'icono' => $categoryIcons[2],
            ],
            [
                'nombre' => 'Negocios',
                'slug' => 'negocios',
                'cursos_count' => 145,
                'descripcion' => $categoryDescriptions['negocios'],
                'icono' => $categoryIcons[3],
            ],
            [
                'nombre' => 'Fotografía',
                'slug' => 'fotografia',
                'cursos_count' => 67,
                'descripcion' => $categoryDescriptions['fotografia'],
                'icono' => $categoryIcons[4],
            ],
            [
                'nombre' => 'Música',
                'slug' => 'musica',
                'cursos_count' => 43,
                'descripcion' => $categoryDescriptions['musica'],
                'icono' => $categoryIcons[5],
            ],
        ])->map(fn ($categoria) => (object) $categoria);
    }

    if ($cursos->isEmpty() && class_exists(\App\Models\Curso::class)) {
        $cursos = \App\Models\Curso::query()
            ->with('mentor')
            ->withCount('purchases')
            ->orderByDesc('purchases_count')
            ->take(3)
            ->get();
    }

    if ($cursos->isEmpty()) {
        $cursos = collect([
            [
                'slug' => 'laravel-avanzado',
                'titulo' => 'Laravel Avanzado: De Cero a Experto',
                'categoria' => (object) ['nombre' => 'Programación'],
                'mentor' => (object) ['name' => 'Carlos Gómez'],
                'rating' => '4.8',
                'estudiantes_count' => 1234,
                'precio' => 149,
                'duracion' => '32 horas',
                'imagen' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80',
                'badge' => 'POPULAR',
                'descripcion' => 'Domina Laravel 10 con APIs RESTful, Livewire y testing.',
            ],
            [
                'slug' => 'vuejs-completo',
                'titulo' => 'Vue.js Completo: Frontend Moderno',
                'categoria' => (object) ['nombre' => 'Frontend'],
                'mentor' => (object) ['name' => 'María López'],
                'rating' => '4.9',
                'estudiantes_count' => 897,
                'precio' => 139,
                'duracion' => '28 horas',
                'imagen' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80',
                'badge' => 'NUEVO',
                'descripcion' => 'Aprende Vue 3, Composition API y despliega apps empresariales.',
            ],
            [
                'slug' => 'diseno-ux-ui',
                'titulo' => 'Diseño UX/UI: Interfaces Increíbles',
                'categoria' => (object) ['nombre' => 'Diseño'],
                'mentor' => (object) ['name' => 'Ana García'],
                'rating' => '4.7',
                'estudiantes_count' => 856,
                'precio' => 'Gratis',
                'duracion' => '24 horas',
                'imagen' => 'https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?auto=format&fit=crop&w=1200&q=80',
                'badge' => 'GRATIS',
                'descripcion' => 'Crea experiencias excepcionales con Figma y prototipado.',
            ],
        ])->map(fn ($curso) => (object) $curso);
    }

    if ($mentores->isEmpty() && class_exists(\App\Models\MentorProfile::class)) {
        $mentorQuery = \App\Models\MentorProfile::query()->with('user');
        if (\Illuminate\Support\Facades\Schema::hasColumn('mentor_profiles', 'rating')) {
            $mentorQuery->orderByDesc('rating');
        } else {
            $mentorQuery->latest();
        }
        $mentores = $mentorQuery->take(4)->get();
    }

    if ($mentores->isEmpty()) {
        $mentores = collect([
            [
                'nombre' => 'Carlos Gómez',
                'profesion' => 'Senior Laravel Developer',
                'rating' => '4.9',
                'sesiones' => 125,
                'tarifa' => 80,
            ],
            [
                'nombre' => 'María López',
                'profesion' => 'Frontend Expert',
                'rating' => '4.8',
                'sesiones' => 98,
                'tarifa' => 70,
            ],
            [
                'nombre' => 'Ana García',
                'profesion' => 'UX/UI Designer',
                'rating' => '5.0',
                'sesiones' => 156,
                'tarifa' => 90,
            ],
            [
                'nombre' => 'José Ramírez',
                'profesion' => 'Marketing Strategist',
                'rating' => '4.7',
                'sesiones' => 89,
                'tarifa' => 75,
            ],
        ])->map(fn ($mentor) => (object) $mentor);
    }

    $hasCheckoutRoute = \Illuminate\Support\Facades\Route::has('courses.checkout');
    $primaryCheckoutCourse = null;
    if ($hasCheckoutRoute && class_exists(\App\Models\Course::class)) {
        $primaryCheckoutCourse = \App\Models\Course::approved()->latest('id')->first()
            ?? \App\Models\Course::latest('id')->first();
    }

    $hasMentorBookRoute = \Illuminate\Support\Facades\Route::has('mentor.book.form');
    $mentorForBooking = null;
    if ($hasMentorBookRoute && class_exists(\App\Models\User::class)) {
        $mentorForBooking = \App\Models\User::where('role', 'mentor')
            ->latest('id')
            ->first();
    }

    $adminDashboardUrl = null;
    if (\Illuminate\Support\Facades\Route::has('admin.dashboard')) {
        $adminDashboardUrl = route('admin.dashboard');
    }
?>

<?php $__env->startSection('content'); ?>
<style>
    /* ===== ESTILOS MEJORADOS ===== */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    .hero-gradient {
        background: linear-gradient(140deg, #f8f9ff 0%, #eef2ff 100%);
        position: relative;
        overflow: hidden;
    }
    
    .hero-gradient::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 10% 20%, rgba(120, 119, 198, 0.1) 0%, transparent 20%),
            radial-gradient(circle at 90% 30%, rgba(255, 119, 198, 0.1) 0%, transparent 20%),
            radial-gradient(circle at 50% 80%, rgba(120, 220, 255, 0.1) 0%, transparent 20%);
    }
    
    /* Animaciones */
    @keyframes float {
        0%, 100% { transform: translateY(0px) translateX(0px); }
        33% { transform: translateY(-20px) translateX(15px); }
        66% { transform: translateY(10px) translateX(-10px); }
    }
    
    @keyframes slide-fade-in {
        from { 
            opacity: 0; 
            transform: translateY(30px) scale(0.95); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0) scale(1); 
        }
    }
    
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(102, 126, 234, 0.2); }
        50% { box-shadow: 0 0 30px rgba(102, 126, 234, 0.4); }
    }
    
    @keyframes shimmer {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }
    
    .floating-bubble {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.05));
        animation: float 15s ease-in-out infinite;
        will-change: transform;
        z-index: 1;
    }
    
    .animate-slide-in {
        animation: slide-fade-in 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        opacity: 0;
    }
    
    .glass-effect {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
    }
    
    .shadow-soft {
        box-shadow: 0 20px 40px -20px rgba(102, 126, 234, 0.15),
                    0 10px 20px -10px rgba(102, 126, 234, 0.1);
    }
    
    .shadow-hover {
        box-shadow: 0 25px 50px -12px rgba(102, 126, 234, 0.25);
        transition: box-shadow 0.3s ease;
    }
    
    .card-hover {
        transition: all 0.3s ease;
        border-radius: 16px;
        overflow: hidden;
    }
    
    .card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 30px 60px -12px rgba(102, 126, 234, 0.3);
    }
    
    .btn-primary {
        background: var(--primary-gradient);
        color: white;
        font-weight: 600;
        padding: 14px 32px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px -12px rgba(102, 126, 234, 0.4);
    }
    
    .gradient-text {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .gradient-primary {
        background: var(--primary-gradient);
    }
    
    .gradient-secondary {
        background: var(--secondary-gradient);
    }
    
    .gradient-accent {
        background: var(--accent-gradient);
    }
    
    .glass-dark {
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(10px);
    }
    
    /* Estilos específicos para secciones */
    .category-card {
        background: white;
        padding: 24px;
        border-radius: 16px;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .course-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .mentor-card {
        background: white;
        padding: 32px 24px;
        border-radius: 16px;
        text-align: center;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    /* Carrusel mejorado */
    .testimonial-slider {
        position: relative;
        overflow: hidden;
    }
    
    .slider-dots {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 24px;
    }
    
    .slider-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #e0e0e0;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .slider-dot.active {
        background: #667eea;
        transform: scale(1.2);
    }
    
    .slider-dot:hover {
        background: #a0a0a0;
    }
    
    /* Efecto de texto brillante */
    .shimmer-text {
        background: linear-gradient(90deg, #667eea, #764ba2, #667eea);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shimmer 3s linear infinite;
    }
</style>

<div class="relative">
    <!-- ===== HERO SECTION ===== -->
    <section class="pt-24 pb-20 md:pt-32 md:pb-28 hero-gradient relative overflow-hidden">
        <!-- Burbujas flotantes animadas -->
        <div class="floating-bubble" style="width: 300px; height: 300px; top: 10%; left: 5%; animation-duration: 20s;"></div>
        <div class="floating-bubble" style="width: 200px; height: 200px; bottom: 15%; right: 8%; animation-duration: 18s; animation-delay: -3s;"></div>
        <div class="floating-bubble" style="width: 150px; height: 150px; top: 40%; right: 15%; animation-duration: 22s; animation-delay: -5s;"></div>
        <div class="floating-bubble" style="width: 100px; height: 100px; bottom: 30%; left: 20%; animation-duration: 16s;"></div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <!-- Columna izquierda: Contenido principal -->
                    <div class="animate-slide-in" style="animation-delay: 0.1s;">
                        <!-- Badge destacado -->
                        <div class="inline-flex items-center px-5 py-2.5 rounded-full bg-white/80 backdrop-blur-sm shadow-soft mb-8">
                            <div class="w-2 h-2 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 mr-2 animate-pulse"></div>
                            <span class="text-sm font-semibold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                <i class="fas fa-bolt mr-2"></i>PLATAFORMA EDUCATIVA #1
                            </span>
                        </div>

                        <!-- Título principal -->
                        <h1 class="font-poppins text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                            <span class="block text-gray-900">Aprende Habilidades</span>
                            <span class="block shimmer-text mt-2">que Impulsan tu Carrera</span>
                        </h1>

                        <!-- Descripción -->
                        <p class="text-xl text-gray-600 mb-10 leading-relaxed">
                            Conectamos aprendices con expertos a través de cursos interactivos y 
                            mentorías personalizadas. Transforma tu futuro profesional con nuestra 
                            plataforma líder en educación online.
                        </p>

                        <!-- Barra de búsqueda -->
                        <div class="mb-12">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl blur opacity-20"></div>
                                <div class="relative glass-effect rounded-2xl shadow-soft">
                                    <form action="<?php echo e(route('home')); ?>" method="GET" class="flex flex-col sm:flex-row">
                                        <div class="flex-1 relative">
                                            <i class="fas fa-search absolute left-6 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                                            <input type="text"
                                                   name="q"
                                                   value="<?php echo e(request('q')); ?>"
                                                   placeholder="¿Qué quieres aprender hoy?"
                                                   class="w-full pl-14 pr-6 py-5 text-lg text-gray-700 rounded-l-2xl border-0 focus:ring-3 focus:ring-purple-200 focus:outline-none bg-transparent placeholder-gray-400">
                                        </div>
                                        <button type="submit"
                                                class="mt-2 sm:mt-0 btn-primary rounded-r-2xl px-10 py-5 text-lg">
                                            <i class="fas fa-search mr-3"></i>Explorar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Estadísticas -->
                        <div class="flex flex-wrap gap-x-12 gap-y-8 mb-12">
                            <div class="flex items-center group">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-book-open text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-3xl font-bold text-gray-900"><?php echo e($statsCursos); ?></div>
                                    <div class="text-gray-600 text-sm font-medium">Cursos Premium</div>
                                </div>
                            </div>
                            <div class="flex items-center group">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-users text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-3xl font-bold text-gray-900"><?php echo e($statsEstudiantes); ?></div>
                                    <div class="text-gray-600 text-sm font-medium">Estudiantes Activos</div>
                                </div>
                            </div>
                            <div class="flex items-center group">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-100 to-yellow-200 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-star text-yellow-600 text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-3xl font-bold text-gray-900"><?php echo e($statsRating); ?>/5</div>
                                    <div class="text-gray-600 text-sm font-medium">Rating Promedio</div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex flex-col sm:flex-row gap-5">
                            <a href="<?php echo e(Route::has('cursos.index') ? route('cursos.index') : url('/cursos')); ?>" 
                               class="btn-primary text-lg px-10 py-4">
                                <i class="fas fa-play-circle mr-3"></i>Explorar Cursos
                            </a>
                            <a href="<?php echo e(route('mentor-market.index')); ?>" 
                               class="border-2 border-gray-300 text-gray-700 font-semibold px-10 py-4 rounded-xl text-center hover:border-purple-500 hover:text-purple-600 hover:bg-purple-50 transition-all flex items-center justify-center text-lg">
                                <i class="fas fa-video mr-3"></i>Ver Mentorías
                            </a>
                        </div>

                        <!-- Enlaces rápidos -->
                        <div class="mt-10 flex flex-wrap items-center gap-4 text-sm">
                            <?php if($primaryCheckoutCourse && $hasCheckoutRoute): ?>
                                <a href="<?php echo e(route('courses.checkout', $primaryCheckoutCourse)); ?>" 
                                   class="inline-flex items-center gap-2 text-purple-600 font-semibold hover:text-purple-800 transition-colors px-4 py-2 rounded-lg hover:bg-purple-50">
                                    <i class="fas fa-shopping-cart"></i>
                                    Comprar curso destacado
                                </a>
                            <?php endif; ?>
                            <?php if($mentorForBooking && $hasMentorBookRoute): ?>
                                <a href="<?php echo e(route('mentor.book.form', $mentorForBooking)); ?>" 
                                   class="inline-flex items-center gap-2 text-purple-600 font-semibold hover:text-purple-800 transition-colors px-4 py-2 rounded-lg hover:bg-purple-50">
                                    <i class="fas fa-calendar-check"></i>
                                    Agendar mentoría
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Columna derecha: Dashboard interactivo -->
                    <div class="hidden lg:block relative">
                        <div class="relative w-full max-w-lg mx-auto">
                            <!-- Dashboard principal -->
                            <div class="glass-effect rounded-3xl shadow-soft overflow-hidden animate-slide-in" style="animation-delay: 0.3s;">
                                <!-- Header del dashboard -->
                                <div class="px-8 py-6 border-b border-gray-200/50 flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                        <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                        <div class="w-3 h-3 rounded-full bg-green-400"></div>
                                    </div>
                                    <div class="text-sm font-semibold text-gray-600">SkillNest Dashboard</div>
                                    <div class="text-xs text-gray-500">Online</div>
                                </div>

                                <!-- Contenido del dashboard -->
                                <div class="p-8">
                                    <!-- Progreso general -->
                                    <div class="mb-8">
                                        <div class="flex justify-between items-center mb-3">
                                            <span class="text-gray-700 font-medium">Tu progreso total</span>
                                            <span class="font-bold text-purple-600">65% Completado</span>
                                        </div>
                                        <div class="h-3 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full gradient-primary rounded-full animate-pulse-glow" style="width: 65%"></div>
                                        </div>
                                    </div>

                                    <!-- Cursos en progreso -->
                                    <div class="grid grid-cols-2 gap-4 mb-8">
                                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-5 border border-blue-100">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 rounded-lg gradient-primary flex items-center justify-center mr-4">
                                                    <i class="fab fa-laravel text-white text-xl"></i>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-900">Laravel</div>
                                                    <div class="text-xs text-gray-500">3/5 lecciones</div>
                                                </div>
                                            </div>
                                            <div class="mt-3 h-1.5 bg-blue-200 rounded-full overflow-hidden">
                                                <div class="h-full bg-blue-500 rounded-full" style="width: 60%"></div>
                                            </div>
                                        </div>
                                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-5 border border-purple-100">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center mr-4">
                                                    <i class="fab fa-figma text-white text-xl"></i>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-900">Figma UI</div>
                                                    <div class="text-xs text-gray-500">Completado ✓</div>
                                                </div>
                                            </div>
                                            <div class="mt-3 h-1.5 bg-purple-200 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-purple-500 to-pink-500 rounded-full" style="width: 100%"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Estadísticas personales -->
                                    <div class="flex justify-between pt-6 border-t border-gray-200/50">
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-gray-900">3</div>
                                            <div class="text-xs text-gray-500">Cursos activos</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-gray-900">24h</div>
                                            <div class="text-xs text-gray-500">Horas aprendidas</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-gray-900">2</div>
                                            <div class="text-xs text-gray-500">Certificados</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-gray-900">98%</div>
                                            <div class="text-xs text-gray-500">Satisfacción</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tarjeta flotante 1 -->
                            <div class="absolute -top-8 -right-8 animate-slide-in" style="animation-delay: 0.5s;">
                                <div class="bg-white rounded-2xl shadow-hover p-6 w-64 transform rotate-3 border border-gray-100">
                                    <div class="flex items-center mb-4">
                                        <div class="w-14 h-14 rounded-xl gradient-accent flex items-center justify-center mr-4">
                                            <i class="fab fa-vuejs text-white text-2xl"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900">Vue.js Masterclass</div>
                                            <div class="text-sm text-gray-500">María López</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600 mb-2">
                                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                                        <span class="font-semibold">4.9</span>
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-users mr-1"></i>
                                        <span>897 estudiantes</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-lg font-bold text-gray-900">S/ 139</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tarjeta flotante 2 -->
                            <div class="absolute -bottom-8 -left-8 animate-slide-in" style="animation-delay: 0.7s;">
                                <div class="bg-white rounded-2xl shadow-hover p-5 w-56 transform -rotate-3 border border-gray-100">
                                    <div class="flex items-center mb-4">
                                        <div class="w-12 h-12 rounded-xl gradient-secondary flex items-center justify-center mr-3">
                                            <i class="fas fa-trophy text-white text-xl"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900">Certificación</div>
                                            <div class="text-sm text-gray-500">Diseño UX Avanzado</div>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        Logro obtenido: Hoy
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CARRUSEL DE EMPRESAS ===== -->
    <section class="py-12 bg-white border-y border-gray-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <p class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-2">CONFÍAN EN NOSOTROS</p>
                <h3 class="text-2xl font-bold text-gray-800">Empresas líderes que confían en nuestros talentos</h3>
            </div>
            
            <div class="relative overflow-hidden">
                <div class="flex items-center justify-center space-x-12 animate-marquee whitespace-nowrap">
                    <!-- Logo 1 -->
                    <div class="flex flex-col items-center group">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <div class="text-3xl">💻</div>
                        </div>
                        <div class="font-bold text-gray-700">TechCorp</div>
                    </div>
                    
                    <!-- Logo 2 -->
                    <div class="flex flex-col items-center group">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-purple-50 to-purple-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <div class="text-3xl">🏢</div>
                        </div>
                        <div class="font-bold text-gray-700">DigitalPlus</div>
                    </div>
                    
                    <!-- Logo 3 -->
                    <div class="flex flex-col items-center group">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <div class="text-3xl">🚀</div>
                        </div>
                        <div class="font-bold text-gray-700">StartUpLab</div>
                    </div>
                    
                    <!-- Logo 4 -->
                    <div class="flex flex-col items-center group">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-yellow-50 to-yellow-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <div class="text-3xl">🎓</div>
                        </div>
                        <div class="font-bold text-gray-700">UniTech</div>
                    </div>
                    
                    <!-- Logo 5 -->
                    <div class="flex flex-col items-center group">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-pink-50 to-pink-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <div class="text-3xl">⭐</div>
                        </div>
                        <div class="font-bold text-gray-700">InnovateCo</div>
                    </div>
                    
                    <!-- Logo 6 -->
                    <div class="flex flex-col items-center group">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <div class="text-3xl">🌐</div>
                        </div>
                        <div class="font-bold text-gray-700">GlobalEd</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CATEGORÍAS ===== -->
    <section class="py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-poppins text-4xl font-bold text-gray-900 mb-4">Explora por Categoría</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Descubre cursos especializados en las áreas más demandadas del mercado actual
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $categoriaUrl = Route::has('cursos.categoria') && isset($categoria->slug)
                            ? route('cursos.categoria', $categoria->slug)
                            : (Route::has('cursos.index') ? route('cursos.index') : '#');
                        $categoriaDescripcion = $categoria->descripcion ?? $categoria->description ?? 'Explora cursos seleccionados para potenciar tu perfil profesional.';
                        $categoriaNombre = $categoria->nombre ?? $categoria->name ?? 'Categoría';
                        $categoriaIcono = $categoria->icono ?? $categoria->icon ?? 'fas fa-graduation-cap';
                        $categoriaCursosCount = $categoria->cursos_count ?? $categoria->courses_count ?? $categoria->cursos?->count() ?? 0;
                        
                        $gradientColors = [
                            ['from-blue-500', 'to-cyan-500'],
                            ['from-purple-500', 'to-pink-500'],
                            ['from-green-500', 'to-emerald-500'],
                            ['from-orange-500', 'to-yellow-500'],
                            ['from-indigo-500', 'to-blue-500'],
                            ['from-red-500', 'to-pink-500']
                        ];
                        $currentGradient = $gradientColors[$index % count($gradientColors)];
                    ?>
                    
                    <a href="<?php echo e($categoriaUrl); ?>" 
                       class="category-card group hover:shadow-hover animate-slide-in" 
                       style="animation-delay: <?php echo e($index * 0.1); ?>s">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br <?php echo e($currentGradient[0]); ?> <?php echo e($currentGradient[1]); ?> flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="<?php echo e($categoriaIcono); ?> text-white text-2xl"></i>
                            </div>
                            <span class="text-sm font-semibold px-3 py-1 rounded-full bg-gradient-to-r <?php echo e($currentGradient[0]); ?> <?php echo e($currentGradient[1]); ?> text-white">
                                <?php echo e($categoriaCursosCount); ?> cursos
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-transparent group-hover:bg-gradient-to-r <?php echo e($currentGradient[0]); ?> <?php echo e($currentGradient[1]); ?> group-hover:bg-clip-text transition-all duration-300">
                            <?php echo e($categoriaNombre); ?>

                        </h3>
                        <p class="text-gray-600 mb-6 leading-relaxed"><?php echo e($categoriaDescripcion); ?></p>
                        <div class="flex items-center text-sm font-semibold text-gray-700 group-hover:text-transparent group-hover:bg-gradient-to-r <?php echo e($currentGradient[0]); ?> <?php echo e($currentGradient[1]); ?> group-hover:bg-clip-text transition-all duration-300">
                            Explorar categoría
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform duration-300"></i>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="text-center mt-16">
                <a href="<?php echo e(Route::has('cursos.index') ? route('cursos.index') : url('/cursos')); ?>" 
                   class="btn-primary px-12 py-4 text-lg">
                    <i class="fas fa-compass mr-3"></i>Ver todas las categorías
                </a>
            </div>
        </div>
    </section>

    <!-- ===== CURSOS DESTACADOS CON CARRUSEL ===== -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-16">
                <div class="mb-8 lg:mb-0">
                    <h2 class="font-poppins text-4xl font-bold text-gray-900 mb-3">Cursos Destacados</h2>
                    <p class="text-xl text-gray-600">Los cursos mejor valorados por nuestra comunidad</p>
                </div>
                <a href="<?php echo e(Route::has('cursos.index') ? route('cursos.index') : url('/cursos')); ?>" 
                   class="btn-primary px-10 py-4">
                    <i class="fas fa-graduation-cap mr-3"></i>Ver todos los cursos
                </a>
            </div>

            <!-- Carrusel de cursos -->
            <div x-data="courseSlider()" x-init="init()" class="relative">
                <!-- Contenedor del carrusel -->
                <div class="overflow-hidden rounded-3xl">
                    <div class="flex transition-transform duration-500 ease-in-out"
                         :style="'transform: translateX(-' + (currentSlide * 100) + '%)'">
                        <?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $categoriaCurso = optional($curso->categoria)->nombre ?? $curso->category ?? 'Programación';
                                $courseDuration = $curso->duracion ?? $curso->duration ?? null;
                                $cursoPrecio = $curso->precio ?? $curso->price ?? 0;
                                $cursoPrecioTexto = is_numeric($cursoPrecio) ? 'S/ ' . number_format($cursoPrecio, 0) : $cursoPrecio;
                                $cursoTitulo = $curso->titulo ?? $curso->title ?? 'Curso sin título';
                                $cursoDescripcion = $curso->descripcion ?? $curso->description ?? 'Curso premium para llevar tus habilidades al siguiente nivel.';
                                $cursoMentor = optional($curso->mentor)->name ?? $curso->instructor->nombre ?? $curso->author?->name ?? 'Mentor destacado';
                                $cursoEstudiantes = $curso->estudiantes_count ?? $curso->students_count ?? $curso->inscritos ?? $curso->purchases_count ?? '0';
                                $cursoRating = $curso->rating ?? $curso->calificacion ?? '4.8';
                                $cursoBadge = $curso->badge ?? ($loop->first ? 'POPULAR' : ($loop->index === 1 ? 'NUEVO' : 'GRATIS'));
                                $cursoImagen = $curso->image_url ?? $curso->imagen ?? 'https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?auto=format&fit=crop&w=1200&q=80';
                                $cursoRouteTarget = $curso instanceof \Illuminate\Database\Eloquent\Model
                                    ? $curso
                                    : ($curso->slug ?? null);
                                $cursoShowUrl = Route::has('cursos.show') && $cursoRouteTarget
                                    ? route('cursos.show', $cursoRouteTarget)
                                    : (Route::has('cursos.index') ? route('cursos.index') : '#');
                                
                                $badgeClass = match ($loop->index % 3) {
                                    0 => 'bg-gradient-to-r from-purple-500 to-pink-500',
                                    1 => 'bg-gradient-to-r from-blue-500 to-cyan-500',
                                    default => 'bg-gradient-to-r from-green-500 to-emerald-500',
                                };
                            ?>
                            
                            <div class="w-full flex-shrink-0 px-4">
                                <div class="course-card h-full">
                                    <div class="relative h-64 overflow-hidden rounded-t-2xl">
                                        <img src="<?php echo e($cursoImagen); ?>" 
                                             alt="<?php echo e($cursoTitulo); ?>" 
                                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                        <div class="absolute top-6 right-6">
                                            <span class="glass-dark text-white text-sm font-bold px-4 py-2 rounded-full">
                                                <?php echo e(strtoupper($cursoBadge)); ?>

                                            </span>
                                        </div>
                                        <div class="absolute bottom-6 left-6 right-6">
                                            <div class="flex items-center justify-between text-white">
                                                <div class="flex items-center">
                                                    <i class="fas fa-star text-yellow-300 mr-2"></i>
                                                    <span class="font-bold text-lg"><?php echo e($cursoRating); ?></span>
                                                    <span class="mx-3">•</span>
                                                    <i class="fas fa-users mr-2"></i>
                                                    <span><?php echo e($cursoEstudiantes); ?> estudiantes</span>
                                                </div>
                                                <?php if($courseDuration): ?>
                                                    <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-sm">
                                                        <i class="fas fa-clock mr-1"></i><?php echo e($courseDuration); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-8">
                                        <div class="flex items-center justify-between mb-4">
                                            <span class="text-sm font-semibold px-3 py-1 rounded-full bg-blue-100 text-blue-600">
                                                <?php echo e($categoriaCurso); ?>

                                            </span>
                                            <div class="text-2xl font-bold text-gray-900"><?php echo e($cursoPrecioTexto); ?></div>
                                        </div>
                                        <h3 class="text-2xl font-bold text-gray-900 mb-4 leading-tight"><?php echo e($cursoTitulo); ?></h3>
                                        <p class="text-gray-600 mb-6 leading-relaxed"><?php echo e($cursoDescripcion); ?></p>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center mr-4">
                                                    <span class="text-purple-600 font-bold text-lg">
                                                        <?php echo e(\Illuminate\Support\Str::of($cursoMentor)->substr(0, 2)); ?>

                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-gray-900"><?php echo e($cursoMentor); ?></div>
                                                    <div class="text-sm text-gray-500">Instructor</div>
                                                </div>
                                            </div>
                                            <a href="<?php echo e($cursoShowUrl); ?>" 
                                               class="btn-primary px-8 py-3">
                                                Ver detalles
                                                <i class="fas fa-arrow-right ml-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Controles del carrusel -->
                <button @click="prev()"
                        class="absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-4 glass-effect w-14 h-14 rounded-full flex items-center justify-center text-gray-700 hover:text-purple-600 hover:scale-110 transition-all duration-300 shadow-lg">
                    <i class="fas fa-chevron-left text-xl"></i>
                </button>
                <button @click="next()"
                        class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-4 glass-effect w-14 h-14 rounded-full flex items-center justify-center text-gray-700 hover:text-purple-600 hover:scale-110 transition-all duration-300 shadow-lg">
                    <i class="fas fa-chevron-right text-xl"></i>
                </button>

                <!-- Puntos de navegación -->
                <div class="flex justify-center mt-10">
                    <div class="slider-dots">
                        <?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button @click="goToSlide(<?php echo e($index); ?>)"
                                    :class="{'active': currentSlide === <?php echo e($index); ?>}"
                                    class="slider-dot"
                                    aria-label="Ir al slide <?php echo e($index + 1); ?>">
                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== MENTORES DESTACADOS ===== -->
    <section class="py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-poppins text-4xl font-bold text-gray-900 mb-4">Mentores Destacados</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Aprende directamente de profesionales con años de experiencia en la industria
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php $__currentLoopData = $mentores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $mentor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $mentorUser = $mentor->user ?? null;
                        $mentorNombre = $mentor->nombre ?? $mentor->name ?? ($mentorUser->name ?? 'Mentor');
                        $mentorRol = $mentor->profesion ?? $mentor->especialidad ?? $mentor->role ?? 'Experto';
                        $mentorIniciales = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($mentorNombre, 0, 2));
                        $mentorRating = $mentor->rating ?? $mentor->valoracion ?? '5.0';
                        $mentorSesiones = $mentor->sesiones ?? $mentor->sessions ?? 0;
                        $mentorPrecio = $mentor->tarifa ?? $mentor->price ?? $mentor->precio ?? $mentor->precio_hora ?? 'S/ 80';
                        $mentorPrecio = is_numeric($mentorPrecio) ? 'S/ ' . number_format($mentorPrecio, 0) : $mentorPrecio;
                        $mentorRouteTarget = null;
                        if ($mentor instanceof \App\Models\User) {
                            $mentorRouteTarget = $mentor;
                        } elseif ($mentor instanceof \Illuminate\Database\Eloquent\Model) {
                            $mentorRouteTarget = $mentorUser ?? null;
                        } elseif (!empty($mentor->slug ?? null)) {
                            $mentorRouteTarget = $mentor->slug;
                        }
                        $mentorUrl = Route::has('mentor.public.show') && $mentorRouteTarget
                            ? route('mentor.public.show', $mentorRouteTarget)
                            : route('mentor-market.index');
                        
                        $gradientClasses = [
                            'gradient-primary',
                            'gradient-secondary',
                            'gradient-accent',
                            'bg-gradient-to-r from-purple-500 to-blue-500'
                        ];
                        $currentGradient = $gradientClasses[$index % count($gradientClasses)];
                    ?>
                    
                    <div class="mentor-card group animate-slide-in" style="animation-delay: <?php echo e($index * 0.1); ?>s">
                        <!-- Avatar del mentor -->
                        <div class="relative inline-block mb-8">
                            <div class="w-24 h-24 rounded-full <?php echo e($currentGradient); ?> p-1 mx-auto">
                                <div class="w-full h-full rounded-full bg-white flex items-center justify-center">
                                    <span class="text-2xl font-bold gradient-text"><?php echo e($mentorIniciales); ?></span>
                                </div>
                            </div>
                            <div class="absolute bottom-2 right-2 w-10 h-10 bg-green-500 rounded-full border-4 border-white flex items-center justify-center shadow-lg">
                                <i class="fas fa-check text-white"></i>
                            </div>
                        </div>

                        <!-- Información del mentor -->
                        <h3 class="text-2xl font-bold text-gray-900 mb-2"><?php echo e($mentorNombre); ?></h3>
                        <p class="text-lg font-semibold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-4">
                            <?php echo e($mentorRol); ?>

                        </p>
                        
                        <!-- Rating -->
                        <div class="flex items-center justify-center mb-4">
                            <div class="flex items-center">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star <?php echo e($i <= floor($mentorRating) ? 'text-yellow-400' : 'text-gray-300'); ?> text-lg"></i>
                                <?php endfor; ?>
                                <span class="ml-3 font-bold text-gray-700"><?php echo e($mentorRating); ?></span>
                            </div>
                        </div>
                        
                        <!-- Sesiones -->
                        <div class="text-gray-600 mb-6 flex items-center justify-center">
                            <i class="fas fa-video mr-3 text-purple-500"></i>
                            <span><?php echo e($mentorSesiones); ?> sesiones impartidas</span>
                        </div>
                        
                        <!-- Precio -->
                        <div class="text-3xl font-bold text-gray-900 mb-8">
                            <?php echo e($mentorPrecio); ?>

                            <span class="text-base font-normal text-gray-600">/hora</span>
                        </div>
                        
                        <!-- Botón de acción -->
                        <a href="<?php echo e($mentorUrl); ?>" 
                           class="block w-full btn-primary py-4 rounded-xl text-lg">
                            <i class="fas fa-user-tie mr-3"></i>Ver perfil completo
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="text-center mt-16">
                <a href="<?php echo e(route('mentor-market.index')); ?>" 
                   class="btn-primary px-12 py-4 text-lg">
                    <i class="fas fa-users mr-3"></i>Explorar todos los mentores
                </a>
            </div>
        </div>
    </section>

    <!-- ===== CTA FINAL ===== -->
    <section class="py-24 relative overflow-hidden">
        <!-- Fondo con gradiente animado -->
        <div class="absolute inset-0 bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-800">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
        </div>
        
        <!-- Elementos decorativos -->
        <div class="floating-bubble" style="width: 200px; height: 200px; top: 20%; left: 10%; animation-duration: 18s; background: rgba(255,255,255,0.1);"></div>
        <div class="floating-bubble" style="width: 150px; height: 150px; bottom: 20%; right: 10%; animation-duration: 22s; animation-delay: -2s; background: rgba(255,255,255,0.1);"></div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <!-- Badge -->
                <div class="inline-flex items-center px-6 py-3 rounded-full bg-white/10 backdrop-blur-sm mb-8">
                    <div class="w-3 h-3 rounded-full bg-gradient-to-r from-yellow-400 to-orange-400 mr-3 animate-pulse"></div>
                    <span class="text-white font-semibold text-lg">
                        <i class="fas fa-rocket mr-2"></i>¡Tu oportunidad comienza aquí!
                    </span>
                </div>

                <!-- Título -->
                <h2 class="font-poppins text-4xl md:text-5xl font-bold text-white mb-8">
                    ¿Listo para Transformar tu Carrera?
                </h2>

                <!-- Descripción -->
                <p class="text-xl text-purple-100 mb-12 leading-relaxed max-w-3xl mx-auto">
                    Únete a miles de profesionales que ya están aprendiendo habilidades demandadas 
                    y conectando con los mejores expertos de la industria. Tu futuro profesional 
                    comienza hoy.
                </p>

                <!-- Botones de acción -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center mb-12">
                    <a href="<?php echo e(route('register')); ?>" 
                       class="bg-white text-purple-600 font-bold px-12 py-5 rounded-2xl hover:shadow-hover transition-all flex items-center justify-center text-lg group">
                        <i class="fas fa-user-graduate mr-4 text-xl group-hover:scale-110 transition-transform"></i>
                        Comenzar Gratis
                    </a>
                    <a href="<?php echo e(url('/mentorias/create')); ?>" 
                       class="bg-transparent border-2 border-white text-white font-bold px-12 py-5 rounded-2xl hover:bg-white/10 transition-all flex items-center justify-center text-lg group">
                        <i class="fas fa-chalkboard-teacher mr-4 text-xl group-hover:scale-110 transition-transform"></i>
                        Convertirse en Mentor
                    </a>
                </div>

                <!-- Beneficios -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-3xl mx-auto">
                    <div class="flex items-center justify-center text-white/80">
                        <i class="fas fa-check-circle text-green-300 mr-3 text-xl"></i>
                        <span>Acceso gratuito a cursos básicos</span>
                    </div>
                    <div class="flex items-center justify-center text-white/80">
                        <i class="fas fa-check-circle text-green-300 mr-3 text-xl"></i>
                        <span>Certificaciones reconocidas</span>
                    </div>
                    <div class="flex items-center justify-center text-white/80">
                        <i class="fas fa-check-circle text-green-300 mr-3 text-xl"></i>
                        <span>Comunidad global de aprendizaje</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // Script para el carrusel de cursos
    function courseSlider() {
        return {
            currentSlide: 0,
            totalSlides: <?php echo e($cursos->count()); ?>,
            interval: null,
            
            init() {
                this.startAutoplay();
            },
            
            next() {
                this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                this.resetAutoplay();
            },
            
            prev() {
                this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
                this.resetAutoplay();
            },
            
            goToSlide(index) {
                this.currentSlide = index;
                this.resetAutoplay();
            },
            
            startAutoplay() {
                this.interval = setInterval(() => {
                    this.next();
                }, 5000); // Cambia cada 5 segundos
            },
            
            resetAutoplay() {
                clearInterval(this.interval);
                this.startAutoplay();
            }
        }
    }
    
    // Animación para el marquee de empresas
    document.addEventListener('DOMContentLoaded', function() {
        const style = document.createElement('style');
        style.textContent = `
            @keyframes marquee {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }
            .animate-marquee {
                animation: marquee 30s linear infinite;
            }
            .animate-marquee:hover {
                animation-play-state: paused;
            }
        `;
        document.head.appendChild(style);
        
        // Inicializar animaciones de entrada
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        // Observar todos los elementos con animación
        document.querySelectorAll('.animate-slide-in').forEach(el => {
            observer.observe(el);
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\NADHIRA\Downloads\SkillNest\resources\views/home.blade.php ENDPATH**/ ?>