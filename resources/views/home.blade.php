@extends('layouts.app')







@section('content')



    @php
        $categories = [
            ['name' => 'Programación', 'courses' => 234, 'icon' => 'https://cdn-icons-png.flaticon.com/512/1006/1006363.png'],
            ['name' => 'Diseño', 'courses' => 156, 'icon' => 'https://cdn-icons-png.flaticon.com/512/1829/1829583.png'],
            ['name' => 'Marketing', 'courses' => 98, 'icon' => 'https://cdn-icons-png.flaticon.com/512/2463/2463510.png'],
            ['name' => 'Negocios', 'courses' => 145, 'icon' => 'https://cdn-icons-png.flaticon.com/512/3135/3135755.png'],
            ['name' => 'Fotografía', 'courses' => 67, 'icon' => 'https://cdn-icons-png.flaticon.com/512/860/860786.png'],
            ['name' => 'Música', 'courses' => 43, 'icon' => 'https://cdn-icons-png.flaticon.com/512/727/727245.png'],
        ];

        $courses = [
            [
                'title' => 'Laravel Avanzado: De Cero a Experto',
                'mentor' => 'Carlos Gómez',
                'category' => 'Programación',
                'price' => 149,
                'rating' => 4.8,
                'students' => 1234,
                'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Vue.js Completo: Desarrollo Frontend Moderno',
                'mentor' => 'María López',
                'category' => 'Programación',
                'price' => 139,
                'rating' => 4.9,
                'students' => 987,
                'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Diseño UX/UI: Crea Interfaces Increíbles',
                'mentor' => 'Ana García',
                'category' => 'Diseño',
                'price' => 129,
                'rating' => 4.7,
                'students' => 856,
                'image' => 'https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?auto=format&fit=crop&w=900&q=80',
            ],
        ];

        $mentors = [
            ['name' => 'Carlos Gómez', 'title' => 'Senior Laravel Developer', 'rating' => 4.9, 'sessions' => 125, 'price' => 80, 'available' => true],
            ['name' => 'María López', 'title' => 'Frontend Expert', 'rating' => 4.8, 'sessions' => 98, 'price' => 70, 'available' => true],
            ['name' => 'Ana García', 'title' => 'UX/UI Designer', 'rating' => 5.0, 'sessions' => 156, 'price' => 90, 'available' => false],
            ['name' => 'José Ramírez', 'title' => 'Marketing Strategist', 'rating' => 4.7, 'sessions' => 89, 'price' => 75, 'available' => true],
        ];
    @endphp







    <div class="mx-auto flex max-w-6xl flex-col gap-16 py-12">



        {{-- Hero --}}



        <section class="rounded-[32px] border border-slate-100 bg-white/90 p-10 shadow-card">



            <div class="grid gap-10 lg:grid-cols-2">



                <div class="space-y-8">



                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-primary/80">Plataforma educativa</p>



                    <h1 class="text-5xl font-black leading-tight text-secondary">



                        Aprende de expertos o comparte tu <span class="text-primary">conocimiento</span>



                    </h1>



                    <p class="text-lg text-slate-500">Accede a más de 500 cursos y conecta con mentores profesionales.</p>







                    <form action="{{ route('cursos.index') }}" method="GET" class="rounded-full border border-slate-200 bg-white/80 p-2 shadow-sm">



                        <div class="flex items-center gap-3 px-2">



                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">



                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 5 5.5a7.5 7.5 0 0 0 11.65 11.15z" />



                            </svg>



                            <input type="text" name="q" placeholder="¿Qué quieres aprender hoy?" class="flex-1 border-0 bg-transparent focus:outline-none">



                            <button class="btn-gradient rounded-full px-6">Buscar cursos</button>



                        </div>



                    </form>







                    <div class="flex flex-wrap gap-3">



                        <a href="{{ route('cursos.index') }}" class="btn-primary rounded-full px-6">Ver cursos publicados</a>



                        <a href="{{ route('mentor-market.index') }}" class="btn-secondary rounded-full px-6">Ver mentorías</a>



                    </div>







                    <div class="grid gap-6 sm:grid-cols-4">



                        <div>



                            <p class="text-2xl font-bold text-secondary">500+</p>



                            <p class="text-sm text-slate-500">Cursos</p>



                        </div>



                        <div>



                            <p class="text-2xl font-bold text-secondary">10K</p>



                            <p class="text-sm text-slate-500">Estudiantes</p>



                        </div>



                        <div>



                            <p class="text-2xl font-bold text-secondary">4.8/5</p>



                            <p class="text-sm text-slate-500">Valoración</p>



                        </div>



                        <div>



                            <p class="text-2xl font-bold text-secondary">95%</p>



                            <p class="text-sm text-slate-500">Completados</p>



                        </div>



                    </div>



                </div>



                <div class="relative overflow-hidden rounded-[32px] shadow-2xl shadow-primary/20">



                    <img src="https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?auto=format&fit=crop&w=900&q=80" alt="Mentora" class="h-full w-full object-cover">



                </div>



            </div>



        </section>







        {{-- Categorías --}}



        <section class="space-y-8">



            <div class="flex items-center justify-between">



                <h2 class="text-3xl font-bold text-secondary">Explora por categoría</h2>



                <a href="{{ route('cursos.index') }}" class="btn-secondary rounded-full px-5">Ver todos</a>



            </div>



            <div class="grid gap-5 md:grid-cols-3 lg:grid-cols-6">



                @foreach($categories as $category)



                    <article class="rounded-3xl border border-slate-100 bg-white p-5 text-center shadow-card transition hover:-translate-y-1 hover:shadow-xl">



                        <div class="mx-auto mb-4 h-16 w-16 overflow-hidden rounded-2xl bg-primary/10">

                            <img src="{{ $category['icon'] }}" alt="{{ $category['name'] }}" class="h-full w-full object-cover">

                        </div>



                        <p class="font-semibold text-secondary">{{ $category['name'] }}</p>



                        <p class="text-sm text-slate-500">{{ $category['courses'] }} cursos</p>



                    </article>



                @endforeach



            </div>



        </section>







        {{-- Cursos populares --}}



        <section class="space-y-8">



            <div class="flex items-center justify-between">



                <h2 class="text-3xl font-bold text-secondary">Cursos más populares</h2>



                <a href="{{ route('cursos.index') }}" class="btn-secondary rounded-full px-5">Ver todos</a>



            </div>



            <div class="grid gap-6 lg:grid-cols-3">



                @foreach($courses as $course)



                    <article class="rounded-[28px] border border-slate-100 bg-white shadow-card">



                        <div class="overflow-hidden rounded-t-[28px]">



                            <img src="{{ $course['image'] }}" alt="{{ $course['title'] }}" class="h-48 w-full object-cover">



                        </div>



                        <div class="space-y-4 p-6">



                            <span class="badge bg-primary/10 text-primary">{{ $course['category'] }}</span>



                            <div>



                                <h3 class="text-xl font-semibold text-secondary">{{ $course['title'] }}</h3>



                                <p class="text-sm text-slate-500">{{ $course['mentor'] }}</p>



                            </div>



                            <div class="flex items-center gap-4 text-sm text-slate-500">



                                <div class="flex items-center gap-1">



                                    <span></span> <span>{{ $course['rating'] }}</span>



                                </div>



                                <div class="flex items-center gap-1">



                                    <span></span> <span>{{ number_format($course['students']) }}</span>



                                </div>



                            </div>



                            <div class="flex items-center justify-between">



                                <p class="text-2xl font-bold text-secondary">S/ {{ $course['price'] }}</p>



                                <a href="{{ route('cursos.index') }}" class="btn-gradient rounded-full px-5">Ver más</a>



                            </div>



                        </div>



                    </article>



                @endforeach



            </div>



        </section>







        {{-- Mentores --}}



        <section class="space-y-8">



            <div class="flex items-center justify-between">



                <h2 class="text-3xl font-bold text-secondary">Aprende de los mejores</h2>



                <a href="{{ route('mentor-market.index') }}" class="btn-secondary rounded-full px-5">Ver todos</a>



            </div>



            <div class="grid gap-6 lg:grid-cols-4">



                @foreach($mentors as $mentor)



                    <article class="rounded-[28px] border border-slate-100 bg-white p-6 text-center shadow-card">



                        <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full border-4 border-primary/30 text-2xl font-bold text-primary">



                            {{ \Illuminate\Support\Str::substr($mentor['name'], 0, 1) }}



                        </div>



                        <p class="text-lg font-semibold text-secondary">{{ $mentor['name'] }}</p>



                        <p class="text-sm text-slate-500">{{ $mentor['title'] }}</p>



                        <div class="mt-2 flex items-center justify-center gap-2 text-sm text-slate-500">



                            <span> {{ $mentor['rating'] }}</span>



                            <span>({{ $mentor['sessions'] }} sesiones)</span>



                        </div>



                        <div class="mt-4">



                            <span class="badge {{ $mentor['available'] ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-400' }}">



                                {{ $mentor['available'] ? 'Disponible' : 'Ocupado' }}



                            </span>



                        </div>



                        <p class="mt-4 text-2xl font-bold text-secondary">S/ {{ $mentor['price'] }}/hora</p>



                        <a href="{{ route('mentor-market.index') }}" class="btn-gradient mt-4 w-full justify-center">Ver perfil</a>



                    </article>



                @endforeach



            </div>



        </section>







        {{-- CTA --}}



        <section class="rounded-[32px] bg-gradient-to-r from-[#8b5cf6] to-[#6366f1] p-10 text-white shadow-card">



            <div class="grid gap-10 md:grid-cols-2">



                <div class="space-y-4">



                    <h3 class="text-3xl font-bold">¿Quieres aprender?</h3>


                    <ul class="list-disc space-y-2 pl-5 text-white/80">



                        <li>Accede a cursos de calidad</li>



                        <li>Agenda mentorí­as personalizadas</li>


                        <li>Obtn certificados verificables</li>



                    </ul>



                    <a href="{{ route('cursos.index') }}" class="inline-flex rounded-full bg-white px-6 py-3 font-semibold text-secondary">Explorar cursos</a>



                </div>



                <div class="space-y-4">



                    <h3 class="text-3xl font-bold">¿Quieres enseñar?</h3>


                    <ul class="list-disc space-y-2 pl-5 text-white/80">



                        <li>Crea y vende tus cursos</li>



                        <li>Ofrece mentorías 1 a 1</li>


                        <li>Genera ingresos pasivos</li>



                    </ul>



                    <a href="{{ route('register') }}" class="inline-flex rounded-full bg-white px-6 py-3 font-semibold text-secondary">Comenzar a enseñar</a>



                </div>



            </div>



        </section>



    </div>



@endsection







