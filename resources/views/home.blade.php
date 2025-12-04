@extends('layouts.app')

@php
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
@endphp

@section('content')
<div class="-mx-4 sm:-mx-6 lg:-mx-8">
    <!-- ===== HERO SECTION ===== -->
    <section class="pt-28 pb-16 md:pt-36 md:pb-24 relative overflow-hidden bg-gray-50">
        <div class="absolute top-10 right-10 w-64 h-64 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"></div>
        <div class="absolute bottom-10 left-10 w-80 h-80 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float" style="animation-delay: 2s"></div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="max-w-6xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="animate-fade-in-up">
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-purple-100 to-pink-100 mb-6">
                            <span class="text-sm font-medium gradient-text">
                                <i class="fas fa-star mr-2"></i>PLATAFORMA #1 EN EDUCACIÓN ONLINE
                            </span>
                        </div>

                        <h1 class="font-poppins text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                            <span class="block">Domina Habilidades</span>
                            <span class="block gradient-text">que Transforman Carreras</span>
                        </h1>

                        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                            Únete a la plataforma donde expertos comparten conocimiento y profesionales
                            aceleran su crecimiento. Más de 500 cursos y mentorías personalizadas.
                        </p>

                        <div class="mb-10">
                            <div class="relative">
                                <div class="absolute inset-0 gradient-primary rounded-xl blur opacity-10"></div>
                                <div class="relative bg-white rounded-xl shadow-soft">
                                    <form action="{{ route('home') }}" method="GET" class="flex flex-col sm:flex-row">
                                        <div class="flex-1 relative">
                                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                            <input type="text"
                                                   name="q"
                                                   value="{{ request('q') }}"
                                                   placeholder="Buscar cursos, mentorías, habilidades..."
                                                   class="w-full pl-12 pr-4 py-4 text-gray-700 rounded-l-xl border-0 focus:ring-2 focus:ring-purple-300 focus:outline-none">
                                        </div>
                                        <button type="submit"
                                                class="mt-2 sm:mt-0 gradient-primary text-white font-medium px-8 py-4 rounded-r-xl hover:shadow-hover transition-all">
                                            <i class="fas fa-search mr-2"></i>Buscar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-6 mb-8">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center mr-3">
                                    <i class="fas fa-book text-blue-600"></i>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-gray-900">{{ $statsCursos }}</div>
                                    <div class="text-gray-600">Cursos Premium</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center mr-3">
                                    <i class="fas fa-users text-green-600"></i>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-gray-900">{{ $statsEstudiantes }}</div>
                                    <div class="text-gray-600">Estudiantes</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-yellow-100 to-yellow-200 flex items-center justify-center mr-3">
                                    <i class="fas fa-star text-yellow-600"></i>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-gray-900">{{ $statsRating }}</div>
                                    <div class="text-gray-600">Rating Promedio</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ Route::has('cursos.index') ? route('cursos.index') : url('/cursos') }}" class="btn-primary flex items-center justify-center">
                                <i class="fas fa-play-circle mr-3"></i>Explorar Cursos
                            </a>
                            <a href="{{ route('mentor-market.index') }}" class="border-2 border-gray-300 text-gray-700 font-medium px-8 py-3 rounded-xl text-center hover:border-purple-500 hover:text-purple-600 transition-all flex items-center justify-center">
                                <i class="fas fa-video mr-3"></i>Ver Mentorías
                            </a>
                        </div>
                    </div>

                    <div class="hidden lg:block relative animate-fade-in-up" style="animation-delay: 0.2s">
                        <div class="relative animate-float">
                            <div class="glass-effect rounded-2xl shadow-soft overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-2 h-2 rounded-full bg-red-400"></div>
                                        <div class="w-2 h-2 rounded-full bg-yellow-400"></div>
                                        <div class="w-2 h-2 rounded-full bg-green-400"></div>
                                    </div>
                                    <div class="text-sm font-medium text-gray-500">SkillNest Dashboard</div>
                                </div>

                                <div class="p-6">
                                    <div class="mb-6">
                                        <div class="flex justify-between text-sm mb-2">
                                            <span class="text-gray-600">Tu progreso total</span>
                                            <span class="font-medium text-purple-600">65%</span>
                                        </div>
                                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full gradient-primary rounded-full" style="width: 65%"></div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 mb-6">
                                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4">
                                            <div class="flex items-center mb-2">
                                                <div class="w-10 h-10 rounded-lg bg-blue-500 flex items-center justify-center mr-3">
                                                    <i class="fas fa-code text-white"></i>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-sm">Laravel</div>
                                                    <div class="text-xs text-gray-500">3/5 lecciones</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4">
                                            <div class="flex items-center mb-2">
                                                <div class="w-10 h-10 rounded-lg bg-purple-500 flex items-center justify-center mr-3">
                                                    <i class="fas fa-palette text-white"></i>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-sm">Figma UI</div>
                                                    <div class="text-xs text-gray-500">Completado</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex justify-between pt-4 border-t border-gray-100">
                                        <div class="text-center">
                                            <div class="text-xl font-bold text-gray-900">3</div>
                                            <div class="text-xs text-gray-500">Cursos activos</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xl font-bold text-gray-900">24h</div>
                                            <div class="text-xs text-gray-500">Horas aprendidas</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xl font-bold text-gray-900">2</div>
                                            <div class="text-xs text-gray-500">Certificados</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="absolute -top-4 -right-4">
                                <div class="bg-white rounded-xl shadow-soft p-4 w-56 rotate-3">
                                    <div class="flex items-center mb-3">
                                        <div class="w-12 h-12 rounded-lg gradient-primary flex items-center justify-center mr-3">
                                            <i class="fab fa-vuejs text-white"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium">Vue.js Masterclass</div>
                                            <div class="text-sm text-gray-500">María López</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-users mr-2"></i>
                                        <span>897 estudiantes</span>
                                    </div>
                                </div>
                            </div>

                            <div class="absolute -bottom-4 -left-4">
                                <div class="bg-white rounded-xl shadow-soft p-4 w-48 -rotate-3">
                                    <div class="flex items-center mb-3">
                                        <div class="w-10 h-10 rounded-lg gradient-accent flex items-center justify-center mr-3">
                                            <i class="fas fa-certificate text-white"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium">Certificación</div>
                                            <div class="text-sm text-gray-500">Diseño UX</div>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-600">Logro reciente</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CARRUSEL DE EMPRESAS ===== -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <p class="text-gray-500 text-sm font-medium">CONFÍAN EN NOSOTROS</p>
            </div>
            <div x-data="{
                    currentIndex: 0,
                    items: 2,
                    next() { this.currentIndex = (this.currentIndex + 1) % this.items; },
                    prev() { this.currentIndex = (this.currentIndex - 1 + this.items) % this.items; }
                }"
                 @mouseenter="clearInterval(interval)"
                 @mouseleave="interval = setInterval(() => next(), 3000)"
                 x-init="interval = setInterval(() => next(), 3000)"
                 class="relative overflow-hidden">
                <div class="flex transition-transform duration-500 ease-in-out"
                     :style="'transform: translateX(-' + (currentIndex * 100) + '%)'">
                    <div class="w-full flex-shrink-0 flex justify-center">
                        <div class="flex items-center space-x-8 px-8">
                            <div class="text-center p-4">
                                <div class="text-3xl mb-2">💻</div>
                                <div class="font-medium text-gray-700">TechCorp</div>
                            </div>
                            <div class="text-center p-4">
                                <div class="text-3xl mb-2">🏢</div>
                                <div class="font-medium text-gray-700">DigitalPlus</div>
                            </div>
                            <div class="text-center p-4">
                                <div class="text-3xl mb-2">🚀</div>
                                <div class="font-medium text-gray-700">StartUpLab</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex-shrink-0 flex justify-center">
                        <div class="flex items-center space-x-8 px-8">
                            <div class="text-center p-4">
                                <div class="text-3xl mb-2">🎓</div>
                                <div class="font-medium text-gray-700">UniTech</div>
                            </div>
                            <div class="text-center p-4">
                                <div class="text-3xl mb-2">⭐</div>
                                <div class="font-medium text-gray-700">InnovateCo</div>
                            </div>
                            <div class="text-center p-4">
                                <div class="text-3xl mb-2">🌐</div>
                                <div class="font-medium text-gray-700">GlobalEd</div>
                            </div>
                        </div>
                    </div>
                </div>
                <button @click="prev()"
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 glass-effect w-10 h-10 rounded-full flex items-center justify-center text-gray-700 hover:text-purple-600">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button @click="next()"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 glass-effect w-10 h-10 rounded-full flex items-center justify-center text-gray-700 hover:text-purple-600">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- ===== CATEGORÍAS ===== -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="font-poppins text-3xl font-bold text-gray-900 mb-4">Explora por Categoría</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Descubre cursos en las áreas más demandadas del mercado</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categorias as $categoria)
                    @php
                        $categoriaUrl = Route::has('cursos.categoria') && isset($categoria->slug)
                            ? route('cursos.categoria', $categoria->slug)
                            : (Route::has('cursos.index') ? route('cursos.index') : '#');
                        $categoriaDescripcion = $categoria->descripcion ?? $categoria->description ?? 'Explora cursos seleccionados para potenciar tu perfil profesional.';
                        $categoriaNombre = $categoria->nombre ?? $categoria->name ?? 'Categoría';
                        $categoriaIcono = $categoria->icono ?? $categoria->icon ?? 'fas fa-graduation-cap';
                        $categoriaCursosCount = $categoria->cursos_count ?? $categoria->courses_count ?? $categoria->cursos?->count() ?? 0;
                    @endphp
                    <a href="{{ $categoriaUrl }}" class="category-card card-hover">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center">
                                <i class="{{ $categoriaIcono }} text-white text-2xl"></i>
                            </div>
                            <span class="text-blue-600 font-medium bg-blue-50 px-3 py-1 rounded-full text-sm">
                                {{ $categoriaCursosCount }} cursos
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $categoriaNombre }}</h3>
                        <p class="text-gray-600 mb-4">{{ $categoriaDescripcion }}</p>
                        <div class="text-blue-600 font-medium flex items-center">
                            Explorar
                            <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ Route::has('cursos.index') ? route('cursos.index') : url('/cursos') }}" class="inline-flex items-center text-lg font-medium text-purple-600 hover:text-purple-700">
                    Ver todas las categorías
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ===== CURSOS DESTACADOS ===== -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-12">
                <div>
                    <h2 class="font-poppins text-3xl font-bold text-gray-900 mb-2">Cursos Destacados</h2>
                    <p class="text-lg text-gray-600">Los cursos mejor valorados por nuestra comunidad</p>
                </div>
                <a href="{{ Route::has('cursos.index') ? route('cursos.index') : url('/cursos') }}" class="mt-4 sm:mt-0 inline-flex items-center text-purple-600 hover:text-purple-700 font-medium">
                    Ver todos los cursos
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($cursos as $curso)
                    @php
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
                            0 => 'gradient-primary',
                            1 => 'gradient-secondary',
                            default => 'gradient-accent',
                        };
                    @endphp
                    <div class="course-card card-hover shadow-soft">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $cursoImagen }}" alt="{{ $cursoTitulo }}" class="w-full h-full object-cover">
                            <div class="absolute top-4 right-4">
                                <span class="glass-dark text-white text-xs font-bold px-3 py-1 rounded-full">{{ strtoupper($cursoBadge) }}</span>
                            </div>
                            <div class="absolute bottom-4 left-4">
                                <div class="flex items-center text-white">
                                    <i class="fas fa-star text-yellow-300 mr-1"></i>
                                    <span class="font-bold">{{ $cursoRating }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $cursoEstudiantes }} estudiantes</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm font-medium text-purple-600">{{ $categoriaCurso }}</span>
                                @if($courseDuration)
                                    <span class="text-sm text-gray-500">{{ $courseDuration }}</span>
                                @endif
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $cursoTitulo }}</h3>
                            <p class="text-gray-600 mb-4">{{ $cursoDescripcion }}</p>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-cyan-100 flex items-center justify-center mr-3">
                                        <span class="text-blue-600 font-bold">{{ \Illuminate\Support\Str::of($cursoMentor)->substr(0, 2) }}</span>
                                    </div>
                                    <span class="font-medium text-gray-700">{{ $cursoMentor }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="text-2xl font-bold text-gray-900">{{ $cursoPrecioTexto }}</div>
                                <a href="{{ $cursoShowUrl }}" class="text-purple-600 font-medium hover:text-purple-700">
                                    Ver curso
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ===== MENTORES ===== -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="font-poppins text-3xl font-bold text-gray-900 mb-4">Mentores Destacados</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Aprende directamente de profesionales con años de experiencia</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($mentores as $mentor)
                    @php
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
                        $gradientClass = ['gradient-primary', 'gradient-secondary', 'gradient-accent', 'bg-gradient-to-br from-orange-400 to-yellow-400'][$loop->index % 4];
                    @endphp
                    <div class="mentor-card card-hover">
                        <div class="relative inline-block mb-6">
                            <div class="w-20 h-20 rounded-full {{ $gradientClass }} flex items-center justify-center mx-auto">
                                <div class="w-18 h-18 rounded-full bg-white flex items-center justify-center">
                                    <span class="text-xl font-bold gradient-text">{{ $mentorIniciales }}</span>
                                </div>
                            </div>
                            <div class="absolute bottom-0 right-0 w-8 h-8 bg-green-500 rounded-full border-4 border-white flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $mentorNombre }}</h3>
                        <p class="text-purple-600 font-medium mb-4">{{ $mentorRol }}</p>
                        <div class="flex items-center justify-center mb-4">
                            <div class="flex items-center text-yellow-500">
                                <i class="fas fa-star"></i>
                                <span class="ml-2 font-medium text-gray-700">{{ $mentorRating }}</span>
                            </div>
                        </div>
                        <div class="text-gray-600 mb-4">
                            <i class="fas fa-clock mr-2"></i>{{ $mentorSesiones }} sesiones
                        </div>
                        <div class="text-2xl font-bold text-gray-900 mb-6">{{ $mentorPrecio }}<span class="text-sm font-normal text-gray-600">/hora</span></div>
                        <a href="{{ $mentorUrl }}" class="block w-full gradient-primary text-white font-medium py-3 rounded-xl hover:shadow-hover transition-all">
                            Ver perfil
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('mentor-market.index') }}" class="inline-flex items-center btn-primary">
                    <i class="fas fa-users mr-3"></i>Ver todos los mentores
                </a>
            </div>
        </div>
    </section>

    <!-- ===== CTA FINAL ===== -->
    <section class="py-20 bg-gradient-to-br from-purple-600 to-indigo-700 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-poppins text-3xl md:text-4xl font-bold mb-6">¿Listo para Transformar tu Carrera?</h2>
            <p class="text-xl text-purple-100 max-w-2xl mx-auto mb-10">
                Únete a miles de profesionales que están aprendiendo habilidades demandadas y conectando con expertos de la industria.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-white text-purple-600 font-bold px-8 py-4 rounded-xl hover:shadow-hover transition-all flex items-center justify-center">
                    <i class="fas fa-user-graduate mr-3"></i>Empezar a Aprender
                </a>
                <a href="{{ url('/mentorias/create') }}" class="bg-transparent border-2 border-white text-white font-bold px-8 py-4 rounded-xl hover:bg-white/10 transition-all flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher mr-3"></i>Ser Mentor
                </a>
            </div>
            <p class="mt-8 text-purple-200">Únete gratis • Sin compromisos • Cancelación en cualquier momento</p>
        </div>
    </section>
</div>
@endsection
