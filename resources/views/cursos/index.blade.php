@extends('layouts.app')

@push('styles')
<style>
    .courses-layout {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 32px;
    }
    .filters-panel {
        background: #fff;
        border-radius: 24px;
        padding: 28px;
        box-shadow: var(--shadow-card);
        border: 1px solid rgba(0,0,0,0.04);
        align-self: start;
    }
    .filters-panel h2 {
        font-size: 1.1rem;
        margin-bottom: 4px;
        color: var(--color-text);
    }
    .filters-panel hr {
        border: none;
        height: 1px;
        background: rgba(0,0,0,0.06);
        margin: 18px 0;
    }
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .filter-group label {
        font-size: 0.9rem;
        color: rgba(51,51,51,0.75);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .filter-search {
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: 16px;
        padding: 8px 12px;
        background: #fff;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.03);
    }
    .filter-search input {
        border: none;
        flex: 1;
        font-size: 0.95rem;
        color: var(--color-text);
    }
    .filter-search input:focus { outline: none; }
    .courses-results {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }
    .results-topbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    .results-topbar h1 {
        font-size: 2rem;
        margin: 0;
        color: var(--color-text);
    }
    .results-controls {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .results-controls select {
        border-radius: 999px;
        border: 1px solid rgba(0,0,0,0.12);
        padding: 10px 18px;
        font-weight: 600;
        color: var(--color-text);
        background: #fff;
    }
    .view-toggle {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px;
        border-radius: 999px;
        border: 1px solid rgba(0,0,0,0.08);
        background: #fff;
    }
    .view-toggle button {
        border: none;
        background: transparent;
        border-radius: 999px;
        padding: 6px 12px;
        cursor: pointer;
        font-weight: 600;
        color: rgba(51,51,51,0.5);
    }
    .view-toggle button.is-active {
        background: rgba(108,71,255,0.12);
        color: var(--color-primary);
    }
    .results-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 24px;
    }
    .course-card {
        display: flex;
        flex-direction: column;
        border-radius: 24px;
        overflow: hidden;
        background: #fff;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: var(--shadow-card);
    }
    .course-card img {
        width: 100%;
        height: 190px;
        object-fit: cover;
    }
    .course-card .card-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .course-card__meta {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 0.85rem;
        color: rgba(51,51,51,0.65);
    }
    .course-card footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 8px;
    }
    .pill {
        padding: 4px 12px;
        border-radius: 999px;
        background: rgba(108,71,255,0.12);
        color: var(--color-primary);
        font-size: 0.8rem;
        font-weight: 600;
        width: fit-content;
    }
    .pagination {
        display: flex;
        gap: 8px;
        justify-content: center;
        padding-top: 12px;
    }
    .pagination button {
        border-radius: 999px;
        border: 1px solid rgba(0,0,0,0.12);
        background: #fff;
        padding: 8px 14px;
        font-size: 0.9rem;
        cursor: pointer;
    }
    .pagination button.is-active {
        background: var(--color-primary);
        color: #fff;
        border-color: var(--color-primary);
    }
    @media (max-width: 960px) {
        .courses-layout {
            grid-template-columns: 1fr;
        }
        .filters-panel {
            position: relative;
        }
    }
</style>
@endpush

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

    <div class="courses-layout py-12">
        <aside class="filters-panel">
            <div class="flex items-center justify-between">
                <h2>Filtros</h2>
                <a href="{{ route('cursos.index') }}" class="text-sm font-semibold" style="color: var(--color-primary);">Limpiar todo</a>
            </div>

            <hr>
            <form class="space-y-5">
                <div class="filter-group">
                    <label class="text-sm font-semibold" style="color: var(--color-text);">Búsqueda</label>
                    <div class="filter-search">
                        <svg width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="rgba(51,51,51,0.5)" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.35-4.35"/>
                        </svg>
                        <input type="text" placeholder="Buscar por título...">
                    </div>
                </div>

                <div class="filter-group">
                    <p class="text-sm font-semibold" style="color: var(--color-text);">Categoría</p>
                    @foreach(['Programación (234)', 'Diseño (156)', 'Marketing (98)'] as $category)
                        <label>
                            <input type="radio" name="category" {{ $loop->first ? 'checked' : '' }}>
                            {{ $category }}
                        </label>
                    @endforeach
                </div>

                <div class="filter-group">
                    <p class="text-sm font-semibold" style="color: var(--color-text);">Precio</p>
                    @foreach(['Todos', 'Gratis', '< S/ 100', 'S/ 100 - 200'] as $price)
                        <label>
                            <input type="radio" name="price" {{ $loop->first ? 'checked' : '' }}>
                            {{ $price }}
                        </label>
                    @endforeach
                </div>

                <div class="filter-group">
                    <p class="text-sm font-semibold" style="color: var(--color-text);">Nivel</p>
                    @foreach(['Principiante', 'Intermedio', 'Avanzado'] as $level)
                        <label>
                            <input type="radio" name="level" {{ $loop->first ? 'checked' : '' }}>
                            {{ $level }}
                        </label>
                    @endforeach
                </div>

                <button type="button" class="btn-primary w-full justify-center">Aplicar filtros</button>
            </form>
        </aside>

        <section class="courses-results">
            <div class="results-topbar">
                <div>
                    <p class="text-sm" style="color: rgba(51,51,51,0.6);">Resultados</p>
                    <h1>{{ $totalCursos }} cursos encontrados</h1>
                </div>
                <div class="results-controls">
                    <select>
                        <option>Relevancia</option>
                        <option>Más populares</option>
                        <option>Precio: menor a mayor</option>
                        <option>Precio: mayor a menor</option>
                    </select>
                    <div class="view-toggle">
                        <button type="button" class="is-active">☰</button>
                        <button type="button">▦</button>
                    </div>
                </div>
            </div>

            <div class="results-grid">
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

                    <article class="course-card">
                        <div style="position: relative;">
                            <img src="{{ $image }}" alt="{{ $title }}">
                            <span class="pill" style="position:absolute; top:16px; left:16px;">{{ $category }}</span>
                        </div>
                        <div class="card-body">
                            <div>
                                <h3 class="text-xl font-semibold" style="color: var(--color-text);">{{ $title }}</h3>
                                <p style="color: rgba(51,51,51,0.6); font-size: 0.9rem;">{{ $mentor }}</p>
                            </div>
                            <p style="color: rgba(51,51,51,0.7); font-size: 0.95rem;">{{ Str::limit($description, 110) }}</p>
                            <div class="course-card__meta">
                                <span>⭐ {{ $rating }}</span>
                                <span>👥 {{ $students }}</span>
                            </div>
                            <footer>
                                <p class="text-2xl font-bold" style="color: var(--color-text);">S/ {{ $price }}</p>
                                <div class="flex gap-2">
                                    @if($model)
                                        <a href="{{ route('cursos.show', $model) }}" class="btn-secondary" style="border-radius:999px;">Ver más</a>
                                    @else
                                        <a href="{{ route('cursos.index') }}" class="btn-secondary" style="border-radius:999px;">Ver más</a>
                                    @endif
                                </div>
                            </footer>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="pagination">
                <button>Anterior</button>
                @foreach(range(1, 3) as $page)
                    <button class="{{ $page === 2 ? 'is-active' : '' }}">{{ $page }}</button>
                @endforeach
                <span style="padding:8px 12px; color: rgba(51,51,51,0.6);">...</span>
                <button>10</button>
                <button>Siguiente</button>
            </div>
        </section>
    </div>
@endsection
