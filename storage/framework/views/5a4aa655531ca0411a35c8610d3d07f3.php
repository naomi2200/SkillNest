<?php $__env->startSection('dashboard-title', 'Editor de curso'); ?>

<?php $__env->startSection('dashboard-actions'); ?>
    <div class="flex w-full flex-wrap items-center gap-4 rounded-[32px] border border-slate-100 bg-white/80 px-5 py-4 shadow-card">
        <div class="flex flex-1 flex-wrap items-center gap-3">
            <div class="flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">
                Estado
                <span class="rounded-full bg-secondary/10 px-3 py-0.5 text-secondary capitalize" id="course-status"><?php echo e($curso->status); ?></span>
            </div>
            <span class="text-xs text-slate-400" id="last-saved-indicator">Ultimo guardado hace instantes</span>
            <span class="hidden text-xs text-slate-400 md:inline">El editor guarda todo en segundo plano</span>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="<?php echo e(route('cursos.show', $curso)); ?>" class="btn-secondary rounded-full border border-slate-200 px-5 py-2 text-sm font-semibold">Vista previa</a>
            <form action="<?php echo e(route('cursos.send-to-review', $curso)); ?>" method="POST" class="flex">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-primary rounded-full px-6 py-2 text-sm font-semibold shadow-lg shadow-primary/30">
                    Enviar a revision
                </button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php
    $modulesCount = $curso->modules->count();
    $lessonsCount = $curso->modules->sum(fn($module) => $module->lessons->count());
?>

