

<?php $__env->startSection('dashboard-title', 'Editor de Curso | SkillNest'); ?>

<?php
    // Definir las variables que faltan
    $initialImage = $curso->image_url ?? 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80';
    
    $categories = ['Tecnología', 'Negocios', 'Diseño', 'Marketing', 'Desarrollo Personal', 'Salud', 'Finanzas', 'Educación'];
    $levels = ['principiante', 'intermedio', 'avanzado'];
    
    $courseDetail = [
        'title' => $curso->title ?? 'Curso sin título',
        'category' => $curso->category ?? 'General',
        'level' => $curso->level ?? 'principiante',
        'price' => $curso->price ?? 0,
        'duration' => $curso->duration ?? 1,
        'description' => $curso->description ?? '',
        'objectives' => $curso->objectives ?? '',
        'requirements' => $curso->requirements ?? '',
    ];
?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --color-primary: #7c3aed;
        --color-primary-light: #8b5cf6;
        --color-dark: #1e293b;
        --color-light: #f8fafc;
        --color-gray: #64748b;
        --color-success: #10b981;
        --color-warning: #f59e0b;
        --color-danger: #ef4444;
    }

    /* Layout Principal SIN Sidebar */
    .editor-container {
        min-height: calc(100vh - 80px);
        background: linear-gradient(135deg, #f5f3ff 0%, #f0e9ff 100%);
        padding: 20px;
    }

    .editor-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(124, 58, 237, 0.1);
        overflow: hidden;
    }

    /* Header del Editor */
    .editor-header {
        padding: 30px 40px;
        background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light));
        color: white;
        position: relative;
    }

    .editor-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, rgba(255,255,255,0.3), rgba(255,255,255,0.1));
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .header-left h1 {
        font-size: 32px;
        font-weight: 800;
        margin: 0 0 8px 0;
        color: white;
    }

    .header-left p {
        margin: 0;
        font-size: 15px;
        opacity: 0.9;
        color: white;
    }

    .course-status {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 10px;
    }

    .status-badge {
        background: rgba(255, 255, 255, 0.2);
        padding: 8px 20px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }

    .last-saved {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        opacity: 0.9;
    }

    /* Contenido Principal */
    .editor-content {
        padding: 40px;
    }

    /* Grid de Contenido (2 columnas) */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        margin-bottom: 40px;
    }

    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Tarjetas de Contenido */
    .content-card {
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(124, 58, 237, 0.1);
        box-shadow: 0 10px 40px rgba(124, 58, 237, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .content-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 50px rgba(124, 58, 237, 0.15);
    }

    .card-header {
        padding: 24px 32px;
        background: linear-gradient(135deg, #faf5ff, #f5f3ff);
        border-bottom: 1px solid rgba(124, 58, 237, 0.1);
    }

    .card-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: var(--color-dark);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card-header h3 i {
        color: var(--color-primary);
        font-size: 22px;
    }

    .card-header p {
        margin: 8px 0 0 0;
        color: var(--color-gray);
        font-size: 14px;
    }

    .card-body {
        padding: 32px;
    }

    /* Formularios */
    .form-section {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--color-dark);
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .form-label .required {
        color: var(--color-danger);
        font-size: 12px;
    }

    .form-control {
        width: 100%;
        padding: 14px 18px;
        border: 1px solid rgba(124, 58, 237, 0.2);
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: white;
        color: var(--color-dark);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--color-primary);
        box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    /* Image Upload */
    .image-upload-container {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        border: 2px dashed rgba(124, 58, 237, 0.3);
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        transition: all 0.3s ease;
        cursor: pointer;
        margin-bottom: 16px;
    }

    .image-upload-container:hover {
        border-color: var(--color-primary);
    }

    .image-upload-container img {
        width: 100%;
        height: 240px;
        object-fit: cover;
        display: block;
    }

    .upload-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(124, 58, 237, 0.9);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .image-upload-container:hover .upload-overlay {
        opacity: 1;
    }

    /* Módulos y Lecciones */
    .modules-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(124, 58, 237, 0.1);
    }

    .modules-info h3 {
        margin: 0;
        font-size: 18px;
        color: var(--color-dark);
    }

    .modules-stats {
        display: flex;
        gap: 16px;
        margin-top: 8px;
        color: var(--color-gray);
        font-size: 14px;
    }

    .modules-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .module-card {
        background: white;
        border-radius: 16px;
        border: 1px solid rgba(124, 58, 237, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .module-card:hover {
        border-color: var(--color-primary);
        box-shadow: 0 15px 40px rgba(124, 58, 237, 0.15);
    }

    .module-header {
        padding: 20px;
        background: linear-gradient(135deg, #faf5ff, #f5f3ff);
        border-bottom: 1px solid rgba(124, 58, 237, 0.1);
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: move;
    }

    .drag-handle {
        color: var(--color-primary);
        cursor: grab;
        font-size: 16px;
    }

    .module-title-input {
        flex: 1;
        border: none;
        background: transparent;
        font-size: 16px;
        font-weight: 700;
        color: var(--color-dark);
        padding: 8px 12px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .module-title-input:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }

    .lessons-container {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    }

    .lesson-card {
        background: white;
        border-radius: 12px;
        padding: 16px;
        border: 1px solid rgba(124, 58, 237, 0.1);
        transition: all 0.2s ease;
    }

    .lesson-card:hover {
        border-color: var(--color-primary);
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(124, 58, 237, 0.1);
    }

    .lesson-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }

    .lesson-title-input {
        flex: 1;
        border: none;
        background: transparent;
        font-size: 14px;
        font-weight: 600;
        color: var(--color-dark);
        padding: 6px 10px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .lesson-title-input:focus {
        outline: none;
        background: rgba(124, 58, 237, 0.05);
    }

    /* Checklist */
    .checklist {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .checklist-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px;
        background: rgba(124, 58, 237, 0.03);
        border-radius: 12px;
        border: 1px solid rgba(124, 58, 237, 0.1);
        transition: all 0.3s ease;
    }

    .checklist-item.completed {
        background: linear-gradient(135deg, 
            rgba(16, 185, 129, 0.1), 
            rgba(16, 185, 129, 0.05));
        border-color: rgba(16, 185, 129, 0.2);
    }

    .check-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(124, 58, 237, 0.1);
        color: var(--color-primary);
        font-size: 12px;
    }

    .checklist-item.completed .check-icon {
        background: linear-gradient(135deg, var(--color-success), #059669);
        color: white;
    }

    /* Progress Bar */
    .progress-section {
        margin: 24px 0;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14px;
        font-weight: 600;
        color: var(--color-dark);
    }

    .progress-bar {
        height: 8px;
        background: rgba(124, 58, 237, 0.1);
        border-radius: 4px;
        overflow: hidden;
        position: relative;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light));
        border-radius: 4px;
        transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Botones */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light));
        color: white;
        box-shadow: 0 10px 30px rgba(124, 58, 237, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(124, 58, 237, 0.4);
    }

    .btn-secondary {
        background: white;
        color: var(--color-primary);
        border: 2px solid rgba(124, 58, 237, 0.2);
    }

    .btn-secondary:hover {
        background: rgba(124, 58, 237, 0.05);
        border-color: var(--color-primary);
        transform: translateY(-2px);
    }

    .btn-success {
        background: linear-gradient(135deg, var(--color-success), #059669);
        color: white;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(16, 185, 129, 0.4);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3);
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(239, 68, 68, 0.4);
    }

    .btn-sm {
        padding: 8px 16px;
        font-size: 13px;
        border-radius: 8px;
    }

    /* Action Footer */
    .action-footer {
        margin-top: 40px;
        padding: 30px;
        background: linear-gradient(135deg, #ffffff, #faf5ff);
        border-radius: 20px;
        border: 1px solid rgba(124, 58, 237, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .footer-info h3 {
        margin: 0 0 8px 0;
        font-size: 18px;
        color: var(--color-dark);
        font-weight: 700;
    }

    .footer-info p {
        margin: 0;
        color: var(--color-gray);
        font-size: 14px;
    }

    .footer-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    /* Toast */
    .toast {
        position: fixed;
        top: 100px;
        right: 30px;
        z-index: 1000;
        padding: 16px 20px;
        border-radius: 12px;
        background: white;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 12px;
        transform: translateX(400px);
        transition: transform 0.4s ease;
        max-width: 400px;
    }

    .toast.show {
        transform: translateX(0);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .editor-content {
            padding: 20px;
        }
        
        .editor-header {
            padding: 20px;
        }
        
        .header-top {
            flex-direction: column;
            gap: 16px;
        }
        
        .course-status {
            align-items: flex-start;
        }
        
        .content-grid {
            gap: 20px;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .action-footer {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }
        
        .footer-actions {
            justify-content: center;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('dashboard-content'); ?>
<div class="editor-container">
    <div class="editor-wrapper">
        <!-- Header del Editor -->
        <header class="editor-header">
            <div class="header-top">
                <div class="header-left">
                    <h1>Editor de Curso</h1>
                    <p>Diseña y organiza el contenido de tu curso profesionalmente</p>
                </div>
                <div class="course-status">
                    <div class="status-badge">
                        <div class="status-dot"></div>
                        <span class="status-text"><?php echo e(ucfirst($curso->status)); ?></span>
                    </div>
                    <div class="last-saved">
                        <i class="fas fa-save"></i>
                        <span>Guardado: <span id="saved-time">Hace instantes</span></span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Contenido Principal -->
        <main class="editor-content">
            <!-- Toast Notification -->
            <div id="toast" class="toast" role="alert">
                <div class="toast-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="toast-content">
                    <div class="toast-title" id="toast-title">Éxito</div>
                    <div class="toast-message" id="toast-message">Cambios guardados correctamente</div>
                </div>
                <button type="button" class="close-toast" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Grid de Contenido -->
            <div class="content-grid">
                <!-- Columna Principal -->
                <div class="main-content">
                    <!-- Información Básica -->
                    <section class="content-card">
                        <div class="card-header">
                            <h3><i class="fas fa-info-circle"></i> Información Básica</h3>
                            <p>Configura los detalles principales de tu curso</p>
                        </div>
                        <div class="card-body">
                            <!-- Imagen de Portada -->
                            <div class="form-section">
                                <label class="form-label">
                                    Imagen de Portada
                                    <span class="required">*</span>
                                </label>
                                <div class="image-upload-container" id="image-upload">
                                    <img id="course-image-preview" src="<?php echo e($initialImage); ?>" alt="Portada del curso">
                                    <div class="upload-overlay">
                                        <i class="fas fa-camera"></i>
                                        <span>Cambiar imagen</span>
                                    </div>
                                </div>
                                <input type="file" id="course-image-input" accept="image/*" style="display: none;">
                                <p style="margin-top: 8px; color: var(--color-gray); font-size: 13px;">
                                    Formato recomendado: 1280x720px • Máximo 4MB
                                </p>
                            </div>

                            <!-- Campos del Formulario -->
                            <div class="form-section">
                                <label class="form-label">
                                    Título del Curso
                                    <span class="required">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="course-title" 
                                       value="<?php echo e($courseDetail['title']); ?>"
                                       placeholder="Ej: Diseño UX desde Cero para Principiantes">
                            </div>

                            <div class="form-grid">
                                <div class="form-section">
                                    <label class="form-label">
                                        Categoría
                                        <span class="required">*</span>
                                    </label>
                                    <select class="form-control" id="course-category">
                                        <option value="">Selecciona una categoría</option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category); ?>" <?php echo e($courseDetail['category'] == $category ? 'selected' : ''); ?>>
                                                <?php echo e($category); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-section">
                                    <label class="form-label">
                                        Nivel
                                        <span class="required">*</span>
                                    </label>
                                    <select class="form-control" id="course-level">
                                        <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($level); ?>" <?php echo e($courseDetail['level'] == $level ? 'selected' : ''); ?>>
                                                <?php echo e(ucfirst($level)); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-grid">
                                <div class="form-section">
                                    <label class="form-label">
                                        Precio (S/)
                                        <span class="required">*</span>
                                    </label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="course-price" 
                                           value="<?php echo e($courseDetail['price']); ?>"
                                           min="0" 
                                           step="0.01"
                                           placeholder="0.00">
                                </div>

                                <div class="form-section">
                                    <label class="form-label">
                                        Duración (horas)
                                        <span class="required">*</span>
                                    </label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="course-duration" 
                                           value="<?php echo e($courseDetail['duration']); ?>"
                                           min="1"
                                           placeholder="10">
                                </div>
                            </div>

                            <div class="form-section">
                                <label class="form-label">
                                    Descripción
                                    <span class="required">*</span>
                                </label>
                                <textarea class="form-control" 
                                          id="course-description" 
                                          rows="4"
                                          placeholder="Describe brevemente tu curso y lo que aprenderán los estudiantes"><?php echo e($courseDetail['description']); ?></textarea>
                            </div>

                            <div class="form-grid">
                                <div class="form-section">
                                    <label class="form-label">
                                        Objetivos
                                        <span class="required">*</span>
                                    </label>
                                    <textarea class="form-control" 
                                              id="course-objectives" 
                                              rows="3"
                                              placeholder="Lista los objetivos principales"><?php echo e($courseDetail['objectives']); ?></textarea>
                                </div>

                                <div class="form-section">
                                    <label class="form-label">
                                        Requisitos
                                        <span class="required">*</span>
                                    </label>
                                    <textarea class="form-control" 
                                              id="course-requirements" 
                                              rows="3"
                                              placeholder="Requisitos previos"><?php echo e($courseDetail['requirements']); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Módulos y Lecciones -->
                    <section class="content-card" style="margin-top: 30px;">
                        <div class="card-header">
                            <h3><i class="fas fa-layer-group"></i> Estructura del Curso</h3>
                            <p>Organiza tu contenido en módulos y lecciones</p>
                        </div>
                        <div class="card-body">
                            <div class="modules-header">
                                <div class="modules-info">
                                    <h3>Módulos y Lecciones</h3>
                                    <div class="modules-stats">
                                        <span><i class="fas fa-cube"></i> <span id="modules-count"><?php echo e($curso->modules->count()); ?></span> módulos</span>
                                        <span><i class="fas fa-book"></i> <span id="lessons-count"><?php echo e($curso->modules->sum(fn($m) => $m->lessons->count())); ?></span> lecciones</span>
                                    </div>
                                </div>
                                <button type="button" id="add-module-btn" class="btn btn-primary">
                                    <i class="fas fa-plus"></i>
                                    <span>Nuevo Módulo</span>
                                </button>
                            </div>

                            <div id="modules-container" class="modules-container">
                                <?php $__empty_1 = true; $__currentLoopData = $curso->modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="module-card" data-module-id="<?php echo e($module->id); ?>">
                                        <div class="module-header">
                                            <div class="drag-handle">
                                                <i class="fas fa-grip-vertical"></i>
                                            </div>
                                            <input type="text" 
                                                   class="module-title-input" 
                                                   value="<?php echo e($module->title); ?>" 
                                                   placeholder="Título del módulo"
                                                   data-field="title">
                                            <div class="module-actions">
                                                <button type="button" class="btn btn-secondary btn-sm add-lesson-btn" data-module-id="<?php echo e($module->id); ?>">
                                                    <i class="fas fa-plus-circle"></i>
                                                    <span>Lección</span>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm delete-module-btn">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="lessons-container" data-lessons-container>
                                            <?php $__currentLoopData = $module->lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="lesson-card" data-lesson-id="<?php echo e($lesson->id); ?>">
                                                    <div class="lesson-header">
                                                        <div class="drag-handle">
                                                            <i class="fas fa-grip-lines"></i>
                                                        </div>
                                                        <input type="text" 
                                                               class="lesson-title-input" 
                                                               value="<?php echo e($lesson->title); ?>" 
                                                               placeholder="Título de la lección"
                                                               data-field="title">
                                                        <select class="lesson-type-select" data-field="type" style="min-width: 120px; padding: 6px 10px; border-radius: 6px; border: 1px solid rgba(124, 58, 237, 0.2); font-size: 13px;">
                                                            <option value="video" <?php echo e($lesson->type == 'video' ? 'selected' : ''); ?>>🎥 Video</option>
                                                            <option value="reading" <?php echo e($lesson->type == 'reading' ? 'selected' : ''); ?>>📖 Lectura</option>
                                                            <option value="quiz" <?php echo e($lesson->type == 'quiz' ? 'selected' : ''); ?>>📝 Quiz</option>
                                                            <option value="live" <?php echo e($lesson->type == 'live' ? 'selected' : ''); ?>>🔴 Live</option>
                                                            <option value="file" <?php echo e($lesson->type == 'file' ? 'selected' : ''); ?>>📎 Archivo</option>
                                                        </select>
                                                        <button type="button" class="btn btn-danger btn-sm delete-lesson-btn">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    <div class="lesson-content" style="<?php echo e(in_array($lesson->type, ['reading', 'quiz']) ? 'display: block; margin-top: 12px;' : 'display: none;'); ?>">
                                                        <?php if($lesson->type == 'video'): ?>
                                                            <input type="text" 
                                                                   class="form-control" 
                                                                   placeholder="URL del video (YouTube, Vimeo, etc.)"
                                                                   value="<?php echo e($lesson->video_url ?? ''); ?>"
                                                                   data-field="video_url">
                                                        <?php elseif($lesson->type == 'file'): ?>
                                                            <input type="text" 
                                                                   class="form-control" 
                                                                   placeholder="URL del recurso o archivo"
                                                                   value="<?php echo e($lesson->resource_url ?? ''); ?>"
                                                                   data-field="resource_url">
                                                        <?php else: ?>
                                                            <textarea class="form-control" 
                                                                      rows="3" 
                                                                      placeholder="Contenido de la lección"
                                                                      data-field="content"><?php echo e($lesson->content ?? ''); ?></textarea>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="empty-state">
                                        <i class="fas fa-book-open"></i>
                                        <h3>¡Comienza a estructurar tu curso!</h3>
                                        <p>Agrega módulos y lecciones para organizar el contenido de tu curso de manera profesional.</p>
                                        <button type="button" id="add-first-module" class="btn btn-primary">
                                            <i class="fas fa-plus"></i>
                                            <span>Crear Primer Módulo</span>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Sidebar de Progreso -->
                <aside class="sidebar-content">
                    <!-- Checklist -->
                    <section class="content-card">
                        <div class="card-header">
                            <h3><i class="fas fa-check-circle"></i> Checklist</h3>
                            <p>Revisa el progreso de tu curso</p>
                        </div>
                        <div class="card-body">
                            <div class="checklist" id="checklist">
                                <div class="checklist-item" data-check="basics">
                                    <div class="check-icon">
                                        <i class="fas fa-info"></i>
                                    </div>
                                    <div class="check-text">Información básica completa</div>
                                </div>
                                <div class="checklist-item" data-check="image">
                                    <div class="check-icon">
                                        <i class="fas fa-image"></i>
                                    </div>
                                    <div class="check-text">Imagen de portada cargada</div>
                                </div>
                                <div class="checklist-item" data-check="modules">
                                    <div class="check-icon">
                                        <i class="fas fa-layer-group"></i>
                                    </div>
                                    <div class="check-text">Al menos un módulo creado</div>
                                </div>
                                <div class="checklist-item" data-check="lessons">
                                    <div class="check-icon">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div class="check-text">Lecciones en cada módulo</div>
                                </div>
                                <div class="checklist-item" data-check="content">
                                    <div class="check-icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="check-text">Contenido completo</div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="progress-section">
                                <div class="progress-header">
                                    <span>Progreso del Curso</span>
                                    <span id="progress-percentage">0%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" id="progress-fill" style="width: 0%"></div>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 24px;">
                                <div style="background: rgba(124, 58, 237, 0.05); padding: 16px; border-radius: 12px; text-align: center; border: 1px solid rgba(124, 58, 237, 0.1);">
                                    <div style="font-size: 24px; font-weight: 800; color: var(--color-primary);" id="modules-stat"><?php echo e($curso->modules->count()); ?></div>
                                    <div style="font-size: 12px; color: var(--color-gray); text-transform: uppercase; letter-spacing: 0.5px;">Módulos</div>
                                </div>
                                <div style="background: rgba(14, 165, 233, 0.05); padding: 16px; border-radius: 12px; text-align: center; border: 1px solid rgba(14, 165, 233, 0.1);">
                                    <div style="font-size: 24px; font-weight: 800; color: var(--color-secondary);" id="lessons-stat"><?php echo e($curso->modules->sum(fn($m) => $m->lessons->count())); ?></div>
                                    <div style="font-size: 12px; color: var(--color-gray); text-transform: uppercase; letter-spacing: 0.5px;">Lecciones</div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Consejos -->
                    <section class="content-card" style="margin-top: 30px;">
                        <div class="card-header">
                            <h3><i class="fas fa-lightbulb"></i> Consejos</h3>
                            <p>Mejora tu curso</p>
                        </div>
                        <div class="card-body">
                            <div style="display: flex; flex-direction: column; gap: 16px;">
                                <div style="display: flex; gap: 12px; align-items: flex-start;">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(124, 58, 237, 0.1); display: flex; align-items: center; justify-content: center; color: var(--color-primary); flex-shrink: 0;">
                                        <i class="fas fa-video"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: var(--color-dark); margin-bottom: 4px; font-size: 14px;">Videos Cortos</div>
                                        <div style="font-size: 13px; color: var(--color-gray);">Mantén los videos entre 5-15 minutos para mejor retención.</div>
                                    </div>
                                </div>
                                <div style="display: flex; gap: 12px; align-items: flex-start;">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(16, 185, 129, 0.1); display: flex; align-items: center; justify-content: center; color: var(--color-success); flex-shrink: 0;">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: var(--color-dark); margin-bottom: 4px; font-size: 14px;">Recursos Prácticos</div>
                                        <div style="font-size: 13px; color: var(--color-gray);">Incluye PDFs y plantillas descargables.</div>
                                    </div>
                                </div>
                                <div style="display: flex; gap: 12px; align-items: flex-start;">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(14, 165, 233, 0.1); display: flex; align-items: center; justify-content: center; color: var(--color-secondary); flex-shrink: 0;">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: var(--color-dark); margin-bottom: 4px; font-size: 14px;">Evaluaciones</div>
                                        <div style="font-size: 13px; color: var(--color-gray);">Agrega quizzes para reforzar el aprendizaje.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </aside>
            </div>

            <!-- Footer de Acciones -->
            <footer class="action-footer">
                <div class="footer-info">
                    <h3>¿Listo para continuar?</h3>
                    <p>Guarda tus cambios o envía el curso a revisión cuando esté completo</p>
                </div>
                <div class="footer-actions">
                    <button type="button" id="save-all-btn" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        <span>Guardar Todo</span>
                    </button>
                    <a href="<?php echo e(route('cursos.show', $curso)); ?>" target="_blank" class="btn btn-secondary">
                        <i class="fas fa-eye"></i>
                        <span>Vista Previa</span>
                    </a>
                    <form id="send-to-review-form" action="<?php echo e(route('cursos.send-to-review', $curso)); ?>" method="POST" style="margin: 0;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" id="send-to-review-btn" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            <span>Enviar a Revisión</span>
                        </button>
                    </form>
                </div>
            </footer>
        </main>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const courseId = <?php echo e($curso->id); ?>;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    const basicsEndpoint = "<?php echo e(route('cursos.update-basics', $curso)); ?>";
    const orderEndpoint = "<?php echo e(route('cursos.order', $curso)); ?>";
    const addModuleEndpoint = "<?php echo e(route('cursos.modules.store', $curso)); ?>";
    const fullSaveEndpoint = "<?php echo e(route('cursos.full-save', $curso)); ?>";

    const modulesContainer = document.getElementById('modules-container');
    const addModuleBtn = document.getElementById('add-module-btn');
    const addFirstModuleBtn = document.getElementById('add-first-module');
    const saveAllBtn = document.getElementById('save-all-btn');
    const sendToReviewForm = document.getElementById('send-to-review-form');

    const basicsFields = {
        title: document.getElementById('course-title'),
        category: document.getElementById('course-category'),
        level: document.getElementById('course-level'),
        price: document.getElementById('course-price'),
        duration: document.getElementById('course-duration'),
        description: document.getElementById('course-description'),
        objectives: document.getElementById('course-objectives'),
        requirements: document.getElementById('course-requirements'),
    };

    const toastEl = document.getElementById('toast');
    const toastTitle = document.getElementById('toast-title');
    const toastMessage = document.getElementById('toast-message');
    const toastClose = document.querySelector('.close-toast');

    const showToast = (title, message) => {
        if (!toastEl) return;
        toastTitle && (toastTitle.textContent = title);
        toastMessage && (toastMessage.textContent = message);
        toastEl.classList.add('show');
        setTimeout(() => toastEl.classList.remove('show'), 3000);
    };
    toastClose?.addEventListener('click', () => toastEl?.classList.remove('show'));

    const fetchJson = (url, options = {}) => {
        const headers = options.headers || {};
        return fetch(url, {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                ...headers,
            },
            ...options,
        }).then(async (res) => {
            if (!res.ok) throw await res.json().catch(() => new Error(res.statusText));
            return res.json();
        });
    };

    const debounce = (fn, delay = 400) => {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(null, args), delay);
        };
    };

    const updateBasics = debounce(() => {
        if (!basicsEndpoint) return;
        const payload = {
            title: basicsFields.title?.value ?? '',
            category: basicsFields.category?.value ?? '',
            level: basicsFields.level?.value ?? 'principiante',
            price: Number(basicsFields.price?.value ?? 0),
            duration: Number(basicsFields.duration?.value ?? 1),
            description: basicsFields.description?.value ?? '',
            objectives: basicsFields.objectives?.value ?? '',
            requirements: basicsFields.requirements?.value ?? '',
        };
        fetchJson(basicsEndpoint, { method: 'PUT', body: JSON.stringify(payload) }).catch(() => {});
    });

    Object.values(basicsFields).forEach((field) => field?.addEventListener('input', updateBasics));

    const updateCounters = () => {
        const modulesCountEl = document.getElementById('modules-count');
        const lessonsCountEl = document.getElementById('lessons-count');
        const modules = modulesContainer?.querySelectorAll('.module-card') ?? [];
        const lessons = modulesContainer?.querySelectorAll('.lesson-card') ?? [];
        if (modulesCountEl) modulesCountEl.textContent = modules.length;
        if (lessonsCountEl) lessonsCountEl.textContent = lessons.length;
    };

    const toggleLessonContentVisibility = (lessonCard, type) => {
        const contentBlock = lessonCard.querySelector('.lesson-content');
        if (!contentBlock) return;
        contentBlock.style.display = ['reading', 'quiz'].includes(type) ? 'block' : 'none';
    };

    const persistLesson = debounce((lessonCard) => {
        const lessonId = lessonCard.dataset.lessonId;
        if (!lessonId) return;
        const payload = {
            title: lessonCard.querySelector('[data-field="title"]')?.value ?? '',
            type: lessonCard.querySelector('[data-field="type"]')?.value ?? 'video',
            video_url: lessonCard.querySelector('[data-field="video_url"]')?.value ?? null,
            resource_url: lessonCard.querySelector('[data-field="resource_url"]')?.value ?? null,
            content: lessonCard.querySelector('[data-field="content"]')?.value ?? null,
        };
        fetchJson(`<?php echo e(url('/lessons')); ?>/${lessonId}`, { method: 'PUT', body: JSON.stringify(payload) }).catch(() => {});
    });

    const registerLessonCard = (lessonCard) => {
        const typeSelect = lessonCard.querySelector('.lesson-type-select');
        const deleteBtn = lessonCard.querySelector('.delete-lesson-btn');
        const inputs = lessonCard.querySelectorAll('[data-field]');

        if (typeSelect) {
            typeSelect.addEventListener('change', (e) => {
                toggleLessonContentVisibility(lessonCard, e.target.value);
                lessonCard.querySelector('[data-field="type"]')?.setAttribute('value', e.target.value);
                persistLesson(lessonCard);
            });
        }

        inputs.forEach((input) => {
            input.addEventListener('input', () => persistLesson(lessonCard));
        });

        deleteBtn?.addEventListener('click', () => {
            const lessonId = lessonCard.dataset.lessonId;
            if (!lessonId || !confirm('Eliminar esta lección?')) return;
            fetchJson(`<?php echo e(url('/lessons')); ?>/${lessonId}`, { method: 'DELETE' })
                .then(() => {
                    lessonCard.remove();
                    updateCounters();
                })
                .catch(() => {});
        });
    };

    const persistModule = debounce((moduleCard) => {
        const moduleId = moduleCard.dataset.moduleId;
        if (!moduleId) return;
        const payload = {
            title: moduleCard.querySelector('[data-field="title"]')?.value ?? '',
            description: moduleCard.querySelector('[data-field="description"]')?.value ?? '',
        };
        fetchJson(`<?php echo e(url('/modules')); ?>/${moduleId}`, { method: 'PUT', body: JSON.stringify(payload) }).catch(() => {});
    });

    const registerModuleCard = (moduleCard) => {
        const addLessonBtn = moduleCard.querySelector('.add-lesson-btn');
        const deleteModuleBtn = moduleCard.querySelector('.delete-module-btn');
        const lessonsContainer = moduleCard.querySelector('[data-lessons-container]');
        const titleInput = moduleCard.querySelector('[data-field="title"]');
        const descInput = moduleCard.querySelector('[data-field="description"]');

        titleInput?.addEventListener('input', () => persistModule(moduleCard));
        descInput?.addEventListener('input', () => persistModule(moduleCard));

        addLessonBtn?.addEventListener('click', () => {
            const moduleId = moduleCard.dataset.moduleId;
            const title = prompt('Título de la lección', 'Nueva lección');
            if (!moduleId || !title) return;
            fetchJson(`<?php echo e(url('/modules')); ?>/${moduleId}/lessons`, {
                method: 'POST',
                body: JSON.stringify({ title, type: 'video' }),
            })
                .then(({ lesson }) => {
                    const lessonCard = document.createElement('div');
                    lessonCard.className = 'lesson-card';
                    lessonCard.dataset.lessonId = lesson.id;
                    lessonCard.innerHTML = `
                        <div class="lesson-header">
                            <div class="drag-handle"><i class="fas fa-grip-lines"></i></div>
                            <input type="text" class="lesson-title-input" data-field="title" value="${lesson.title}" placeholder="Título de la lección">
                            <select class="lesson-type-select" data-field="type" style="min-width: 120px; padding: 6px 10px; border-radius: 6px; border: 1px solid rgba(124, 58, 237, 0.2); font-size: 13px;">
                                <option value="video">🎬 Video</option>
                                <option value="reading">📄 Lectura</option>
                                <option value="quiz">❓ Quiz</option>
                                <option value="live">🎥 Live</option>
                                <option value="file">📁 Archivo</option>
                            </select>
                            <button type="button" class="btn btn-danger btn-sm delete-lesson-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="lesson-content" style="display:none;">
                            <textarea class="form-control" rows="3" placeholder="Contenido de la lección" data-field="content"></textarea>
                        </div>
                    `;
                    lessonsContainer.appendChild(lessonCard);
                    registerLessonCard(lessonCard);
                    updateCounters();
                })
                .catch(() => {});
        });

        deleteModuleBtn?.addEventListener('click', () => {
            const moduleId = moduleCard.dataset.moduleId;
            if (!moduleId || !confirm('Eliminar este módulo?')) return;
            fetchJson(`<?php echo e(url('/modules')); ?>/${moduleId}`, { method: 'DELETE' })
                .then(() => {
                    moduleCard.remove();
                    updateCounters();
                })
                .catch(() => {});
        });

        lessonsContainer?.querySelectorAll('.lesson-card')?.forEach(registerLessonCard);

        new Sortable(lessonsContainer, {
            handle: '.drag-handle',
            animation: 200,
            onEnd: sendOrder,
        });
    };

    const sendOrder = debounce(() => {
        if (!orderEndpoint) return;
        const modulesOrder = Array.from(modulesContainer.querySelectorAll('.module-card')).map((m) => m.dataset.moduleId);
        const lessonsOrder = {};
        modulesContainer.querySelectorAll('.module-card').forEach((moduleCard) => {
            const moduleId = moduleCard.dataset.moduleId;
            lessonsOrder[moduleId] = Array.from(moduleCard.querySelectorAll('.lesson-card')).map((lesson) => lesson.dataset.lessonId);
        });
        fetchJson(orderEndpoint, {
            method: 'PUT',
            body: JSON.stringify({ modules: modulesOrder, lessons: lessonsOrder }),
        }).catch(() => {});
    }, 300);

    addModuleBtn?.addEventListener('click', () => {
        const title = prompt('Nombre del módulo', 'Nuevo módulo');
        if (!title) return;
        fetchJson(addModuleEndpoint, {
            method: 'POST',
            body: JSON.stringify({ title }),
        })
            .then(({ module }) => {
                const wrapper = document.createElement('div');
                wrapper.className = 'module-card';
                wrapper.dataset.moduleId = module.id;
                wrapper.innerHTML = `
                    <div class="module-header">
                        <div class="drag-handle"><i class="fas fa-grip-vertical"></i></div>
                        <input type="text" class="module-title-input" value="${module.title}" placeholder="Título del módulo" data-field="title">
                        <div class="module-actions">
                            <button type="button" class="btn btn-secondary btn-sm add-lesson-btn" data-module-id="${module.id}">
                                <i class="fas fa-plus-circle"></i><span>Lección</span>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm delete-module-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="lessons-container" data-lessons-container></div>
                `;
                modulesContainer.appendChild(wrapper);
                registerModuleCard(wrapper);
                updateCounters();
            })
            .catch(() => {});
    });

    addFirstModuleBtn?.addEventListener('click', () => addModuleBtn?.click());

    modulesContainer?.querySelectorAll('.module-card')?.forEach(registerModuleCard);

    new Sortable(modulesContainer, {
        handle: '.drag-handle',
        animation: 200,
        onEnd: sendOrder,
    });

    saveAllBtn?.addEventListener('click', () => {
        const modulesPayload = Array.from(modulesContainer.querySelectorAll('.module-card')).map((moduleCard, moduleIndex) => {
            const lessons = Array.from(moduleCard.querySelectorAll('.lesson-card')).map((lessonCard, lessonIndex) => ({
                id: lessonCard.dataset.lessonId,
                title: lessonCard.querySelector('[data-field="title"]')?.value ?? '',
                type: lessonCard.querySelector('[data-field="type"]')?.value ?? 'video',
                content: lessonCard.querySelector('[data-field="content"]')?.value ?? '',
                video_url: lessonCard.querySelector('[data-field="video_url"]')?.value ?? null,
                resource_url: lessonCard.querySelector('[data-field="resource_url"]')?.value ?? null,
                position: lessonIndex + 1,
            }));
            return {
                id: moduleCard.dataset.moduleId,
                title: moduleCard.querySelector('[data-field="title"]')?.value ?? '',
                description: moduleCard.querySelector('[data-field="description"]')?.value ?? '',
                position: moduleIndex + 1,
                lessons,
            };
        });

        const payload = {
            title: basicsFields.title?.value ?? '',
            category: basicsFields.category?.value ?? '',
            level: basicsFields.level?.value ?? 'principiante',
            price: Number(basicsFields.price?.value ?? 0),
            duration: Number(basicsFields.duration?.value ?? 1),
            description: basicsFields.description?.value ?? '',
            objectives: basicsFields.objectives?.value ?? '',
            requirements: basicsFields.requirements?.value ?? '',
            modules: modulesPayload,
        };

        fetchJson(fullSaveEndpoint, { method: 'POST', body: JSON.stringify(payload) })
            .then(() => showToast('Guardado', 'Los cambios han sido guardados'))
            .catch(() => {});
    });

    sendToReviewForm?.addEventListener('submit', (event) => {
        const hasModules = modulesContainer.querySelector('.module-card');
        const hasLessons = modulesContainer.querySelector('.lesson-card');
        if (!hasModules || !hasLessons) {
            event.preventDefault();
            alert('Agrega al menos un módulo y una lección antes de enviar a revisión.');
        }
    });

    updateCounters();
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\NADHIRA\Downloads\SkillNest\resources\views/cursos/editor.blade.php ENDPATH**/ ?>