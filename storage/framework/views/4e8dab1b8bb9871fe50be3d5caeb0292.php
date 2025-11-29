

<?php $__env->startSection('dashboard-title', 'Editor de curso'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-pIVp98VYqCw42Hcps225y7sY9qsK0kGugHgdGXNq35p3xNmPR9U1FVLtZL1YI7Di5urN6LyjHgNsZM3Rp3crGQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php $__env->stopPush(); ?>


<?php $__env->startSection('dashboard-actions'); ?>
    <div class="editor-actions-bar">
        <div>
            <p class="editor-actions-caption">Acciones rápidas</p>
            <h3 class="editor-actions-title">Gestiona tu publicación</h3>
        </div>
        <div class="editor-actions-buttons">
            <a href="<?php echo e(route('cursos.show', $curso)); ?>" class="btn-secondary">
                <i class="fas fa-eye"></i> Vista Previa
            </a>
            <form action="<?php echo e(route('cursos.send-to-review', $curso)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-paper-plane"></i> Enviar a Revisión
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
    <div id="editor-toast" class="fixed right-6 top-24 z-50 hidden rounded-2xl bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4 font-semibold text-white shadow-2xl">
        <i class="fas fa-check-circle mr-2"></i>Cambios guardados correctamente
    </div>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        :root {
            --color-primary: #6c47ff;
            --color-primary-hover: #5a38e6;
            --shadow-card: 0 10px 40px rgba(0,0,0,0.08);
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #fafafa;
            color: #333;
            line-height: 1.6;
        }
        .editor-actions-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            padding: 20px 28px;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(108,71,255,0.08);
            border: 1px solid rgba(0,0,0,0.05);
        }
        .editor-actions-caption {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: #9ca3af;
            margin: 0 0 4px;
        }
        .editor-actions-title {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 800;
            color: #1f2937;
        }
        .editor-actions-buttons {
            display: inline-flex;
            align-items: center;
            gap: 12px;
        }
        .navbar {
            background: #fff;
            padding: 16px 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 0;
        }
        .navbar-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            font-size: 24px;
            font-weight: 800;
            color: var(--color-primary);
        }
        .nav-links {
            display: flex;
            gap: 24px;
            list-style: none;
        }
        .nav-links a {
            color: #4b5563;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .nav-links a:hover {
            color: var(--color-primary);
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
            color: #fff;
            padding: 12px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(108,71,255,0.4);
        }
        .btn-secondary {
            background: transparent;
            color: var(--color-primary);
            padding: 12px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s ease;
            border: 2px solid var(--color-primary);
        }
        .btn-secondary:hover {
            background: var(--color-primary);
            color: #fff;
        }
        .editor-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 24px;
        }
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }
        .stat-card {
            background: #fff;
            border-radius: 20px;
            padding: 32px;
            box-shadow: var(--shadow-card);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
            border-color: rgba(108,71,255,0.2);
        }
        .stat-card h4 {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: #6b7280;
            font-weight: 800;
            margin-bottom: 16px;
        }
        .stat-card strong {
            font-size: 2.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: block;
            line-height: 1;
        }
        .editor-layout {
            display: grid;
            grid-template-columns: 380px 1fr 320px;
            gap: 32px;
        }
        @media (max-width: 1400px) {
            .editor-layout {
                grid-template-columns: 340px 1fr;
            }
            .editor-layout aside:last-of-type {
                grid-column: span 2;
            }
        }
        @media (max-width: 1024px) {
            .editor-layout {
                grid-template-columns: 1fr;
            }
            .editor-layout aside:last-of-type {
                grid-column: auto;
            }
        }
        .editor-card {
            background: #fff;
            border-radius: 20px;
            padding: 32px;
            box-shadow: var(--shadow-card);
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }
        .editor-card:hover {
            border-color: rgba(108,71,255,0.1);
        }
        .editor-card h3 {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--color-primary);
            font-weight: 800;
            margin-bottom: 24px;
        }
        .form-stack label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        .form-stack input,
        .form-stack textarea,
        .form-stack select {
            width: 100%;
            border-radius: 12px;
            border: 2px solid rgba(0,0,0,0.08);
            padding: 16px 20px;
            font-size: 0.95rem;
            background: #fff;
            transition: all 0.3s ease;
        }
        .form-stack input:focus,
        .form-stack textarea:focus,
        .form-stack select:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 4px rgba(108,71,255,0.1);
            transform: translateY(-2px);
        }
        .image-preview-container {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            border: 2px dashed rgba(108,71,255,0.3);
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            margin-bottom: 16px;
        }
        .image-preview-container img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .image-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            background: rgba(255,255,255,0.95);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--color-primary);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .modules-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(0,0,0,0.06);
        }
        .modules-head h2 {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .module-card {
            background: #fff;
            border-radius: 20px;
            padding: 32px;
            margin-bottom: 24px;
            border: 2px solid rgba(0,0,0,0.06);
            box-shadow: var(--shadow-card);
            transition: all 0.3s ease;
            position: relative;
        }
        .module-card:hover {
            border-color: var(--color-primary);
            box-shadow: 0 20px 40px rgba(108,71,255,0.15);
            transform: translateY(-4px);
        }
        .module-card.sortable-ghost,
        .lesson-block.sortable-ghost { opacity: 0.6; transform: scale(0.98); }
        .module-card.is-dragging,
        .lesson-block.is-dragging { border-color: var(--color-primary); }
        .module-top {
            display: flex;
            gap: 20px;
            margin-bottom: 24px;
        }
        .module-fields {
            flex: 1;
        }
        .module-fields input,
        .module-fields textarea {
            width: 100%;
            border-radius: 12px;
            border: 2px solid rgba(0,0,0,0.08);
            padding: 16px 20px;
            font-size: 0.95rem;
            background: #fff;
            transition: all 0.3s ease;
        }
        .module-fields textarea {
            margin-top: 16px;
            min-height: 80px;
            resize: vertical;
        }
        .module-actions {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }
        .module-actions button {
            border: none;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .module-handle {
            background: rgba(108,71,255,0.1);
            color: var(--color-primary);
            border: 2px solid rgba(108,71,255,0.2);
            cursor: grab;
        }
        .module-add-lesson {
            background: rgba(16,185,129,0.1);
            color: #047857;
            border: 2px solid rgba(16,185,129,0.2);
        }
        .module-delete {
            background: rgba(239,68,68,0.1);
            color: #dc2626;
            border: 2px solid rgba(239,68,68,0.2);
        }
        .lesson-block {
            background: linear-gradient(135deg, #fafbff, #f3f5ff);
            border-radius: 16px;
            padding: 24px;
            margin-top: 16px;
            border: 1px solid rgba(0,0,0,0.06);
            transition: all 0.3s ease;
        }
        .lesson-block:hover {
            border-color: var(--color-primary);
            transform: translateX(4px);
        }
        .lesson-row {
            display: flex;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
        }
        .lesson-row input,
        .lesson-row select {
            flex: 1;
            min-width: 120px;
            border-radius: 12px;
            border: 2px solid transparent;
            padding: 12px 16px;
            background: #fff;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .lesson-row input:focus,
        .lesson-row select:focus {
            border-color: var(--color-primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(108,71,255,0.1);
        }
        .checklist {
            list-style: none;
        }
        .checklist li {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 0;
            border-bottom: 1px solid rgba(0,0,0,0.06);
            font-weight: 500;
            color: #374151;
        }
        .checklist li:last-child {
            border-bottom: none;
        }
        .check-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .check-dot.fill {
            background: linear-gradient(135deg, #10b981, #059669);
            border-color: transparent;
        }
        .check-dot.fill::before {
            content: '\2713';
            color: white;
            font-size: 0.75rem;
            font-weight: bold;
        }
        .progress-bar {
            height: 8px;
            border-radius: 999px;
            background: rgba(0,0,0,0.06);
            overflow: hidden;
            margin-top: 8px;
        }
        .progress-bar span {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, var(--color-primary), #8b5cf6);
            transition: width 0.5s ease;
        }
        .tips-card {
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border-radius: 20px;
            padding: 24px;
            margin-top: 32px;
            border: 1px solid rgba(186,230,253,0.5);
        }
        .empty-state {
            text-align: center;
            padding: 48px 32px;
            color: #6b7280;
        }
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 16px;
            opacity: 0.5;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            border-radius: 999px;
            background: linear-gradient(135deg, rgba(108,71,255,0.1), rgba(139,92,246,0.1));
            border: 1px solid rgba(108,71,255,0.2);
            width: fit-content;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--color-primary);
        }
    </style>
    <?php
        $initialImage = $curso->image_url
            ? (\Illuminate\Support\Str::startsWith($curso->image_url, ['http://', 'https://'])
                ? $curso->image_url
                : asset($curso->image_url))
            : 'https://picsum.photos/seed/' . $curso->id . '/800/600';
        $basicFields = [
            ['name' => 'title', 'label' => 'T?tulo del Curso', 'type' => 'text'],
            ['name' => 'category', 'label' => 'Categor?a', 'type' => 'text'],
            ['name' => 'level', 'label' => 'Nivel', 'type' => 'select', 'options' => ['principiante','intermedio','avanzado']],
            ['name' => 'price', 'label' => 'Precio (S/)', 'type' => 'number', 'step' => '0.01'],
            ['name' => 'duration', 'label' => 'Duraci?n (horas)', 'type' => 'number', 'min' => 1],
            ['name' => 'description', 'label' => 'Descripci?n Corta', 'type' => 'textarea'],
            ['name' => 'objectives', 'label' => 'Objetivos de Aprendizaje', 'type' => 'textarea'],
            ['name' => 'requirements', 'label' => 'Requisitos', 'type' => 'textarea'],
        ];
    ?>
    <div class="editor-wrapper">
        <div class="stats-row">
            <div class="stat-card">
                <h4>Estado del Curso</h4>
                <div class="flex items-center gap-4">
                    <span class="status-badge">
                        <i class="fas fa-pencil-alt"></i> <span class="capitalize" id="course-status"><?php echo e($curso->status); ?></span>
                    </span>
                    <span class="text-sm text-gray-600" id="last-saved-indicator">?ltimo guardado hace instantes</span>
                </div>
            </div>
            <div class="stat-card">
                <h4>M?dulos</h4>
                <strong><?php echo e($modulesCount); ?></strong>
                <p class="text-sm text-gray-600 mt-2">Estructuras creadas</p>
            </div>
            <div class="stat-card">
                <h4>Lecciones</h4>
                <strong><?php echo e($lessonsCount); ?></strong>
                <p class="text-sm text-gray-600 mt-2">Bloques de contenido</p>
            </div>
        </div>

        <div id="course-editor"
             data-course-id="<?php echo e($curso->id); ?>"
             data-basics-endpoint="<?php echo e(route('cursos.update-basics', $curso)); ?>"
             data-order-endpoint="<?php echo e(route('cursos.order', $curso)); ?>"
             data-image-endpoint="<?php echo e(route('cursos.update-image', $curso)); ?>"
             class="editor-layout">
            <aside class="editor-card form-stack">
                <h3>Imagen del Curso</h3>
                <div class="image-preview-container">
                    <img id="course-image-preview" src="<?php echo e($initialImage); ?>" alt="Imagen del curso">
                    <span class="image-badge">Portada</span>
                </div>
                <label>
                    <input type="file" accept="image/*" id="course-image-input" class="w-full cursor-pointer rounded-2xl border border-dashed border-gray-300 px-4 py-3">
                </label>
                <span class="text-xs text-gray-500 mt-2">Formatos: JPG o PNG (m?x 4 MB)</span>

                <div class="mt-8 space-y-6">
                    <?php $__currentLoopData = $basicFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <label><?php echo e($field['label']); ?></label>
                            <?php if($field['type'] === 'select'): ?>
                                <select data-basic-field="<?php echo e($field['name']); ?>">
                                    <?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($option); ?>" <?php if($curso->{$field['name']} === $option): echo 'selected'; endif; ?>><?php echo e(ucfirst($option)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            <?php elseif($field['type'] === 'textarea'): ?>
                                <textarea data-basic-field="<?php echo e($field['name']); ?>" rows="3"><?php echo e($curso->{$field['name']}); ?></textarea>
                            <?php else: ?>
                                <input type="<?php echo e($field['type']); ?>"
                                       step="<?php echo e($field['step'] ?? ''); ?>"
                                       min="<?php echo e($field['min'] ?? ''); ?>"
                                       data-basic-field="<?php echo e($field['name']); ?>"
                                       value="<?php echo e($curso->{$field['name']}); ?>">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </aside>

            <section class="editor-card">
                <div class="modules-head">
                    <div>
                        <p class="text-sm uppercase tracking-wider text-gray-500">Estructura del Curso</p>
                        <h2>Organiza m?dulos y lecciones</h2>
                    </div>
                    <button type="button" id="add-module-btn" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>Agregar M?dulo
                    </button>
                </div>

                <div id="modules-canvas" class="space-y-6">
                    <?php $__currentLoopData = $curso->modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="module-card" data-module-id="<?php echo e($module->id); ?>">
                            <div class="module-top">
                                <div class="module-fields">
                                    <input type="text" class="module-title" value="<?php echo e($module->title); ?>" placeholder="T?tulo del m?dulo">
                                    <textarea class="module-description" placeholder="Descripci?n del m?dulo (opcional)"><?php echo e($module->description); ?></textarea>
                                </div>
                                <div class="module-actions">
                                    <button type="button" class="module-handle" title="Arrastrar m?dulo">
                                        <i class="fas fa-grip-vertical"></i>
                                    </button>
                                    <button type="button" class="module-add-lesson">
                                        <i class="fas fa-plus mr-1"></i>Lecci?n
                                    </button>
                                    <button type="button" class="module-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="lessons-wrapper" data-lessons-container>
                                <?php $__currentLoopData = $module->lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="lesson-block" data-lesson-id="<?php echo e($lesson->id); ?>">
                                        <div class="lesson-row">
                                            <button type="button" class="module-handle lesson-handle" title="Arrastrar lecci?n">
                                                <i class="fas fa-grip-vertical"></i>
                                            </button>
                                            <input type="text" class="lesson-title" value="<?php echo e($lesson->title); ?>" placeholder="T?tulo de la lecci?n">
                                            <select class="lesson-type">
                                                <?php $__currentLoopData = ['video','reading','quiz','live','file']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($type); ?>" <?php if($lesson->type === $type): echo 'selected'; endif; ?>><?php echo e(ucfirst($type)); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <button type="button" class="module-delete lesson-delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="lesson-extra mt-4 space-y-3">
                                            <input type="text" class="lesson-video hidden w-full rounded-xl border border-gray-200 p-3"
                                                   placeholder="URL del video" value="<?php echo e($lesson->video_url); ?>">
                                            <input type="text" class="lesson-resource hidden w-full rounded-xl border border-gray-200 p-3"
                                                   placeholder="URL del recurso" value="<?php echo e($lesson->resource_url); ?>">
                                            <div class="lesson-editor hidden rounded-xl border border-gray-200 p-3 text-sm" contenteditable="true"><?php echo nl2br(e($lesson->content)); ?></div>
                                            <textarea class="lesson-content hidden w-full rounded-xl border border-gray-200 p-3" rows="3" placeholder="Contenido"><?php echo e($lesson->content); ?></textarea>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($curso->modules->isEmpty()): ?>
                        <div class="empty-state">
                            <i class="fas fa-book-open"></i>
                            <h3 class="text-xl font-semibold text-gray-600 mb-2">No hay m?dulos todav?a</h3>
                            <p class="text-gray-500 mb-6">Agrega tu primera estructura para empezar</p>
                            <button type="button" class="btn-primary" id="add-first-module">
                                <i class="fas fa-plus mr-2"></i>Agregar primer m?dulo
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <aside class="editor-card space-y-8">
                <div>
                    <h3>Checklist de Completado</h3>
                    <ul class="checklist mt-6" id="checklist">
                        <li>
                            <span class="check-dot" data-check="basics"></span>
                            <span>Informaci?n b?sica completa</span>
                        </li>
                        <li>
                            <span class="check-dot" data-check="modules"></span>
                            <span>Al menos un m?dulo</span>
                        </li>
                        <li>
                            <span class="check-dot" data-check="lessons"></span>
                            <span>M?dulos con lecciones</span>
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
                    <h4 class="font-bold text-blue-900 mb-4">?? Consejos R?pidos</h4>
                    <ul class="space-y-3 text-sm text-blue-800">
                        <li class="flex items-start gap-3">
                            <span class="mt-1 h-2 w-2 rounded-full bg-blue-500 flex-shrink-0"></span>
                            <span>Guarda contenido clave en objetivos para que el panel admin lo lea</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 h-2 w-2 rounded-full bg-amber-500 flex-shrink-0"></span>
                            <span>Usa quizzes para bloquear el siguiente m?dulo y asegurar el aprendizaje</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 h-2 w-2 rounded-full bg-emerald-500 flex-shrink-0"></span>
                            <span>Adjunta recursos en formato file para materiales descargables bonus</span>
                        </li>
                    </ul>
                </div>

                <div class="space-y-6">
                    <h3>Progreso del Curso</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-sm font-semibold text-gray-600">
                                <span>Borrador</span>
                                <span><?php echo e($modulesCount ? 'Completado' : 'Pendiente'); ?></span>
                            </div>
                            <div class="progress-bar">
                                <span style="width: <?php echo e($modulesCount ? '70%' : '30%'); ?>"></span>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm font-semibold text-gray-600">
                                <span>Revisi?n</span>
                                <span><?php echo e($curso->status === 'pendiente' ? 'Enviado' : 'Por enviar'); ?></span>
                            </div>
                            <div class="progress-bar">
                                <span style="width: <?php echo e($curso->status === 'pendiente' ? '80%' : '35%'); ?>"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
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
                    fetchJson(`<?php echo e(url('/modules')); ?>/${moduleId}`, { method: 'DELETE' })
                        .then(() => {
                            card.remove();
                            sendReorder();
                            refreshChecklist();
                            showToast('Módulo eliminado');
                        })
                        .catch(err => {
                            console.error(err);
                            showToast('No se pudo eliminar', 'error');
                        });
                });

                addLessonBtn.addEventListener('click', () => {
                    const title = prompt('Título de la lección', 'Nueva lección');
                    if (!title) return;
                    fetchJson(`<?php echo e(url('/modules')); ?>/${moduleId}/lessons`, {
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

            const buildLessonBlock = (lesson) => {
                const template = document.createElement('div');
                template.className = 'lesson-block rounded-2xl border border-slate-100 bg-slate-50 px-4 py-3';
                template.dataset.lessonId = lesson.id;
                template.innerHTML = `
                    <div class="lesson-row">
                        <button type="button" class="module-handle lesson-handle" title="Arrastrar lección">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 9h4m-4 6h4M5 9h.01M5 15h.01M18.99 9H19m-.01 6H19"/>
                            </svg>
                        </button>
                        <input type="text" class="lesson-title" value="${lesson.title}">
                        <select class="lesson-type">
                            ${['video','reading','quiz','live','file'].map(type => `<option value="${type}" ${lesson.type === type ? 'selected' : ''}>${type.charAt(0).toUpperCase() + type.slice(1)}</option>`).join('')}
                        </select>
                        <button type="button" class="module-delete lesson-delete">Eliminar</button>
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
                    fetchJson(`<?php echo e(url('/lessons')); ?>/${lessonId}`, { method: 'DELETE' })
                        .then(() => {
                            block.remove();
                            sendReorder();
                            refreshChecklist();
                            showToast('Lección eliminada');
                        }).catch(console.error);
                });
            };

            const addModuleBtn = document.getElementById('add-module-btn');
            const addFirstModuleBtn = document.getElementById('add-first-module');

            const handleCreateModule = () => {
                const title = prompt('Nombre del módulo', 'Nuevo módulo');
                if (!title) return;
                fetchJson(`<?php echo e(url('/cursos')); ?>/${courseId}/modules`, {
                    method: 'POST',
                    body: JSON.stringify({ title })
                }).then(({ module }) => {
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = `
                        <div class="module-card" data-module-id="${module.id}">
                            <div class="module-top">
                                <div class="module-fields">
                                    <input type="text" class="module-title" value="${module.title}">
                                    <textarea class="module-description" placeholder="Descripción del módulo (opcional)"></textarea>
                                </div>
                                <div class="module-actions">
                                    <button type="button" class="module-handle" title="Arrastrar módulo">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 9h14M5 15h14"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="module-add-lesson">+ Lección</button>
                                    <button type="button" class="module-delete">Eliminar</button>
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
            addFirstModuleBtn?.addEventListener('click', handleCreateModule);

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
        })();
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/cursos/editor.blade.php ENDPATH**/ ?>