<?php $__env->startSection('dashboard-content'); ?>
    <div id="editor-toast" class="pointer-events-none fixed right-6 top-24 hidden rounded-2xl bg-secondary px-4 py-2 text-sm font-semibold text-white shadow-card"></div>
    <style>
        .module-card.sortable-ghost,
        .lesson-block.sortable-ghost {
            opacity: 0.55;
            transform: scale(0.98);
        }
        .module-card.is-dragging,
        .lesson-block.is-dragging {
            border-color: #6366f1;
            box-shadow: 0 25px 35px rgba(79, 70, 229, 0.18);
        }
        .module-handle,
        .lesson-handle {
            cursor: grab;
        }
        .module-handle:active,
        .lesson-handle:active {
            cursor: grabbing;
        }
    </style>

    <div class="mb-6 grid gap-4 lg:grid-cols-3">
        <div class="rounded-[28px] border border-slate-100 bg-gradient-to-r from-indigo-500 via-sky-500 to-cyan-400 p-[1px] text-white shadow-2xl">
            <div class="rounded-[26px] bg-white/10 px-6 py-5 backdrop-blur">
                <p class="text-xs uppercase tracking-[0.4em] text-white/70">Modo visual</p>
                <h3 class="mt-2 text-2xl font-semibold">Construye como en Canva</h3>
                <p class="mt-1 text-sm text-white/80">Arrastra modulos, agrega bloques y mantente inspirado con un lienzo limpio.</p>
            </div>
        </div>
        <div class="rounded-[28px] border border-slate-100 bg-white/90 px-6 py-5 shadow-card">
            <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Modulos</p>
            <div class="mt-2 flex items-center gap-3">
                <p class="text-3xl font-bold text-secondary"><?php echo e($modulesCount); ?></p>
                <p class="text-sm text-slate-500">estructuras creadas</p>
            </div>
            <p class="text-xs text-slate-400">Objetivo recomendado: minimo 3 modulos por curso.</p>
        </div>
        <div class="rounded-[28px] border border-slate-100 bg-white/90 px-6 py-5 shadow-card">
            <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Lecciones</p>
            <div class="mt-2 flex items-center gap-3">
                <p class="text-3xl font-bold text-secondary"><?php echo e($lessonsCount); ?></p>
                <p class="text-sm text-slate-500">bloques interactivos</p>
            </div>
            <p class="text-xs text-slate-400">Combina video, lectura, archivos y retos.</p>
        </div>
    </div>

    <div id="course-editor"
         data-course-id="<?php echo e($curso->id); ?>"
         data-basics-endpoint="<?php echo e(route('cursos.update-basics', $curso)); ?>"
         data-order-endpoint="<?php echo e(route('cursos.order', $curso)); ?>"
         data-image-endpoint="<?php echo e(route('cursos.update-image', $curso)); ?>"
         class="grid gap-6 xl:grid-cols-[360px,1fr,300px]">

        <?php
            $initialImage = $curso->image_url
                ? (\Illuminate\Support\Str::startsWith($curso->image_url, ['http://', 'https://'])
                    ? $curso->image_url
                    : asset($curso->image_url))
                : 'https://picsum.photos/seed/' . $curso->id . '/800/600';
        ?>

        <aside class="space-y-5 rounded-[32px] border border-slate-200 bg-white/95 p-6 shadow-card">
            <div class="space-y-3">
                <h2 class="text-sm font-semibold uppercase tracking-[0.4em] text-secondary">Imagen del curso</h2>
                <div class="relative overflow-hidden rounded-[28px] border border-slate-100 bg-slate-50">
                    <img id="course-image-preview" src="<?php echo e($initialImage); ?>" alt="Imagen del curso" class="h-48 w-full object-cover">
                    <span class="absolute right-4 top-4 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-secondary shadow">Portada</span>
                </div>
                <label class="block">
                    <span class="text-xs font-semibold text-secondary">Actualizar imagen</span>
                    <input type="file" accept="image/*" id="course-image-input" class="mt-2 w-full cursor-pointer rounded-2xl border border-dashed border-slate-300 px-3 py-2 text-sm">
                </label>
                <p class="text-xs text-slate-400">Formatos permitidos: JPG o PNG (max 4 MB).</p>
            </div>

            <div class="rounded-[28px] border border-slate-100 bg-slate-50/70 px-4 py-3">
                <h2 class="text-sm font-semibold uppercase tracking-[0.4em] text-secondary">Informacion basica</h2>
            </div>
            <div class="space-y-4 text-sm text-slate-600">
                <?php
                    $basicFields = [
                        ['name' => 'title', 'label' => 'Titulo', 'type' => 'text'],
                        ['name' => 'category', 'label' => 'Categoria', 'type' => 'text'],
                        ['name' => 'level', 'label' => 'Nivel', 'type' => 'select', 'options' => ['principiante','intermedio','avanzado']],
                        ['name' => 'price', 'label' => 'Precio', 'type' => 'number', 'step' => '0.01'],
                        ['name' => 'duration', 'label' => 'Duracion (horas)', 'type' => 'number', 'min' => 1],
                        ['name' => 'description', 'label' => 'Descripcion corta', 'type' => 'textarea'],
                        ['name' => 'objectives', 'label' => 'Objetivos', 'type' => 'textarea'],
                        ['name' => 'requirements', 'label' => 'Requisitos', 'type' => 'textarea'],
                    ];
                ?>

                <?php $__currentLoopData = $basicFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="block text-xs font-semibold text-secondary">
                        <?php echo e($field['label']); ?>

                        <?php if($field['type'] === 'select'): ?>
                            <select data-basic-field="<?php echo e($field['name']); ?>" class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm">
                                <?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($option); ?>" <?php if($curso->{$field['name']} === $option): echo 'selected'; endif; ?>><?php echo e(ucfirst($option)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        <?php elseif($field['type'] === 'textarea'): ?>
                            <textarea data-basic-field="<?php echo e($field['name']); ?>" class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" rows="3"><?php echo e($curso->{$field['name']}); ?></textarea>
                        <?php else: ?>
                            <input type="<?php echo e($field['type']); ?>"
                                   step="<?php echo e($field['step'] ?? ''); ?>"
                                   min="<?php echo e($field['min'] ?? ''); ?>"
                                   data-basic-field="<?php echo e($field['name']); ?>"
                                   value="<?php echo e($curso->{$field['name']}); ?>"
                                   class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm">
                        <?php endif; ?>
                    </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </aside>

        <section class="space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-3 rounded-[32px] border border-slate-200 bg-white px-6 py-4 shadow-card">
                <div>
                    <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Modulos</p>
                    <h2 class="text-xl font-semibold text-secondary">Estructura visual del curso</h2>
                </div>
                <button type="button" id="add-module-btn" class="btn-primary rounded-full bg-secondary px-5 py-2 text-sm font-semibold text-white shadow-lg shadow-secondary/20">
                    Agregar modulo
                </button>
            </div>

            <div id="modules-canvas" class="space-y-4">
                <?php $__currentLoopData = $curso->modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="module-card rounded-[32px] border border-slate-200 bg-white px-5 py-6 shadow-card" data-module-id="<?php echo e($module->id); ?>">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 space-y-3">
                                <input type="text" class="module-title w-full rounded-2xl border border-slate-200 px-3 py-2 text-lg font-semibold text-secondary" value="<?php echo e($module->title); ?>">
                                <textarea class="module-description w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" rows="2" placeholder="Descripcion del modulo (opcional)"><?php echo e($module->description); ?></textarea>
                            </div>
                            <div class="flex flex-col gap-2">
                                <button type="button" class="module-handle rounded-2xl border border-slate-200 p-2 text-slate-400 hover:border-primary hover:text-primary" title="Arrastrar modulo">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 9h14M5 15h14"/>
                                    </svg>
                                </button>
                                <button type="button" class="module-add-lesson text-xs font-semibold text-primary">Agregar leccion</button>
                                <button type="button" class="module-delete text-xs font-semibold text-rose-500">Eliminar</button>
                            </div>
                        </div>

                        <div class="lessons-wrapper mt-4 space-y-3" data-lessons-container>
                            <?php $__currentLoopData = $module->lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="lesson-block rounded-2xl border border-slate-100 bg-slate-50 px-4 py-4" data-lesson-id="<?php echo e($lesson->id); ?>">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <button type="button" class="lesson-handle rounded-2xl border border-transparent bg-white p-2 text-slate-400 hover:border-primary hover:text-primary" title="Arrastrar leccion">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 9h4m-4 6h4M5 9h.01M5 15h.01M18.99 9H19m-.01 6H19"/>
                                            </svg>
                                        </button>
                                        <input type="text" class="lesson-title flex-1 rounded-2xl border border-transparent bg-white px-3 py-2 text-sm font-semibold text-secondary" value="<?php echo e($lesson->title); ?>">
                                        <select class="lesson-type rounded-2xl border border-slate-200 px-3 py-1 text-xs font-semibold uppercase text-slate-500">
                                            <?php $__currentLoopData = ['video','reading','quiz','live','file']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($type); ?>" <?php if($lesson->type === $type): echo 'selected'; endif; ?>><?php echo e(ucfirst($type)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <button class="lesson-delete text-xs font-semibold text-rose-500" type="button">Eliminar</button>
                                    </div>
                                    <div class="lesson-extra mt-3 space-y-2 text-sm text-slate-600">
                                        <input type="text" class="lesson-video hidden w-full rounded-2xl border border-slate-200 px-3 py-2" placeholder="URL del video" value="<?php echo e($lesson->video_url); ?>">
                                        <input type="text" class="lesson-resource hidden w-full rounded-2xl border border-slate-200 px-3 py-2" placeholder="URL del recurso" value="<?php echo e($lesson->resource_url); ?>">
                                        <div class="lesson-editor hidden rounded-2xl border border-slate-200 px-3 py-2 text-sm" contenteditable="true"><?php echo nl2br(e($lesson->content)); ?></div>
                                        <textarea class="lesson-content hidden w-full rounded-2xl border border-slate-200 px-3 py-2" rows="3" placeholder="Contenido"><?php echo e($lesson->content); ?></textarea>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($curso->modules->isEmpty()): ?>
                    <p class="rounded-[32px] border border-dashed border-slate-200 bg-white/70 px-4 py-6 text-center text-sm text-slate-400">
                        Todavia no has agregado modulos. Usa el boton "Agregar modulo" para iniciar.
                    </p>
                <?php endif; ?>
            </div>
        </section>

        <aside class="space-y-5 rounded-[32px] border border-slate-200 bg-white/95 p-6 shadow-card">
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-[0.4em] text-secondary">Checklist</h3>
                <ul class="mt-3 space-y-3 text-sm text-slate-600" id="checklist">
                    <li class="flex items-center gap-2"><span class="check-dot" data-check="basics"></span>Informacion basica completa</li>
                    <li class="flex items-center gap-2"><span class="check-dot" data-check="modules"></span>Al menos un modulo</li>
                    <li class="flex items-center gap-2"><span class="check-dot" data-check="lessons"></span>Modulos con lecciones</li>
                    <li class="flex items-center gap-2"><span class="check-dot" data-check="objectives"></span>Objetivos definidos</li>
                    <li class="flex items-center gap-2"><span class="check-dot" data-check="requirements"></span>Requisitos definidos</li>
                </ul>
            </div>

            <div class="rounded-[28px] border border-slate-100 bg-slate-50/80 px-4 py-3">
                <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Notas rapidas</p>
                <ul class="mt-3 space-y-2 text-sm text-slate-600">
                    <li class="flex items-start gap-2">
                        <span class="mt-1 h-2 w-2 rounded-full bg-primary"></span>
                        Guarda contenido clave en objetivos para que el panel admin lo lea.
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1 h-2 w-2 rounded-full bg-amber-500"></span>
                        Usa quizzes para bloquear el siguiente modulo.
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span>
                        Adjunta recursos en formato file para bonus descargables.
                    </li>
                </ul>
            </div>

            <div class="space-y-3">
                <h4 class="text-xs uppercase tracking-[0.4em] text-secondary">Linea de progreso</h4>
                <div class="space-y-2 text-xs text-slate-500">
                    <div class="flex items-center justify-between">
                        <span>Borrador</span>
                        <span><?php echo e($modulesCount > 0 ? 'Completado' : 'Pendiente'); ?></span>
                    </div>
                    <div class="h-2 rounded-full bg-slate-100">
                        <div class="h-2 rounded-full bg-emerald-400" style="width: <?php echo e($modulesCount ? '70%' : '30%'); ?>"></div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Revision</span>
                        <span><?php echo e($curso->status === 'pendiente' ? 'Enviado' : 'Por enviar'); ?></span>
                    </div>
                    <div class="h-2 rounded-full bg-slate-100">
                        <div class="h-2 rounded-full bg-amber-400" style="width: <?php echo e($curso->status === 'pendiente' ? '80%' : '35%'); ?>"></div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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

            const toast = document.getElementById('editor-toast');
            let toastTimer = null;
            const showToast = (message, variant = 'success') => {
                if (!toast) return;
                toast.textContent = message;
                toast.classList.remove('hidden', 'bg-rose-500', 'bg-secondary');
                toast.classList.add(variant === 'error' ? 'bg-rose-500' : 'bg-secondary');
                if (toastTimer) clearTimeout(toastTimer);
                toastTimer = setTimeout(() => toast?.classList.add('hidden'), 2500);
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
                lastSavedIndicator.textContent = 'Ultimo guardado: ' + new Date().toLocaleTimeString();
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
                    showToast('Informacion basica guardada');
                    refreshChecklist();
                }).catch(err => {
                    console.error(err);
                    showToast('Error guardando datos basicos', 'error');
                });
            });
            basics.forEach(el => el.addEventListener('input', handleBasicSave));

            if (imageInput && imageEndpoint) {
                imageInput.addEventListener('change', () => {
                    if (!imageInput.files.length) return;
                    const [file] = imageInput.files;
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
                    });
                });
            }

            const registerModuleCard = (card) => {
                const moduleId = card.dataset.moduleId;
                const titleInput = card.querySelector('.module-title');
                const descInput = card.querySelector('.module-description');
                const deleteBtn = card.querySelector('.module-delete');
                const addLessonBtn = card.querySelector('.module-add-lesson');
                const lessonsContainer = card.querySelector('[data-lessons-container]');

                const saveModule = debounce(() => {
                    fetchJson(`<?php echo e(url('/modules')); ?>/${moduleId}`, {
                        method: 'PUT',
                        body: JSON.stringify({
                            title: titleInput.value,
                            description: descInput.value
                        })
                    }).then(() => {
                        updateLastSaved();
                        showToast('Modulo actualizado');
                    }).catch(err => {
                        console.error(err);
                        showToast('Error al actualizar modulo', 'error');
                    });
                });

                titleInput.addEventListener('input', saveModule);
                descInput.addEventListener('input', saveModule);

                deleteBtn.addEventListener('click', () => {
                    if (!confirm('Eliminar modulo completo?')) return;
                    fetchJson(`<?php echo e(url('/modules')); ?>/${moduleId}`, { method: 'DELETE' })
                        .then(() => {
                            card.remove();
                            sendReorder();
                            refreshChecklist();
                            showToast('Modulo eliminado');
                        })
                        .catch(err => {
                            console.error(err);
                            showToast('No se pudo eliminar', 'error');
                        });
                });

                addLessonBtn.addEventListener('click', () => {
                    const title = prompt('Titulo de la leccion', 'Nueva leccion');
                    if (!title) return;
                    fetchJson(`<?php echo e(url('/modules')); ?>/${moduleId}/lessons`, {
                        method: 'POST',
                        body: JSON.stringify({ title, type: 'video' })
                    }).then(({ lesson }) => {
                        const lessonBlock = buildLessonBlock(lesson);
                        lessonsContainer.appendChild(lessonBlock);
                        registerLessonBlock(lessonBlock);
                        refreshChecklist();
                        showToast('Leccion creada');
                    }).catch(err => {
                        console.error(err);
                        showToast('Error creando leccion', 'error');
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

            const buildLessonBlock = (lesson) => {
                const template = document.createElement('div');
                template.className = 'lesson-block rounded-2xl border border-slate-100 bg-slate-50 px-4 py-3';
                template.dataset.lessonId = lesson.id;
                template.innerHTML = `
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" class="lesson-handle rounded-2xl border border-transparent bg-white p-2 text-slate-400 hover:border-primary hover:text-primary" title="Arrastrar leccion">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 9h4m-4 6h4M5 9h.01M5 15h.01M18.99 9H19m-.01 6H19"/>
                            </svg>
                        </button>
                        <input type="text" class="lesson-title flex-1 rounded-2xl border border-transparent bg-white px-3 py-2 text-sm font-semibold text-secondary" value="${lesson.title}">
                        <select class="lesson-type rounded-2xl border border-slate-200 px-3 py-1 text-xs font-semibold uppercase text-slate-500">
                            ${['video','reading','quiz','live','file'].map(type => `<option value="${type}" ${lesson.type === type ? 'selected' : ''}>${type.charAt(0).toUpperCase() + type.slice(1)}</option>`).join('')}
                        </select>
                        <button type="button" class="lesson-delete text-xs font-semibold text-rose-500">Eliminar</button>
                    </div>
                    <div class="lesson-extra mt-3 space-y-2 text-sm text-slate-600">
                        <input type="text" class="lesson-video hidden w-full rounded-2xl border border-slate-200 px-3 py-2" placeholder="URL del video" value="${lesson.video_url ?? ''}">
                        <input type="text" class="lesson-resource hidden w-full rounded-2xl border border-slate-200 px-3 py-2" placeholder="URL del recurso" value="${lesson.resource_url ?? ''}">
                        <div class="lesson-editor hidden rounded-2xl border border-slate-200 px-3 py-2 text-sm" contenteditable="true">${lesson.content ?? ''}</div>
                        <textarea class="lesson-content hidden w-full rounded-2xl border border-slate-200 px-3 py-2" rows="3">${lesson.content ?? ''}</textarea>
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
                    fetchJson(`<?php echo e(url('/lessons')); ?>/${lessonId}`, {
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
                        showToast('Leccion actualizada');
                    }).catch(err => {
                        console.error(err);
                        showToast('No se pudo guardar la leccion', 'error');
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
                    if (!confirm('Eliminar esta leccion?')) return;
                    fetchJson(`<?php echo e(url('/lessons')); ?>/${lessonId}`, { method: 'DELETE' })
                        .then(() => {
                            block.remove();
                            sendReorder();
                            refreshChecklist();
                            showToast('Leccion eliminada');
                        }).catch(console.error);
                });
            };

            document.getElementById('add-module-btn').addEventListener('click', () => {
                const title = prompt('Nombre del modulo', 'Nuevo modulo');
                if (!title) return;
                fetchJson(`<?php echo e(url('/cursos')); ?>/${courseId}/modules`, {
                    method: 'POST',
                    body: JSON.stringify({ title })
                }).then(({ module }) => {
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = `
                        <div class="module-card rounded-[32px] border border-slate-200 bg-white px-5 py-6 shadow-card" data-module-id="${module.id}">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 space-y-3">
                                    <input type="text" class="module-title w-full rounded-2xl border border-slate-200 px-3 py-2 text-lg font-semibold text-secondary" value="${module.title}">
                                    <textarea class="module-description w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" rows="2" placeholder="Descripcion del modulo (opcional)"></textarea>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <button type="button" class="module-handle rounded-2xl border border-slate-200 p-2 text-slate-400 hover:border-primary hover:text-primary" title="Arrastrar modulo">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 9h14M5 15h14"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="module-add-lesson text-xs font-semibold text-primary">Agregar leccion</button>
                                    <button type="button" class="module-delete text-xs font-semibold text-rose-500">Eliminar</button>
                                </div>
                            </div>
                            <div class="lessons-wrapper mt-4 space-y-3" data-lessons-container></div>
                        </div>
                    `;
                    const card = wrapper.firstElementChild;
                    modulesCanvas.appendChild(card);
                    registerModuleCard(card);
                    sendReorder();
                    refreshChecklist();
                    showToast('Modulo creado');
                }).catch(err => {
                    console.error(err);
                    showToast('Error creando modulo', 'error');
                });
            });

            new Sortable(modulesCanvas, {
                handle: '.module-handle',
                animation: 200,
                onStart: evt => evt.item.classList.add('is-dragging'),
                onEnd: evt => {
                    evt.item.classList.remove('is-dragging');
                    sendReorder();
                }
            });

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

            modulesCanvas.querySelectorAll('.module-card').forEach(registerModuleCard);

            const refreshChecklist = () => {
                const hasBasics = basics[0].value.trim().length > 3;
                const modulesCount = modulesCanvas.querySelectorAll('.module-card').length;
                const lessonsCount = modulesCanvas.querySelectorAll('.lesson-block').length;
                const objectives = editor.querySelector('[data-basic-field="objectives"]').value.trim().length > 0;
                const requirements = editor.querySelector('[data-basic-field="requirements"]').value.trim().length > 0;

                const updateDot = (key, filled) => {
                    const dot = document.querySelector(`.check-dot[data-check="${key}"]`);
                    if (!dot) return;
                    dot.className = `check-dot h-3 w-3 rounded-full border ${filled ? 'border-emerald-400 bg-emerald-400' : 'border-slate-300'}`;
                };

                updateDot('basics', hasBasics);
                updateDot('modules', modulesCount > 0);
                updateDot('lessons', modulesCount > 0 && lessonsCount >= modulesCount);
                updateDot('objectives', objectives);
                updateDot('requirements', requirements);
            };

            refreshChecklist();
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/cursos/editor.blade.php ENDPATH**/ ?>