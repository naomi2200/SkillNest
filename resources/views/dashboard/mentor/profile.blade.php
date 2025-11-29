@extends('layouts.mentor')

@php
    $profile = $user->mentorProfile;
    $skillValue = old('skills', $profile ? (is_array($profile->display_skills) ? implode(', ', $profile->display_skills) : ($profile->skills ?? '')) : '');
    $categoryValue = old('categorias', $profile->categorias ?? '');
    $experienceOptions = [
        'junior' => 'Junior (0-2 a&ntilde;os)',
        'mid' => 'Intermedio (3-6 a&ntilde;os)',
        'senior' => 'Senior (7+ a&ntilde;os)',
    ];
    $avatar = $user->avatar_url
        ? (\Illuminate\Support\Str::startsWith($user->avatar_url, ['http://','https://'])
            ? $user->avatar_url
            : asset($user->avatar_url))
        : 'https://ui-avatars.com/api/?name='.urlencode($user->name ?? 'SkillNest').'&background=6366f1&color=fff';
    $experienceYears = old('experiencia_anios', $profile->experiencia_anios ?? 0);
    $hourlyRate = old('precio_hora', $profile->precio_hora ?? 0);
    $currentRole = old('profesion', $profile->profesion ?? '');
    $formattedRate = number_format((float) $hourlyRate, 2, '.', '');
@endphp

@section('mentor-title', 'Mi perfil')
@section('mentor-subtitle', 'Actualiza tu historia profesional y tus tarifas')

