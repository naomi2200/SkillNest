@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('content')
    @php

        $catalog = collect($cursos ?? []);

        if ($catalog->isEmpty()) {
            $catalog = collect([
                [
                    'title' => 'React desde Cero: Hooks, Context y más',
                    'mentor' => 'Ana García',
                    'category' => 'Programación',
                    'price' => 149,
                    'rating' => 4.9,
                    'students' => 2341,
                    'image' => 'https://images.unsplash.com/photo-1504805572947-34fad45aed93?auto=format&fit=crop&w=900&q=80',
                ],
                [
                    'title' => 'Laravel Avanzado: APIs y Microservicios',
                    'mentor' => 'Carlos Gómez',
                    'category' => 'Programación',
                    'price' => 179,
                    'rating' => 4.8,
                    'students' => 1234,
                    'image' => 'https://images.unsplash.com/photo-1523475472560-d2df97ec485c?auto=format&fit=crop&w=900&q=80',
                ],
                [
                    'title' => 'Vue.js 3: Composición API Completa',
                    'mentor' => 'María López',
                    'category' => 'Programación',
                    'price' => 159,
                    'rating' => 4.7,
                    'students' => 987,
                    'image' => 'https://images.unsplash.com/photo-1526378722440-8868831badc9?auto=format&fit=crop&w=900&q=80',
                ],
                [
                    'title' => 'Diseño UX/UI: De Principiante a Pro',
                    'mentor' => 'José Ramírez',
                    'category' => 'Diseño',
                    'price' => 139,
                    'rating' => 4.9,
                    'students' => 1567,
                    'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80',
                ],
                [
                    'title' => 'Marketing Digital: Estrategias 2024',
                    'mentor' => 'Laura Martínez',
                    'category' => 'Marketing',
                    'price' => 129,
                    'rating' => 4.6,
                    'students' => 2134,
                    'image' => 'https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=900&q=80',
                ],
                [
                    'title' => 'Python para Data Science y Machine Learning',
                    'mentor' => 'Pedro Sánchez',
                    'category' => 'Programación',
                    'price' => 169,
                    'rating' => 4.8,
                    'students' => 1789,
                    'image' => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=900&q=80',
                ],
            ]);
        }

        $totalCursos = $catalog->count();
    @endphp

    <div class="mx-auto flex max-w-6xl flex-col gap-8 py-12 lg:flex-row">
        {{-- Filtros --}}
        <aside class="w-full rounded-[28px] border border-slate-100 bg-white p-6 shadow-card lg:max-w-xs">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-secondary">Filtros</h2>
                <a href="{{ route('cursos.index') }}" class="text-sm font-semibold text-primary">Limpiar todo</a>
            </div>

            <form class="mt-6 space-y-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-secondary">Búsqueda</label>
                    <div class="flex items-center gap-2 rounded-2xl border border-slate-200 px-3">
                        <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 5 5.5a7.5 7.5 0 0 0 11.65 11.15z" />
                        </svg>
                        <input type="text" class="w-full border-0 bg-transparent py-3 text-sm focus:outline-none" placeholder="Buscar por título...">
                    </div>
                </div>

                <div class="space-y-3">
                    <p class="text-sm font-semibold text-secondary">Categoría</p>
                    @foreach(['Programación (234)', 'Diseño (156)', 'Marketing (98)'] as $cat)
                        <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600">
                            <input type="radio" name="category" class="text-primary" {{ $loop->first ? 'checked' : '' }}>
                            {{ $cat }}
                        </label>
                    @endforeach
                </div>

                <div class="space-y-3">
                    <p class="text-sm font-semibold text-secondary">Precio</p>
                    @foreach(['Todos', 'Gratis', '< S/ 100', 'S/ 100 - 200'] as $price)
                        <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600">
                            <input type="radio" name="price" class="text-primary" {{ $loop->first ? 'checked' : '' }}>
                            {{ $price }}
                        </label>
                    @endforeach
                </div>

                <div class="space-y-3">
                    <p class="text-sm font-semibold text-secondary">Nivel</p>
                    @foreach(['Principiante', 'Intermedio', 'Avanzado'] as $level)
                        <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600">
                            <input type="radio" name="level" class="text-primary" {{ $loop->first ? 'checked' : '' }}>
                            {{ $level }}
                        </label>
                    @endforeach
                </div>

                <button type="button" class="btn-gradient w-full justify-center rounded-2xl">Aplicar filtros</button>
            </form>
        </aside>

        {{-- Listado --}}
        <section class="flex-1 space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-wide text-slate-400">Resultados</p>
                    <h1 class="text-3xl font-bold text-secondary">{{ $totalCursos }} cursos encontrados</h1>
                </div>
                <div class="flex items-center gap-3">
                    <select class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-secondary focus:border-primary focus:outline-none">
                        <option>Relevancia</option>
                        <option>Más populares</option>
                        <option>Precio: menor a mayor</option>
                        <option>Precio: mayor a menor</option>
                    </select>
                    <div class="flex items-center gap-2 rounded-full border border-slate-200 bg-white p-1">
                        <button type="button" class="rounded-full bg-primary/10 px-3 py-1 text-primary">▦</button>
                        <button type="button" class="rounded-full px-3 py-1 text-slate-400">☰</button>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                @foreach($catalog as $course)
                    @php
                        $title = data_get($course, 'title', 'Sin título');
                        $category = ucfirst(data_get($course, 'category', data_get($course, 'category.name', 'Categoría')));
                        $mentor = data_get($course, 'mentor.name', data_get($course, 'mentor', 'Mentor sin asignar'));
                        $description = data_get($course, 'description', 'Este curso está listo para ayudarte a crecer profesionalmente.');
                        $price = number_format((float) data_get($course, 'price', 0), 2);
                        $rating = data_get($course, 'rating', '4.8');
                        $students = number_format((int) data_get($course, 'students', data_get($course, 'students_count', 0)));
                        $image = data_get($course, 'image', 'https://images.unsplash.com/photo-1523475472560-d2df97ec485c?auto=format&fit=crop&w=900&q=80');
                        $model = $course instanceof \Illuminate\Database\Eloquent\Model ? $course : null;
                    @endphp

                    <article class="rounded-[32px] border border-slate-100 bg-white shadow-card">
                        <div class="overflow-hidden rounded-t-[32px]">
                            <img src="{{ $image }}" alt="{{ $title }}" class="h-52 w-full object-cover">
                        </div>
                        <div class="space-y-4 p-6">
                            <span class="badge bg-primary/10 text-primary">{{ $category }}</span>
                            <div>
                                <h3 class="text-xl font-semibold text-secondary">{{ $title }}</h3>
                                <p class="text-sm text-slate-500">{{ $mentor }}</p>
                            </div>
                            <p class="text-sm text-slate-600">{{ Str::limit($description, 120) }}</p>
                            <div class="flex items-center gap-4 text-sm text-slate-500">
                                <span>⭐ {{ $rating }}</span>
                                <span>👥 {{ $students }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-2xl font-bold text-secondary">S/ {{ $price }}</p>
                                <div class="flex gap-2">
                                    @if($model)
                                        <a href="{{ route('cursos.show', $model) }}" class="btn-secondary rounded-full px-4">Ver más</a>
                                        <form action="{{ route('cursos.enroll', $model) }}" method="POST">
                                            @csrf
                                            <button class="btn-gradient rounded-full px-4">Inscribirme</button>
                                        </form>
                                    @else
                                        <a href="{{ route('cursos.index') }}" class="btn-secondary rounded-full px-4">Ver más</a>
                                        <button class="btn-gradient rounded-full px-4" type="button">Inscribirme</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="flex flex-wrap items-center justify-center gap-2 pt-4">
                <button class="rounded-full border border-slate-200 px-3 py-1 text-sm text-slate-500">Anterior</button>
                @foreach(range(1, 3) as $page)
                    <button class="rounded-full px-3 py-1 text-sm {{ $page === 2 ? 'bg-primary text-white' : 'border border-slate-200 text-secondary' }}">{{ $page }}</button>
                @endforeach
                <span class="px-3 py-1 text-sm text-slate-400">...</span>
                <button class="rounded-full border border-slate-200 px-3 py-1 text-sm text-secondary">10</button>
                <button class="rounded-full border border-slate-200 px-3 py-1 text-sm text-secondary">Siguiente</button>
            </div>
        </section>
    </div>
@endsection
