@extends('layouts.dashboard')

{{-- // Vista adaptada al diseño oficial de SkillNest --}}

@section('dashboard-title', 'Editor de curso')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-pIVp98VYqCw42Hcps225y7sY9qsK0kGugHgdGXNq35p3xNmPR9U1FVLtZL1YI7Di5urN6LyjHgNsZM3Rp3crGQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        :root {
            --editor-surface: rgba(255, 255, 255, 0.97);
            --editor-border: rgba(15, 23, 42, 0.08);
            --editor-radius: 32px;
        }

        .editor-banner {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1.25rem;
            padding: 1.5rem 1.75rem;
            border-radius: 40px;
            border: 1px solid var(--editor-border);
            background: linear-gradient(135deg, #ffffff 0%, rgba(248, 250, 255, 0.9) 100%);
            box-shadow: 0 22px 55px rgba(15, 23, 42, 0.1);
        }

        .editor-banner__caption {
            letter-spacing: 0.35em;
            text-transform: uppercase;
            font-size: 0.72rem;
            color: #94a3b8;
            margin-bottom: 0.35rem;
        }

        .editor-banner__title {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
        }

        .editor-banner__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .editor-banner__actions form {
            margin: 0;
        }

        .btn-pill,
        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border-radius: 999px;
            font-weight: 600;
            padding: 0.85rem 1.75rem;
            border: 1px solid transparent;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .btn-pill {
            background: linear-gradient(120deg, var(--color-primary), #8b5cf6);
            color: #fff;
            box-shadow: 0 18px 36px rgba(108, 71, 255, 0.35);
        }

        .btn-pill:hover {
            transform: translateY(-1px);
        }

        .btn-outline {
            background: #fff;
            color: var(--color-primary);
            border-color: rgba(108, 71, 255, 0.35);
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.07);
        }

        .btn-outline:hover {
            background: rgba(108, 71, 255, 0.08);
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .editor-shell {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .editor-toast {
            position: fixed;
            top: 6.5rem;
            right: 1.5rem;
            z-index: 50;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.85rem 1.5rem;
            border-radius: 999px;
            background: linear-gradient(120deg, #34d399, #059669);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 22px 45px rgba(16, 185, 129, 0.35);
        }

        .editor-toast.editor-toast--error {
            background: linear-gradient(120deg, #f87171, #ef4444);
            box-shadow: 0 22px 45px rgba(248, 113, 113, 0.35);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.25rem;
        }

        .stat-card {
            background: var(--editor-surface);
            border-radius: var(--editor-radius);
            border: 1px solid var(--editor-border);
            box-shadow: 0 25px 55px rgba(15, 23, 42, 0.08);
            padding: 1.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .stat-label {
            letter-spacing: 0.25em;
            text-transform: uppercase;
            font-size: 0.72rem;
            font-weight: 700;
            color: #94a3b8;
        }

        .stat-value {
            font-size: 2.4rem;
            font-weight: 900;
            background: linear-gradient(120deg, var(--color-primary), #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border-radius: 999px;
            padding: 0.5rem 1.2rem;
            border: 1px solid rgba(108, 71, 255, 0.2);
            background: linear-gradient(135deg, rgba(108, 71, 255, 0.12), rgba(139, 92, 246, 0.12));
            color: var(--color-primary);
            font-size: 0.85rem;
            font-weight: 600;
        }

        .stat-meta {
            font-size: 0.85rem;
            color: #64748b;
        }

        .editor-grid {
            display: grid;
            grid-template-columns: minmax(0, 2.25fr) minmax(260px, 360px);
            gap: clamp(1.25rem, 3vw, 2.25rem);
            align-items: flex-start;
        }

        @media (min-width: 1440px) {
            .editor-grid {
                grid-template-columns: minmax(0, 2.6fr) minmax(280px, 380px);
            }
        }

        .editor-main-column {
            display: flex;
            flex-direction: column;
            gap: 1.75rem;
        }

        .course-meta {
            margin: 0.2rem 0 0;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .course-meta strong {
            color: #0f172a;
            font-weight: 700;
        }

        .editor-card {
            background: var(--editor-surface);
            border-radius: var(--editor-radius);
            border: 1px solid var(--editor-border);
            box-shadow: 0 30px 60px rgba(15, 23, 42, 0.1);
            padding: 2rem;
        }

        .editor-panel {
            display: flex;
            flex-direction: column;
            gap: 1.75rem;
        }

        .editor-structure {
            display: flex;
            flex-direction: column;
        }

        .panel-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }

        .panel-subtitle {
            margin: 0.25rem 0 0;
            font-size: 0.9rem;
            color: #64748b;
        }

        .editor-section-title {
            letter-spacing: 0.35em;
            text-transform: uppercase;
            font-size: 0.75rem;
            color: #94a3b8;
        }

        .editor-section-heading {
            margin: 0.2rem 0 0;
            font-size: 1.45rem;
            font-weight: 800;
            color: #0f172a;
        }

        .cover-picker {
            position: relative;
            border-radius: 28px;
            overflow: hidden;
            border: 1px dashed rgba(15, 23, 42, 0.12);
            background: linear-gradient(135deg, #f8fafc, #eef2ff);
        }

        .cover-picker img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            display: block;
        }

        .cover-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            border: none;
            border-radius: 999px;
            padding: 0.4rem 1.1rem;
            background: #fff;
            color: var(--color-primary);
            font-weight: 700;
            font-size: 0.75rem;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.15);
        }

        .hint-text {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        .file-upload {
            width: 100%;
            border: 1px dashed rgba(15, 23, 42, 0.2);
            border-radius: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.9rem 1.2rem;
            cursor: pointer;
            background: linear-gradient(135deg, rgba(248, 250, 255, 0.6), rgba(238, 242, 255, 0.6));
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .file-upload:hover {
            border-color: var(--color-primary);
            box-shadow: 0 10px 25px rgba(108, 71, 255, 0.15);
        }

        .file-upload__action {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-weight: 700;
            color: var(--color-primary);
        }

        .file-upload__name {
            font-size: 0.9rem;
            color: #475569;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 55%;
        }

        .basic-fields {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .form-stack label {
            display: block;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 0.4rem;
        }

        .form-stack input,
        .form-stack textarea,
        .form-stack select {
            width: 100%;
            border-radius: 18px;
            border: 1px solid rgba(15, 23, 42, 0.12);
            background: #fff;
            padding: 0.95rem 1.15rem;
            font-size: 0.95rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }

        .form-stack input:hover,
        .form-stack textarea:hover,
        .form-stack select:hover {
            border-color: rgba(108, 71, 255, 0.5);
        }

        .form-stack input:focus,
        .form-stack textarea:focus,
        .form-stack select:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(108, 71, 255, 0.12);
            outline: none;
            transform: translateY(-1px);
        }

        .form-stack textarea {
            resize: vertical;
            min-height: 110px;
        }

        .modules-head {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .modules-head {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            margin-bottom: 1.5rem;
        }

        .module-card {
            border-radius: 28px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            background: #fff;
            padding: 1.5rem;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
            transition: border-color 0.2s ease, transform 0.2s ease;
        }

        .module-card + .module-card {
            margin-top: 1rem;
        }

        .module-card:hover {
            border-color: rgba(108, 71, 255, 0.45);
            transform: translateY(-2px);
        }

        .module-top {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .module-fields {
            flex: 1;
            min-width: 240px;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .module-fields input,
        .module-fields textarea {
            width: 100%;
            border-radius: 1rem;
            border: 1px solid rgba(15, 23, 42, 0.12);
            padding: 0.85rem 1rem;
            background: #f8fafc;
        }

        .module-actions {
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            flex-wrap: wrap;
        }

        .module-actions button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            border-radius: 16px;
            padding: 0.65rem 0.9rem;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid transparent;
            cursor: pointer;
            background: #f8fafc;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .module-actions button:hover {
            transform: translateY(-2px);
        }

        .module-handle {
            background: #f6f3ff;
            color: var(--color-primary);
            border-color: rgba(108, 71, 255, 0.45);
        }

        .module-add-lesson {
            background: #ecfdf5;
            color: #047857;
            border-color: rgba(16, 185, 129, 0.4);
        }

        .module-delete {
            background: #fef2f2;
            color: #b91c1c;
            border-color: rgba(248, 113, 113, 0.4);
        }

        .lessons-wrapper {
            margin-top: 1rem;
        }

        .lesson-block {
            border-radius: 22px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            padding: 1.25rem;
            background: linear-gradient(135deg, #f9f9ff, #f2f5ff);
            transition: border-color 0.2s ease;
        }

        .lesson-block + .lesson-block {
            margin-top: 1rem;
        }

        .lesson-block:hover {
            border-color: var(--color-primary);
        }

        .lesson-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            align-items: center;
        }

        .lesson-row input,
        .lesson-row select {
            flex: 1;
            min-width: 140px;
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, 0.12);
            padding: 0.75rem 0.9rem;
            background: #fff;
            font-weight: 600;
        }

        .lesson-extra {
            margin-top: 0.85rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            font-size: 0.9rem;
            color: #475569;
        }

        .lesson-extra input,
        .lesson-extra textarea,
        .lesson-editor {
            border-radius: 16px;
            border: 1px solid rgba(15, 23, 42, 0.12);
            padding: 0.85rem 1rem;
            background: #fff;
        }

        .lesson-editor {
            min-height: 110px;
            white-space: pre-wrap;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
            border-radius: 28px;
            border: 1px dashed rgba(15, 23, 42, 0.12);
            background: #f8fafc;
        }

        .empty-state i {
            font-size: 2.5rem;
            color: #cbd5f5;
            margin-bottom: 1rem;
        }

        .checklist {
            list-style: none;
            padding: 0;
            margin: 1.25rem 0 0;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .checklist li {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-weight: 500;
            color: #0f172a;
        }

        .check-dot {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 1px solid rgba(15, 23, 42, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            color: #0f172a;
        }

        .check-dot.fill {
            background: linear-gradient(120deg, #10b981, #059669);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 10px 24px rgba(16, 185, 129, 0.35);
        }

        .tips-card {
            border-radius: 28px;
            border: 1px solid rgba(59, 130, 246, 0.2);
            background: linear-gradient(145deg, #f0f9ff, #e0f2fe);
            padding: 1.5rem;
        }

        .tips-card ul {
            list-style: none;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 0.9rem;
            margin: 1rem 0 0;
        }

        .tips-card li {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 0.9rem;
            color: #0f172a;
        }

        .tips-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: #2563eb;
        }

        .tips-dot--amber {
            background: #f59e0b;
        }

        .tips-dot--emerald {
            background: #10b981;
        }

        .progress-track {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 1rem;
        }

        .progress-track__bar {
            height: 8px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.1);
            overflow: hidden;
        }

        .progress-track__bar span {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(120deg, var(--color-primary), #8b5cf6);
        }

        @media (max-width: 1280px) {
            .editor-grid {
                grid-template-columns: minmax(0, 1fr);
            }
        }

        @media (max-width: 768px) {
            .editor-card {
                padding: 1.5rem;
            }

            .editor-banner {
                padding: 1.25rem;
            }

            .btn-pill,
            .btn-outline {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush
@section('dashboard-actions')
    <div class="editor-banner">
        <div>
            <p class="editor-banner__caption">Acciones rápidas</p>
            <h3 class="editor-banner__title">Gestiona tu publicación</h3>
        </div>
        <div class="editor-banner__actions">
            <a href="{{ route('cursos.show', $curso) }}" class="btn-outline">
                <i class="fas fa-eye"></i>
                <span>Vista previa</span>
            </a>
            <form action="{{ route('cursos.send-to-review', $curso) }}" method="POST">
                @csrf
                <button type="submit" class="btn-pill">
                    <i class="fas fa-paper-plane"></i>
                    <span>Enviar a revisión</span>
                </button>
            </form>
        </div>
    </div>
@endsection

@php
    $modulesCount = $curso->modules->count();
    $lessonsCount = $curso->modules->sum(fn($module) => $module->lessons->count());
@endphp

@php
    $initialImage = $curso->image_url
        ? (\Illuminate\Support\Str::startsWith($curso->image_url, ['http://', 'https://'])
            ? $curso->image_url
            : asset($curso->image_url))
        : 'https://picsum.photos/seed/' . $curso->id . '/800/600';
    $basicFields = [
        ['name' => 'title', 'label' => 'Título del curso', 'type' => 'text', 'placeholder' => 'Ej. Diseño UX para principiantes'],
        ['name' => 'category', 'label' => 'Categoría', 'type' => 'text', 'placeholder' => 'Ej. Tecnología'],
        ['name' => 'level', 'label' => 'Nivel', 'type' => 'select', 'options' => ['principiante', 'intermedio', 'avanzado']],
        ['name' => 'price', 'label' => 'Precio (S/)', 'type' => 'number', 'step' => '0.01', 'min' => 0],
        ['name' => 'duration', 'label' => 'Duración (horas)', 'type' => 'number', 'min' => 1],
        ['name' => 'description', 'label' => 'Descripción corta', 'type' => 'textarea', 'rows' => 3],
        ['name' => 'objectives', 'label' => 'Objetivos de aprendizaje', 'type' => 'textarea', 'rows' => 3],
        ['name' => 'requirements', 'label' => 'Requisitos', 'type' => 'textarea', 'rows' => 3],
    ];
@endphp

@php
    $courseDetail = [
        'title' => $curso->titulo ?? $curso->title ?? 'Curso sin título',
        'category' => data_get($curso, 'categoria.nombre') ?? $curso->category ?? 'General',
        'level' => $curso->nivel ?? $curso->level ?? 'principiante',
        'price' => $curso->precio ?? $curso->price ?? 0,
        'duration' => $curso->duracion ?? $curso->duration ?? 1,
        'description' => $curso->descripcion ?? $curso->description ?? '',
        'objectives' => $curso->objetivos ?? $curso->objectives ?? '',
        'requirements' => $curso->requisitos ?? $curso->requirements ?? '',
    ];

    $courseFieldMap = [
        'title' => $courseDetail['title'],
        'category' => $courseDetail['category'],
        'level' => strtolower((string) $courseDetail['level']),
        'price' => $courseDetail['price'],
        'duration' => $courseDetail['duration'],
        'description' => $courseDetail['description'],
        'objectives' => $courseDetail['objectives'],
        'requirements' => $courseDetail['requirements'],
    ];

@endphp

@section('dashboard-content')
    <div class="editor-shell">
        <div id="editor-toast" class="editor-toast hidden" role="status" aria-live="polite">
            <i class="fas fa-check-circle"></i>
            <span data-toast-message>Cambios guardados correctamente</span>
        </div>

        <div class="stats-grid">
            <article class="stat-card">
                <span class="stat-label">Estado del curso</span>
                <div class="flex flex-wrap items-center gap-3">
                    <span class="status-pill">
                        <i class="fas fa-pencil-alt"></i>
                        <span class="capitalize" id="course-status">{{ $curso->status }}</span>
                    </span>
                    <span class="stat-meta" id="last-saved-indicator">Último guardado hace instantes</span>
                </div>
            </article>
            <article class="stat-card">
                <span class="stat-label">Módulos</span>
                <span class="stat-value">{{ $modulesCount }}</span>
                <p class="stat-meta">Estructuras creadas</p>
            </article>
            <article class="stat-card">
                <span class="stat-label">Lecciones</span>
                <span class="stat-value">{{ $lessonsCount }}</span>
                <p class="stat-meta">Bloques de contenido</p>
            </article>
        </div>

        {{-- // Mantiene compatibilidad con scripts originales --}}
        <div id="course-editor"
             data-course-id="{{ $curso->id }}"
             data-basics-endpoint="{{ route('cursos.update-basics', $curso) }}"
             data-order-endpoint="{{ route('cursos.order', $curso) }}"
             data-image-endpoint="{{ route('cursos.update-image', $curso) }}"
             class="editor-grid">
            <div class="editor-main-column">
                {{-- // Sección: Información del curso --}}
                <article class="editor-card editor-panel form-stack course-basics-card">
                    <div>
                        <span class="editor-section-title">Base del curso</span>
                        <h2 class="editor-section-heading">Portada e información clave</h2>
                        <p class="course-meta">Curso: <strong>{{ $courseDetail['title'] }}</strong></p>
                        <p class="course-meta">Categoría actual: <strong>{{ $courseDetail['category'] }}</strong></p>
                        <p class="course-meta">Nivel: <strong>{{ ucfirst($courseDetail['level']) }}</strong></p>
                    </div>
                    <div class="cover-picker">
                        <img id="course-image-preview" src="{{ $initialImage }}" alt="Imagen del curso">
                        <span class="cover-badge">Portada</span>
                    </div>
                    <input type="file" accept="image/*" id="course-image-input" class="sr-only">
                    <label for="course-image-input" class="file-upload">
                        <span class="file-upload__action">
                            <i class="fas fa-upload"></i>
                            <span>Seleccionar archivo</span>
                        </span>
                        <span class="file-upload__name" data-file-name>JPG o PNG hasta 4 MB</span>
                    </label>
                    <p class="hint-text">Formatos permitidos: JPG o PNG (máx. 4 MB)</p>

                    <div class="basic-fields">
                        @foreach($basicFields as $field)
                            @php
                                $fieldValue = old($field['name'], $courseFieldMap[$field['name']] ?? ($curso->{$field['name']} ?? ''));
                                $fieldId = 'field-' . $field['name'];
                            @endphp
                            <div>
                                <label for="{{ $fieldId }}">{{ $field['label'] }}</label>
                                @if($field['type'] === 'select')
                                    <select id="{{ $fieldId }}" data-basic-field="{{ $field['name'] }}">
                                        @foreach($field['options'] as $option)
                                            <option value="{{ $option }}" @selected($fieldValue === $option)>{{ ucfirst($option) }}</option>
                                        @endforeach
                                    </select>
                                @elseif($field['type'] === 'textarea')
                                    <textarea id="{{ $fieldId }}"
                                              rows="{{ $field['rows'] ?? 3 }}"
                                              data-basic-field="{{ $field['name'] }}"
                                              placeholder="{{ $field['placeholder'] ?? '' }}">{{ $fieldValue }}</textarea>
                                @else
                                    <input id="{{ $fieldId }}"
                                           type="{{ $field['type'] }}"
                                           data-basic-field="{{ $field['name'] }}"
                                           value="{{ $fieldValue }}"
                                           placeholder="{{ $field['placeholder'] ?? '' }}"
                                           @if(isset($field['step'])) step="{{ $field['step'] }}" @endif
                                           @if(isset($field['min'])) min="{{ $field['min'] }}" @endif>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </article>

                {{-- // Sección: Módulos y lecciones dinámicas --}}
                <section class="editor-card editor-structure">
                    <div class="modules-head">
                        <div>
                            <span class="editor-section-title">Estructura del curso</span>
                            <h2 class="editor-section-heading">Organiza módulos y lecciones</h2>
                        </div>
                        <button type="button" id="add-module-btn" class="btn-pill">
                            <i class="fas fa-plus"></i>
                            <span>Agregar módulo</span>
                        </button>
                    </div>

                    <div id="modules-canvas">
                        @forelse($curso->modules as $module)
                            <div class="module-card" data-module-id="{{ $module->id }}">
                                <div class="module-top">
                                    <div class="module-fields">
                                        <input type="text" class="module-title" value="{{ $module->title }}" placeholder="Título del módulo">
                                        <textarea class="module-description" placeholder="Describe el módulo (opcional)">{{ $module->description }}</textarea>
                                    </div>
                                    <div class="module-actions">
                                        <button type="button" class="module-handle" title="Arrastrar módulo">
                                            <i class="fas fa-grip-vertical"></i>
                                        </button>
                                        <button type="button" class="module-add-lesson">
                                            <i class="fas fa-plus"></i>
                                            <span>Lección</span>
                                        </button>
                                        <button type="button" class="module-delete" title="Eliminar módulo">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="lessons-wrapper" data-lessons-container>
                                    @foreach($module->lessons as $lesson)
                                        <div class="lesson-block" data-lesson-id="{{ $lesson->id }}">
                                            <div class="lesson-row">
                                                <button type="button" class="module-handle lesson-handle" title="Arrastrar lección">
                                                    <i class="fas fa-grip-lines"></i>
                                                </button>
                                                <input type="text" class="lesson-title" value="{{ $lesson->title }}" placeholder="Título de la lección">
                                                <select class="lesson-type">
                                                    @foreach(['video','reading','quiz','live','file'] as $type)
                                                        <option value="{{ $type }}" @selected($lesson->type === $type)>{{ ucfirst($type) }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="module-delete lesson-delete" title="Eliminar lección">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <div class="lesson-extra">
                                                <input type="text" class="lesson-video hidden" placeholder="URL del video" value="{{ $lesson->video_url }}">
                                                <input type="text" class="lesson-resource hidden" placeholder="URL del recurso" value="{{ $lesson->resource_url }}">
                                                <div class="lesson-editor hidden" contenteditable="true">{{ $lesson->content }}</div>
                                                <textarea class="lesson-content hidden" rows="3" placeholder="Contenido">{{ $lesson->content }}</textarea>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="empty-state" data-empty-state>
                                <i class="fas fa-book-open"></i>
                                <h3 class="panel-title">Sin módulos todavía</h3>
                                <p class="panel-subtitle">Agrega tu primera estructura para empezar a planificar.</p>
                                <button type="button" class="btn-pill mt-4" id="add-first-module">
                                    <i class="fas fa-plus"></i>
                                    <span>Agregar primer módulo</span>
                                </button>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

            {{-- // Sección: Checklist de completado --}}
            <aside class="editor-card editor-panel">
                <div>
                    <h3 class="panel-title">Checklist de completado</h3>
                    <p class="panel-subtitle">Usa esta guía para validar tu curso.</p>
                    <ul class="checklist" id="editor-checklist">
                        <li>
                            <span class="check-dot" data-check="basics"></span>
                            <span>Información básica completa</span>
                        </li>
                        <li>
                            <span class="check-dot" data-check="modules"></span>
                            <span>Al menos un módulo</span>
                        </li>
                        <li>
                            <span class="check-dot" data-check="lessons"></span>
                            <span>Módulos con lecciones</span>
                        </li>
                        <li>
                            <span class="check-dot" data-check="objectives"></span>
                            <span>Objetivos definidos</span>
                        </li>
                        <li>
                            <span class="check-dot" data-check="requirements"></span>
                            <span>Requisitos definidos</span>
                        </li>
                    </ul>
                </div>
                <div class="tips-card">
                    <h4 class="panel-title">Consejos rápidos</h4>
                    <ul>
                        <li>
                            <span class="tips-dot"></span>
                            <span>Describe beneficios claros en la sección de objetivos.</span>
                        </li>
                        <li>
                            <span class="tips-dot tips-dot--amber"></span>
                            <span>Combina videos y lecturas para mantener el ritmo.</span>
                        </li>
                        <li>
                            <span class="tips-dot tips-dot--emerald"></span>
                            <span>Adjunta archivos para sumar valor descargable.</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="panel-title">Progreso del curso</h3>
                    <div class="progress-track">
                        <div>
                            <div class="flex justify-between text-sm font-semibold text-slate-600">
                                <span>Borrador</span>
                                <span>{{ $modulesCount ? 'Completado' : 'Pendiente' }}</span>
                            </div>
                            <div class="progress-track__bar">
                                <span style="width: {{ $modulesCount ? '70%' : '30%' }}"></span>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm font-semibold text-slate-600">
                                <span>Revisión</span>
                                <span>{{ $curso->status === 'pendiente' ? 'Enviado' : 'Por enviar' }}</span>
                            </div>
                            <div class="progress-track__bar">
                                <span style="width: {{ $curso->status === 'pendiente' ? '80%' : '35%' }}"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        (() => {
            const editor = document.getElementById('course-editor');
            if (!editor) return;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const courseId = editor.dataset.courseId;
            const basicsEndpoint = editor.dataset.basicsEndpoint;
            const orderEndpoint = editor.dataset.orderEndpoint;
            const imageEndpoint = editor.dataset.imageEndpoint;
            const lastSavedIndicator = document.getElementById('last-saved-indicator');
            const modulesCanvas = document.getElementById('modules-canvas');
            const imageInput = document.getElementById('course-image-input');
            const imagePreview = document.getElementById('course-image-preview');
            const fileNameLabel = document.querySelector('[data-file-name]');

            const toast = document.getElementById('editor-toast');
            const toastMessage = toast?.querySelector('[data-toast-message]');
            let toastTimer = null;
            const showToast = (message, variant = 'success') => {
                if (!toast) return;
                if (toastMessage) toastMessage.textContent = message;
                toast.classList.remove('hidden', 'editor-toast--error');
                if (variant === 'error') {
                    toast.classList.add('editor-toast--error');
                }
                if (toastTimer) clearTimeout(toastTimer);
                toastTimer = setTimeout(() => toast?.classList.add('hidden'), 2600);
            };

            const fetchJson = (url, options = {}) => fetch(url, Object.assign({
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }, options)).then(async response => {
                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(errorText || 'Error al guardar');
                }
                return response.json();
            });

            const debounce = (fn, delay = 600) => {
                let timer;
                return (...args) => {
                    clearTimeout(timer);
                    timer = setTimeout(() => fn.apply(this, args), delay);
                };
            };

            const updateLastSaved = () => {
                lastSavedIndicator.textContent = 'Último guardado: ' + new Date().toLocaleTimeString();
            };

            const basics = editor.querySelectorAll('[data-basic-field]');
            const handleBasicSave = debounce(() => {
                const payload = {};
                basics.forEach(el => payload[el.dataset.basicField] = el.value);
                fetchJson(basicsEndpoint, {
                    method: 'PUT',
                    body: JSON.stringify(payload)
                }).then(() => {
                    updateLastSaved();
                    showToast('Información básica guardada');
                    refreshChecklist();
                }).catch(err => {
                    console.error(err);
                    showToast('Error guardando datos básicos', 'error');
                });
            });
            basics.forEach(el => el.addEventListener('input', handleBasicSave));

            if (imageInput && imageEndpoint) {
                imageInput.addEventListener('change', () => {
                    if (!imageInput.files.length) return;
                    const [file] = imageInput.files;
                    if (fileNameLabel) fileNameLabel.textContent = file.name;
                    if (imagePreview) {
                        const tempUrl = URL.createObjectURL(file);
                        imagePreview.src = tempUrl;
                        setTimeout(() => URL.revokeObjectURL(tempUrl), 5000);
                    }
                    const formData = new FormData();
                    formData.append('image', file);
                    fetch(imageEndpoint, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: formData,
                    }).then(response => {
                        if (!response.ok) throw new Error('Error al subir imagen');
                        return response.json();
                    }).then(({ image_url }) => {
                        if (imagePreview) imagePreview.src = image_url;
                        showToast('Imagen actualizada');
                    }).catch(err => {
                        console.error(err);
                        showToast('No se pudo actualizar la imagen', 'error');
                    }).finally(() => {
                        imageInput.value = '';
                        if (fileNameLabel) fileNameLabel.textContent = 'JPG o PNG hasta 4 MB';
                    });
                });
            }
            const removeEmptyState = () => {
                modulesCanvas?.querySelector('[data-empty-state]')?.remove();
            };

            const emptyStateTemplate = () => `
                <div class="empty-state" data-empty-state>
                    <i class="fas fa-book-open"></i>
                    <h3 class="panel-title">Sin módulos todavía</h3>
                    <p class="panel-subtitle">Agrega tu primera estructura para empezar a planificar.</p>
                    <button type="button" class="btn-pill mt-4" id="add-first-module">
                        <i class="fas fa-plus"></i>
                        <span>Agregar primer módulo</span>
                    </button>
                </div>
            `;

            const bindAddFirstModuleBtn = () => {
                const addFirstModuleBtn = document.getElementById('add-first-module');
                addFirstModuleBtn?.addEventListener('click', handleCreateModule);
            };

            const ensureEmptyState = () => {
                if (!modulesCanvas) return;
                const hasModules = modulesCanvas.querySelector('.module-card');
                const hasEmptyState = modulesCanvas.querySelector('[data-empty-state]');
                if (!hasModules && !hasEmptyState) {
                    modulesCanvas.insertAdjacentHTML('beforeend', emptyStateTemplate());
                    bindAddFirstModuleBtn();
                }
            };

            const sendReorder = debounce(() => {
                const modulesOrder = Array.from(modulesCanvas.querySelectorAll('.module-card'))
                    .map(card => card.dataset.moduleId);

                const lessonsOrder = {};
                modulesCanvas.querySelectorAll('.module-card').forEach(card => {
                    const moduleId = card.dataset.moduleId;
                    const lessons = Array.from(card.querySelectorAll('.lesson-block')).map(block => block.dataset.lessonId);
                    lessonsOrder[moduleId] = lessons;
                });

                fetchJson(orderEndpoint, {
                    method: 'PUT',
                    body: JSON.stringify({ modules: modulesOrder, lessons: lessonsOrder })
                }).then(() => {
                    updateLastSaved();
                    showToast('Orden actualizado');
                }).catch(err => {
                    console.error(err);
                    showToast('No se pudo guardar el orden', 'error');
                });
            }, 400);
            const buildLessonBlock = (lesson) => {
                const template = document.createElement('div');
                template.className = 'lesson-block';
                template.dataset.lessonId = lesson.id;
                template.innerHTML = `
                    <div class="lesson-row">
                        <button type="button" class="module-handle lesson-handle" title="Arrastrar lección">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 9h4m-4 6h4M5 9h.01M5 15h.01M18.99 9H19m-.01 6H19" />
                            </svg>
                        </button>
                        <input type="text" class="lesson-title" value="${lesson.title}" placeholder="Título de la lección">
                        <select class="lesson-type">
                            ${['video','reading','quiz','live','file'].map(type => `<option value="${type}" ${lesson.type === type ? 'selected' : ''}>${type.charAt(0).toUpperCase() + type.slice(1)}</option>`).join('')}
                        </select>
                        <button type="button" class="module-delete lesson-delete" title="Eliminar lección">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7v10m6-10v10M5 7l1-2h12l1 2M9 21h6" />
                            </svg>
                        </button>
                    </div>
                    <div class="lesson-extra">
                        <input type="text" class="lesson-video hidden" placeholder="URL del video" value="${lesson.video_url ?? ''}">
                        <input type="text" class="lesson-resource hidden" placeholder="URL del recurso" value="${lesson.resource_url ?? ''}">
                        <div class="lesson-editor hidden" contenteditable="true">${lesson.content ?? ''}</div>
                        <textarea class="lesson-content hidden" rows="3" placeholder="Contenido">${lesson.content ?? ''}</textarea>
                    </div>
                `;
                return template;
            };

            const registerLessonBlock = (block) => {
                const lessonId = block.dataset.lessonId;
                const titleInput = block.querySelector('.lesson-title');
                const typeSelect = block.querySelector('.lesson-type');
                const deleteBtn = block.querySelector('.lesson-delete');
                const videoInput = block.querySelector('.lesson-video');
                const resourceInput = block.querySelector('.lesson-resource');
                const textarea = block.querySelector('.lesson-content');
                const editorDiv = block.querySelector('.lesson-editor');

                const toggleFields = () => {
                    const type = typeSelect.value;
                    [videoInput, resourceInput, textarea, editorDiv].forEach(el => el.classList.add('hidden'));
                    if (type === 'video') videoInput.classList.remove('hidden');
                    if (type === 'file') resourceInput.classList.remove('hidden');
                    if (type === 'reading' || type === 'quiz') {
                        editorDiv.classList.remove('hidden');
                        textarea.classList.remove('hidden');
                    }
                };
                toggleFields();

                const saveLesson = debounce(() => {
                    fetchJson(`{{ url('/lessons') }}/${lessonId}`, {
                        method: 'PUT',
                        body: JSON.stringify({
                            title: titleInput.value,
                            type: typeSelect.value,
                            video_url: videoInput.value,
                            resource_url: resourceInput.value,
                            content: textarea.value
                        })
                    }).then(() => {
                        updateLastSaved();
                        showToast('Lección actualizada');
                    }).catch(err => {
                        console.error(err);
                        showToast('No se pudo guardar la lección', 'error');
                    });
                });

                titleInput.addEventListener('input', saveLesson);
                typeSelect.addEventListener('change', () => {
                    toggleFields();
                    saveLesson();
                });
                [videoInput, resourceInput, textarea].forEach(el => el.addEventListener('input', saveLesson));
                editorDiv.addEventListener('input', () => {
                    textarea.value = editorDiv.innerText.trim();
                    saveLesson();
                });

                deleteBtn.addEventListener('click', () => {
                    if (!confirm('¿Eliminar esta lección?')) return;
                    fetchJson(`{{ url('/lessons') }}/${lessonId}`, { method: 'DELETE' })
                        .then(() => {
                            block.remove();
                            sendReorder();
                            refreshChecklist();
                            showToast('Lección eliminada');
                            ensureEmptyState();
                        }).catch(err => {
                            console.error(err);
                            showToast('No se pudo eliminar la lección', 'error');
                        });
                });
            };
            const registerModuleCard = (card) => {
                const moduleId = card.dataset.moduleId;
                const titleInput = card.querySelector('.module-title');
                const descInput = card.querySelector('.module-description');
                const deleteBtn = card.querySelector('.module-delete');
                const addLessonBtn = card.querySelector('.module-add-lesson');
                const lessonsContainer = card.querySelector('[data-lessons-container]');

                const saveModule = debounce(() => {
                    fetchJson(`{{ url('/modules') }}/${moduleId}`, {
                        method: 'PUT',
                        body: JSON.stringify({
                            title: titleInput.value,
                            description: descInput.value
                        })
                    }).then(() => {
                        updateLastSaved();
                        showToast('Módulo actualizado');
                    }).catch(err => {
                        console.error(err);
                        showToast('Error al actualizar módulo', 'error');
                    });
                });

                titleInput.addEventListener('input', saveModule);
                descInput.addEventListener('input', saveModule);

                deleteBtn.addEventListener('click', () => {
                    if (!confirm('¿Eliminar módulo completo?')) return;
                    fetchJson(`{{ url('/modules') }}/${moduleId}`, { method: 'DELETE' })
                        .then(() => {
                            card.remove();
                            sendReorder();
                            refreshChecklist();
                            ensureEmptyState();
                            showToast('Módulo eliminado');
                        })
                        .catch(err => {
                            console.error(err);
                            showToast('No se pudo eliminar el módulo', 'error');
                        });
                });

                addLessonBtn.addEventListener('click', () => {
                    const title = prompt('Título de la lección', 'Nueva lección');
                    if (!title) return;
                    fetchJson(`{{ url('/modules') }}/${moduleId}/lessons`, {
                        method: 'POST',
                        body: JSON.stringify({ title, type: 'video' })
                    }).then(({ lesson }) => {
                        const lessonBlock = buildLessonBlock(lesson);
                        lessonsContainer.appendChild(lessonBlock);
                        registerLessonBlock(lessonBlock);
                        refreshChecklist();
                        showToast('Lección creada');
                    }).catch(err => {
                        console.error(err);
                        showToast('Error creando lección', 'error');
                    });
                });

                new Sortable(lessonsContainer, {
                    handle: '.lesson-handle',
                    animation: 200,
                    onStart: evt => evt.item.classList.add('is-dragging'),
                    onEnd: evt => {
                        evt.item.classList.remove('is-dragging');
                        sendReorder();
                    }
                });

                lessonsContainer.querySelectorAll('.lesson-block').forEach(registerLessonBlock);
            };

            const addModuleBtn = document.getElementById('add-module-btn');

            const handleCreateModule = () => {
                const title = prompt('Nombre del módulo', 'Nuevo módulo');
                if (!title) return;
                fetchJson(`{{ url('/cursos') }}/${courseId}/modules`, {
                    method: 'POST',
                    body: JSON.stringify({ title })
                }).then(({ module }) => {
                    removeEmptyState();
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = `
                        <div class="module-card" data-module-id="${module.id}">
                            <div class="module-top">
                                <div class="module-fields">
                                    <input type="text" class="module-title" value="${module.title}" placeholder="Título del módulo">
                                    <textarea class="module-description" placeholder="Describe el módulo (opcional)"></textarea>
                                </div>
                                <div class="module-actions">
                                    <button type="button" class="module-handle" title="Arrastrar módulo">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 9h14M5 15h14" />
                                        </svg>
                                    </button>
                                    <button type="button" class="module-add-lesson">
                                        <span>+ Lección</span>
                                    </button>
                                    <button type="button" class="module-delete" title="Eliminar módulo">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7v10m6-10v10M5 7l1-2h12l1 2M9 21h6" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="lessons-wrapper" data-lessons-container></div>
                        </div>
                    `;
                    const card = wrapper.firstElementChild;
                    modulesCanvas.appendChild(card);
                    registerModuleCard(card);
                    sendReorder();
                    refreshChecklist();
                    showToast('Módulo creado');
                }).catch(err => {
                    console.error(err);
                    showToast('Error creando módulo', 'error');
                });
            };

            addModuleBtn?.addEventListener('click', handleCreateModule);
            bindAddFirstModuleBtn();

            new Sortable(modulesCanvas, {
                handle: '.module-handle',
                animation: 200,
                onStart: evt => evt.item.classList.add('is-dragging'),
                onEnd: evt => {
                    evt.item.classList.remove('is-dragging');
                    sendReorder();
                }
            });

            modulesCanvas.querySelectorAll('.module-card').forEach(registerModuleCard);

            const refreshChecklist = () => {
                const hasBasics = basics[0]?.value.trim().length > 3;
                const modulesCount = modulesCanvas.querySelectorAll('.module-card').length;
                const lessonsCount = modulesCanvas.querySelectorAll('.lesson-block').length;
                const objectives = editor.querySelector('[data-basic-field="objectives"]').value.trim().length > 0;
                const requirements = editor.querySelector('[data-basic-field="requirements"]').value.trim().length > 0;

                const updateDot = (key, filled) => {
                    const dot = document.querySelector(`.check-dot[data-check="${key}"]`);
                    if (!dot) return;
                    dot.classList.toggle('fill', filled);
                };

                updateDot('basics', hasBasics);
                updateDot('modules', modulesCount > 0);
                updateDot('lessons', modulesCount > 0 && lessonsCount >= modulesCount);
                updateDot('objectives', objectives);
                updateDot('requirements', requirements);
            };

            refreshChecklist();
            ensureEmptyState();
        })();
    </script>
@endpush

