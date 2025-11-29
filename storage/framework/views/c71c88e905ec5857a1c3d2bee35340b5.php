<?php $__env->startSection('student-title', 'Panel del estudiante'); ?>
<?php $__env->startSection('student-subtitle', 'Revisa tus cursos y mentorías'); ?>

<?php $__env->startSection('student-widgets'); ?>
    <div class="stat-card">
        <div class="stat-label">Cursos activos</div>
        <div class="stat-value">0</div>
        <div class="stat-description">Cursos que puedes continuar ahora</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Mentorías agendadas</div>
        <div class="stat-value">0</div>
        <div class="stat-description">Sesiones confirmadas próximamente</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Progreso total</div>
        <div class="stat-value">0%</div>
        <div class="stat-description">Tu avance en la plataforma</div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('student-content'); ?>
    <div class="content-card">
        <h2>Continuar curso</h2>
        <div class="empty-state">
            <div class="empty-icon">📚</div>
            <p class="empty-text">Todavía no te has inscrito en ningún curso</p>
        </div>
    </div>

    <div class="content-card">
        <h2>Próximas mentorías</h2>
        <div class="empty-state">
            <div class="empty-icon">💼</div>
            <p class="empty-text">No tienes mentorías agendadas</p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/student/dashboard.blade.php ENDPATH**/ ?>