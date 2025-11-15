@extends('layouts.mentor')

@section('mentor-title', isset($course) ? 'Editar curso' : 'Crear curso')
@section('mentor-subtitle', 'Construye tu curso al estilo Lovable')

@section('mentor-actions')
    <a href="{{ route('mentor.courses') }}" class="btn-secondary rounded-full px-6">Mis cursos</a>
@endsection

@section('mentor-content')
    <div class="mx-auto max-w-6xl space-y-8">

        <div class="rounded-[32px] border border-slate-100 bg-white shadow-card">
            <form action="{{ isset($course) ? route('mentor.courses.update', $course) : route('mentor.courses.store') }}" method="POST" class="space-y-6 p-6">
                @csrf
                @if(isset($course))
                    @method('PUT')
                @endif

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-secondary">Título del curso</label>
                        <input type="text" name="title" value="{{ old('title', $course->title ?? '') }}" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3" required>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-secondary">Categoría</label>
                        <input type="text" name="category" value="{{ old('category', $course->category ?? '') }}" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3" required>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-secondary">Descripción</label>
                    <textarea name="description" rows="4" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3" required>{{ old('description', $course->description ?? '') }}</textarea>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="text-sm font-semibold text-secondary">Precio (S/)</label>
                        <input type="number" name="price" value="{{ old('price', $course->price ?? 0) }}" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3" step="0.1" required>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-secondary">Duración (horas)</label>
                        <input type="number" name="duration" value="{{ old('duration', $course->duration ?? 10) }}" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3" required>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-secondary">Nivel</label>
                        <select name="level" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3">
                            @foreach(['principiante', 'intermedio', 'avanzado'] as $level)
                                <option value="{{ $level }}" @selected(old('level', $course->level ?? 'principiante') === $level)>{{ ucfirst($level) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button class="btn-primary rounded-full px-8">{{ isset($course) ? 'Actualizar curso' : 'Crear curso' }}</button>
                </div>
            </form>

            @isset($course)
                <hr class="border-slate-100">
                <section class="space-y-6 p-6" x-data="builder({{ $course->id }})">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-secondary">Estructura del curso</h2>
                        <button class="btn-gradient rounded-full px-5" @click="saveStructure">Guardar estructura</button>
                    </div>

                    <template x-for="(module, mIndex) in modules" :key="module.local_id">
                        <div class="rounded-2xl border border-slate-100 p-4">
                            <div class="flex items-center justify-between">
                                <input x-model="module.title" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-lg font-semibold text-secondary" placeholder="Título del módulo">
                                <button class="text-sm text-danger" @click="removeModule(mIndex)">Eliminar</button>
                            </div>
                            <textarea x-model="module.description" class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" placeholder="Descripción"></textarea>

                            <div class="mt-4 space-y-3">
                                <template x-for="(lesson, lIndex) in module.lessons" :key="lesson.local_id">
                                    <div class="flex items-center gap-3 rounded-xl border border-slate-200 px-3 py-2">
                                        <input x-model="lesson.title" class="flex-1 border-0 text-sm" placeholder="Lección">
                                        <select x-model="lesson.type" class="rounded-full border border-slate-200 px-3 py-1 text-xs">
                                            <option value="video">Video</option>
                                            <option value="reading">Lectura</option>
                                            <option value="quiz">Quiz</option>
                                        </select>
                                        <button class="text-xs text-danger" @click="removeLesson(mIndex, lIndex)">✕</button>
                                    </div>
                                </template>
                                <button class="btn-secondary rounded-full px-4 text-xs" @click="addLesson(mIndex)">+ Lección</button>
                            </div>
                        </div>
                    </template>

                    <button class="btn-secondary rounded-full px-6" @click="addModule">+ Agregar módulo</button>

                    <div class="pt-4">
                        <form action="{{ route('mentor.courses.submit', $course) }}" method="POST">
                            @csrf
                            <button class="btn-primary rounded-full px-8">Enviar a revisión</button>
                        </form>
                    </div>
                </section>
            @endisset
        </div>
    </div>

    @isset($course)
        <script>
            function builder(courseId) {
                return {
                    modules: @json($builderModules ?? []),
                    addModule() {
                        this.modules.push({
                            local_id: crypto.randomUUID(),
                            title: 'Nuevo módulo',
                            description: '',
                            requires_quiz: true,
                            position: this.modules.length + 1,
                            lessons: [],
                        });
                    },
                    removeModule(index) {
                        this.modules.splice(index, 1);
                    },
                    addLesson(moduleIndex) {
                        this.modules[moduleIndex].lessons.push({
                            local_id: crypto.randomUUID(),
                            title: 'Nueva lección',
                            type: 'video',
                            duration_minutes: 10,
                            position: this.modules[moduleIndex].lessons.length + 1,
                        });
                    },
                    removeLesson(moduleIndex, lessonIndex) {
                        this.modules[moduleIndex].lessons.splice(lessonIndex, 1);
                    },
                    async saveStructure() {
                        await fetch(`{{ route('mentor.courses.structure', $course ?? 0) }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ modules: this.modules })
                        });
                        alert('Estructura guardada');
                    }
                }
            }
        </script>
    @endisset
@endsection
