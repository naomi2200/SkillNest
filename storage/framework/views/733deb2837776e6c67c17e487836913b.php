

<?php $__env->startSection('mentor-title', 'Crear mentor&iacute;a'); ?>
<?php $__env->startSection('mentor-subtitle', 'Define cada detalle de tu nueva sesi&oacute;n personalizada'); ?>

<?php $__env->startSection('mentor-actions'); ?>
    <a href="<?php echo e(route('mentor.mentorias.index')); ?>" class="btn btn-secondary" style="border-radius: 999px; padding: 10px 22px;">
        Mis mentor&iacute;as
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .mentor-shell .mentor-header,
    .mentor-shell .mentor-actions {
        display: none !important;
    }
    .mentoria-create-page {
        background: radial-gradient(circle at 20% 20%, rgba(124,58,237,0.12), transparent 40%),
                    radial-gradient(circle at 80% 0%, rgba(99,102,241,0.08), transparent 30%),
                    #f5f4ff;
        min-height: calc(100vh - 120px);
        padding: 48px 0 80px;
    }
    .mentoria-create-shell {
        width: 100%;
        max-width: 1120px;
        margin: 0 auto;
        padding: 0 20px;
        display: grid;
        gap: 24px;
    }
    .mentoria-create-hero {
        background: #fff;
        border-radius: 30px;
        padding: 32px;
        box-shadow: 0 30px 70px rgba(15,23,42,0.08);
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
        align-items: center;
    }
    .mentoria-create-hero h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 6px 0;
        color: #1f2937;
    }
    .mentoria-create-hero p {
        color: #6b7280;
        margin: 0;
    }
    .hero-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        border-radius: 999px;
        background: rgba(124,58,237,0.12);
        color: #5b21b6;
        font-weight: 600;
        font-size: .9rem;
    }
    .mentoria-create-grid {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(0, 1fr);
        gap: 24px;
    }
    .mentoria-card {
        background: #fff;
        border-radius: 28px;
        padding: 32px;
        box-shadow: 0 25px 60px rgba(15,23,42,0.08);
        border: 1px solid rgba(226,232,240,0.8);
    }
    .form-section { margin-bottom: 22px; }
    .form-section:last-child { margin-bottom: 0; }
    .form-label {
        display: flex;
        justify-content: space-between;
        font-size: .9rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
    }
    .form-field {
        width: 100%;
        border-radius: 18px;
        border: 1.5px solid #e2e8f0;
        padding: 14px 16px;
        font-size: 1rem;
        background: #f8fafc;
        transition: border-color .2s ease, box-shadow .2s ease;
    }
    .form-field:focus {
        outline: none;
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124,58,237,0.14);
        background: #fff;
    }
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
    }
    .mentoria-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 28px;
    }
    .btn-glass {
        border-radius: 18px;
        padding: 13px 28px;
        border: 2px solid rgba(124,58,237,0.2);
        background: transparent;
        color: #7c3aed;
        font-weight: 600;
        text-decoration: none;
        text-align: center;
    }
    .btn-gradient {
        border: none;
        border-radius: 18px;
        padding: 14px 32px;
        background: linear-gradient(135deg,#667eea,#764ba2);
        color: #fff;
        font-weight: 700;
        box-shadow: 0 18px 35px rgba(103,119,239,0.35);
        cursor: pointer;
        display: inline-flex;
        gap: 8px;
        align-items: center;
        justify-content: center;
    }
    .mentoria-summary h3 {
        margin: 0;
        font-size: 1.35rem;
        font-weight: 700;
        color: #1f2937;
    }
    .summary-list {
        list-style: none;
        padding: 0;
        margin: 24px 0 0;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .summary-item {
        display: flex;
        gap: 14px;
    }
    .summary-icon {
        width: 44px;
        height: 44px;
        border-radius: 16px;
        background: rgba(124,58,237,0.12);
        color: #7c3aed;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    @media (max-width: 1024px) {
        .mentoria-create-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
        .mentoria-create-hero,
        .mentoria-card { padding: 24px; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('mentor-content'); ?>
    <section class="mentoria-create-page">
        <div class="mentoria-create-shell">
            <header class="mentoria-create-hero">
                <div>
                    <span class="hero-pill"><i class="fa-solid fa-magic-wand-sparkles"></i> Paso 1 &middot; Detalles</span>
                    <h1>Crear nueva mentor&iacute;a</h1>
                    <p>Cu&eacute;ntanos c&oacute;mo ser&aacute; tu sesi&oacute;n personalizada: objetivos, duraci&oacute;n, precio y modalidad.</p>
                </div>
            </header>

            <div class="mentoria-create-grid">
                <div class="mentoria-card">
                    <form action="<?php echo e(route('mentorias.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-section">
                            <label for="titulo" class="form-label">T&iacute;tulo</label>
                            <input id="titulo" name="titulo" type="text" class="form-field" value="<?php echo e(old('titulo')); ?>" required>
                        </div>
                        <div class="form-section">
                            <label for="especialidad" class="form-label">Especialidad / tem&aacute;tica</label>
                            <input id="especialidad" name="especialidad" type="text" class="form-field" value="<?php echo e(old('especialidad')); ?>" placeholder="Ej: Finanzas personales, UX Research" required>
                        </div>
                        <div class="form-grid form-section">
                            <div>
                                <label for="modalidad" class="form-label">Modalidad</label>
                                <select id="modalidad" name="modalidad" class="form-field">
                                    <option value="virtual" <?php echo e(old('modalidad') === 'virtual' ? 'selected' : ''); ?>>Virtual</option>
                                    <option value="presencial" <?php echo e(old('modalidad') === 'presencial' ? 'selected' : ''); ?>>Presencial</option>
                                </select>
                            </div>
                            <div>
                                <label for="precio" class="form-label">Precio (S/)</label>
                                <input id="precio" name="precio" type="number" step="0.01" class="form-field" value="<?php echo e(old('precio')); ?>" required>
                            </div>
                            <div>
                                <label for="duracion_minutos" class="form-label">Duraci&oacute;n (min)</label>
                                <input id="duracion_minutos" name="duracion_minutos" type="number" min="15" class="form-field" value="<?php echo e(old('duracion_minutos', 60)); ?>" required>
                            </div>
                        </div>
                        <div class="form-section">
                            <label for="descripcion" class="form-label">Descripci&oacute;n</label>
                            <textarea id="descripcion" name="descripcion" rows="5" class="form-field" required><?php echo e(old('descripcion')); ?></textarea>
                        </div>
                        <div class="mentoria-actions">
                            <a href="<?php echo e(route('mentor.mentorias.index')); ?>" class="btn-glass">Cancelar</a>
                            <button type="submit" class="btn-gradient">
                                <i class="fa-solid fa-rocket"></i> Crear mentor&iacute;a
                            </button>
                        </div>
                    </form>
                </div>

                <aside class="mentoria-card mentoria-summary">
                    <span class="hero-pill" style="background:rgba(16,185,129,0.12);color:#047857;">
                        <i class="fa-solid fa-lightbulb"></i> Recomendaciones r&aacute;pidas
                    </span>
                    <h3>Haz que tu oferta destaque</h3>
                    <p style="margin-top:12px;color:#6b7280;">Define con precisi&oacute;n a qui&eacute;n ayudas, qu&eacute; lograr&aacute;n en 60 minutos contigo y qu&eacute; materiales o seguimiento recibir&aacute;n.</p>
                    <ul class="summary-list">
                        <li class="summary-item">
                            <div class="summary-icon"><i class="fa-solid fa-pen-to-square"></i></div>
                            <div>
                                <h4>Describe beneficios</h4>
                                <p>Menciona resultados concretos que el estudiante obtendr&aacute; al finalizar la sesi&oacute;n.</p>
                            </div>
                        </li>
                        <li class="summary-item">
                            <div class="summary-icon" style="background:rgba(14,165,233,0.15);color:#0369a1;"><i class="fa-solid fa-video"></i></div>
                            <div>
                                <h4>Modalidad clara</h4>
                                <p>Indica si incluye grabaci&oacute;n, plantillas o materiales adicionales.</p>
                            </div>
                        </li>
                        <li class="summary-item">
                            <div class="summary-icon" style="background:rgba(248,113,113,0.15);color:#b91c1c;"><i class="fa-solid fa-user-check"></i></div>
                            <div>
                                <h4>Perfil ideal</h4>
                                <p>Explica para qui&eacute;n est&aacute; pensada la mentor&iacute;a para atraer al p&uacute;blico correcto.</p>
                            </div>
                        </li>
                        <li class="summary-item">
                            <div class="summary-icon" style="background:rgba(16,185,129,0.15);color:#047857;"><i class="fa-solid fa-chart-line"></i></div>
                            <div>
                                <h4>Prop&oacute;n siguiente paso</h4>
                                <p>Sugiere un plan de acci&oacute;n o seguimiento para maximizar el aprovechamiento.</p>
                            </div>
                        </li>
                    </ul>
                </aside>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mentor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/mentorias/create.blade.php ENDPATH**/ ?>