@push('styles')
    <style>
        .mentor-profile-layout {
            display: flex;
            flex-direction: column;
            gap: 32px;
            width: 100%;
        }
        .mentor-profile-form {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }
        .mentor-profile-hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 32px;
            padding: clamp(24px, 4vw, 48px);
            border-radius: 36px;
            background: linear-gradient(135deg, #6c47ff, #8b5cf6);
            color: rgba(255,255,255,0.92);
            box-shadow: 0 32px 90px rgba(108,71,255,0.4);
            position: relative;
            overflow: hidden;
            flex-wrap: wrap;
        }
        .mentor-profile-hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 15% 20%, rgba(255,255,255,0.25), transparent 55%),
                radial-gradient(circle at 80% 0%, rgba(255,255,255,0.18), transparent 45%);
            opacity: 0.6;
            pointer-events: none;
        }
        .mentor-profile-hero > * {
            position: relative;
            z-index: 1;
        }
        .mentor-profile-hero h1 {
            margin: 8px 0 12px;
            font-size: clamp(28px, 4vw, 40px);
            color: #fff;
        }
        .mentor-profile-hero p {
            color: rgba(255,255,255,0.9);
            max-width: 520px;
            line-height: 1.6;
        }
        .mentor-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            color: rgba(255,255,255,0.7);
        }
        .mentor-profile-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 16px;
            margin-top: 24px;
        }
        .mentor-meta-label {
            display: block;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.24em;
            color: rgba(255,255,255,0.65);
        }
        .mentor-meta-value {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin-top: 6px;
        }
        .mentor-profile-upload {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 16px;
        }
        .mentor-profile-upload img {
            width: 120px;
            height: 120px;
            border-radius: 34px;
            border: 4px solid rgba(255,255,255,0.5);
            object-fit: cover;
            box-shadow: 0 20px 60px rgba(15,23,42,0.25);
        }
        .mentor-upload-trigger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255,255,255,0.6);
            border-radius: 999px;
            padding: 10px 28px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            transition: transform 0.2s ease, background 0.2s ease;
        }
        .mentor-upload-trigger:hover {
            transform: translateY(-2px);
            background: rgba(255,255,255,0.12);
        }
        .mentor-upload-trigger small {
            display: block;
            color: rgba(255,255,255,0.7);
            margin-top: 4px;
        }
        .mentor-form-sections {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }
        .mentor-card.soft {
            border-radius: 28px;
            border: 1px solid rgba(226,232,240,0.85);
            background: rgba(255,255,255,0.97);
            box-shadow: 0 24px 60px rgba(15,23,42,0.07);
        }
        .mentor-card.soft h2 {
            margin: 0 0 18px;
            font-size: 22px;
            color: #111827;
        }
        .mentor-form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px 24px;
        }
        .mentor-form-field {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .mentor-form-field.full {
            grid-column: 1 / -1;
        }
        .mentor-form-field label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.25em;
            color: #94a3b8;
            font-weight: 700;
        }
        .mentor-input,
        .mentor-form-field textarea,
        .mentor-form-field select {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 20px;
            background: #f8fafc;
            color: #1f2937;
            font-size: 0.95rem;
            transition: border-color 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
        }
        .mentor-form-field textarea {
            min-height: 140px;
            resize: vertical;
        }
        .mentor-input:focus,
        .mentor-form-field textarea:focus,
        .mentor-form-field select:focus {
            outline: none;
            border-color: #6c47ff;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(108,71,255,0.12);
        }
        .mentor-hint {
            font-size: 0.82rem;
            color: #9ca3af;
            margin: -4px 0 0;
        }
        .mentor-form-actions {
            display: flex;
            justify-content: flex-end;
        }
        .mentor-form-actions .mentor-btn {
            padding: 14px 36px;
            font-size: 15px;
            box-shadow: 0 20px 50px rgba(108,71,255,0.35);
        }
        @media (max-width: 768px) {
            .mentor-profile-hero {
                flex-direction: column;
                text-align: center;
            }
            .mentor-profile-meta {
                width: 100%;
            }
            .mentor-form-actions {
                justify-content: stretch;
            }
            .mentor-form-actions .mentor-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('mentor-content')
    <div class="mentor-profile-layout">
        <form action="{{ route('mentor.profile.update') }}" method="POST" enctype="multipart/form-data" class="mentor-profile-form">
            @csrf
            <input type="file" id="avatar-input" name="avatar" accept="image/*" style="display:none;">

            <section class="mentor-profile-hero">
                <div>
                    <p class="mentor-label">Hola, {{ $user->name }}</p>
                    <h1>Tu identidad p&uacute;blica</h1>
                    <p>Sube una imagen cuadrada y actualiza tus datos para que los estudiantes puedan reconocerte f&aacute;cilmente.</p>
                    <div class="mentor-profile-meta">
                        <div>
                            <span class="mentor-meta-label">Rol actual</span>
                            <span class="mentor-meta-value">{{ $currentRole ?: 'Mentor SkillNest' }}</span>
                        </div>
                        <div>
                            <span class="mentor-meta-label">Experiencia</span>
                            <span class="mentor-meta-value">{{ $experienceYears }} a&ntilde;os</span>
                        </div>
                        <div>
                            <span class="mentor-meta-label">Tarifa</span>
                            <span class="mentor-meta-value">S/ {{ $formattedRate }}</span>
                        </div>
                    </div>
                </div>
                <div class="mentor-profile-upload">
                    <img src="{{ $avatar }}" alt="Avatar" class="mentor-avatar-preview">
                    <label for="avatar-input" class="mentor-upload-trigger">
                        Cambiar foto
                        <small>PNG o JPG - 800x800 px</small>
                    </label>
                </div>
            </section>

            <div class="mentor-form-sections">
                <div class="mentor-card soft">
                    <h2>Informaci&oacute;n b&aacute;sica</h2>
                    <div class="mentor-form-grid">
                        <div class="mentor-form-field">
                            <label for="name">Nombre completo</label>
                            <input id="name" class="mentor-input" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="mentor-form-field">
                            <label for="profesion">Profesi&oacute;n</label>
                            <input id="profesion" class="mentor-input" type="text" name="profesion" value="{{ old('profesion', $profile->profesion ?? '') }}" placeholder="Product Designer, Frontend Lead">
                        </div>
                        <div class="mentor-form-field full">
                            <label for="descripcion">Descripci&oacute;n</label>
                            <textarea id="descripcion" name="descripcion" class="mentor-input" rows="4" placeholder="Cu&eacute;ntales a los estudiantes sobre tu experiencia y logros.">{{ old('descripcion', $profile->descripcion ?? '') }}</textarea>
                        </div>
                        <div class="mentor-form-field">
                            <label for="skills">Habilidades</label>
                            <input id="skills" class="mentor-input" type="text" name="skills" value="{{ $skillValue }}" placeholder="React, UX/UI, Data Viz">
                            <p class="mentor-hint">Separa cada habilidad con comas.</p>
                        </div>
                        <div class="mentor-form-field">
                            <label for="categorias">Categor&iacute;as</label>
                            <input id="categorias" class="mentor-input" type="text" name="categorias" value="{{ $categoryValue }}" placeholder="Frontend, UX/UI">
                            <p class="mentor-hint">Usa etiquetas claras como &ldquo;frontend&rdquo;, &ldquo;datos&rdquo; o &ldquo;product design&rdquo;.</p>
                        </div>
                    </div>
                </div>

                <div class="mentor-card soft">
                    <h2>Experiencia y tarifas</h2>
                    <div class="mentor-form-grid">
                        <div class="mentor-form-field">
                            <label for="experiencia_anios">A&ntilde;os de experiencia</label>
                            <input id="experiencia_anios" class="mentor-input" type="number" min="0" name="experiencia_anios" value="{{ $experienceYears }}">
                        </div>
                        <div class="mentor-form-field">
                            <label for="precio_hora">Precio por hora (S/)</label>
                            <input id="precio_hora" class="mentor-input" type="number" step="0.1" min="0" name="precio_hora" value="{{ $hourlyRate }}">
                        </div>
                        <div class="mentor-form-field">
                            <label for="nivel_experiencia">Nivel de experiencia</label>
                            <select id="nivel_experiencia" name="nivel_experiencia" class="mentor-input">
                                <option value="">Selecciona el nivel</option>
                                @foreach($experienceOptions as $value => $label)
                                    <option value="{{ $value }}" @selected(old('nivel_experiencia', $profile->nivel_experiencia ?? '') === $value)>{!! $label !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mentor-form-actions">
                <button class="mentor-btn primary" type="submit">Guardar cambios</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        const avatarInput = document.getElementById('avatar-input');
        const avatarPreview = document.querySelector('.mentor-avatar-preview');

        avatarInput?.addEventListener('change', (event) => {
            const [file] = event.target.files;
            if (file && avatarPreview) {
                avatarPreview.src = URL.createObjectURL(file);
            }
        });
    </script>
@endpush
