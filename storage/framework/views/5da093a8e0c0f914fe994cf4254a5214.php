<?php $__env->startPush('styles'); ?>
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --success-gradient: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        --card-hover-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    /* Animaciones */
    @keyframes fadeInUp {
        from { 
            opacity: 0; 
            transform: translateY(30px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }

    @keyframes slideInLeft {
        from { 
            opacity: 0; 
            transform: translateX(-30px); 
        }
        to { 
            opacity: 1; 
            transform: translateX(0); 
        }
    }

    /* Animaciones aplicadas */
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .animate-slide-left {
        animation: slideInLeft 0.4s ease-out forwards;
    }

    /* Layout Principal */
    .courses-page {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
    }

    .courses-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 24px;
    }

    /* Header del catálogo */
    .catalog-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .catalog-header h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 2.8rem;
        font-weight: 800;
        color: #1a202c;
        margin-bottom: 16px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .catalog-subtitle {
        font-size: 1.1rem;
        color: #718096;
        max-width: 600px;
        margin: 0 auto 32px;
        line-height: 1.6;
    }

    /* Layout principal */
    .courses-layout {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 32px;
        margin-top: 20px;
    }

    @media (max-width: 1024px) {
        .courses-layout {
            grid-template-columns: 1fr;
            gap: 32px;
        }
    }

    /* ===== FILTROS ===== */
    .filters-panel {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--card-shadow);
        border: 1px solid #e2e8f0;
        position: sticky;
        top: 100px;
        max-height: calc(100vh - 120px);
        overflow-y: auto;
    }

    .filters-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f1f5f9;
    }

    .filters-header h2 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2d3748;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .clear-filters {
        background: #667eea;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .clear-filters:hover {
        background: #5a67d8;
        transform: translateY(-1px);
    }

    /* Grupos de filtros */
    .filter-group {
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f1f5f9;
    }

    .filter-group:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .filter-group label {
        display: block;
        margin-bottom: 12px;
        font-weight: 600;
        color: #4a5568;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Búsqueda */
    .search-container {
        position: relative;
        margin-bottom: 20px;
    }

    .search-input {
        width: 100%;
        padding: 12px 16px 12px 40px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: white;
        color: #2d3748;
    }

    .search-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        font-size: 1rem;
    }

    /* Checkboxes y radios */
    .filter-option {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        cursor: pointer;
        user-select: none;
    }

    .filter-option input[type="checkbox"],
    .filter-option input[type="radio"] {
        display: none;
    }

    .custom-checkbox {
        width: 18px;
        height: 18px;
        border: 2px solid #cbd5e1;
        border-radius: 4px;
        margin-right: 10px;
        position: relative;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .custom-radio {
        width: 18px;
        height: 18px;
        border: 2px solid #cbd5e1;
        border-radius: 50%;
        margin-right: 10px;
        position: relative;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .filter-option input:checked + .custom-checkbox {
        background: #667eea;
        border-color: #667eea;
    }

    .filter-option input:checked + .custom-checkbox::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 10px;
        font-weight: bold;
    }

    .filter-option input:checked + .custom-radio {
        border-color: #667eea;
    }

    .filter-option input:checked + .custom-radio::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 8px;
        height: 8px;
        background: #667eea;
        border-radius: 50%;
    }

    .filter-text {
        flex: 1;
        color: #4a5568;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .filter-count {
        background: #f7fafc;
        color: #718096;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 500;
        min-width: 32px;
        text-align: center;
        margin-left: 8px;
    }

    /* Botón aplicar filtros */
    .apply-filters {
        background: var(--primary-gradient);
        color: white;
        border: none;
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .apply-filters:hover {
        transform: translateY(-2px);
        box-shadow: var(--card-hover-shadow);
    }

    /* ===== RESULTADOS ===== */
    .courses-results {
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    /* Topbar de resultados */
    .results-topbar {
        background: white;
        border-radius: 16px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: var(--card-shadow);
        border: 1px solid #e2e8f0;
    }

    .results-info h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 4px;
    }

    .results-count {
        color: #718096;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .results-controls {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sort-select {
        padding: 10px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 500;
        color: #4a5568;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
        min-width: 180px;
    }

    .sort-select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    /* ===== TARJETAS DE CURSOS ===== */
    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 24px;
    }

    @media (max-width: 768px) {
        .courses-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Tarjeta principal */
    .course-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        opacity: 0;
        animation: fadeInUp 0.6s ease-out forwards;
        animation-delay: calc(var(--index, 0) * 0.1s);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover-shadow);
    }

    /* Imagen del curso */
    .course-image-container {
        position: relative;
        height: 180px;
        overflow: hidden;
    }

    .course-card__image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .course-card:hover .course-card__image {
        transform: scale(1.05);
    }

    .course-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        z-index: 2;
    }

    .badge-popular {
        background: var(--primary-gradient);
        color: white;
    }

    .badge-new {
        background: var(--accent-gradient);
        color: white;
    }

    .badge-free {
        background: var(--success-gradient);
        color: white;
    }

    .badge-bestseller {
        background: var(--secondary-gradient);
        color: white;
    }

    /* Contenido de la tarjeta */
    .course-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    /* Categoría y nivel */
    .course-meta-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .course-category {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        background: rgba(102, 126, 234, 0.1);
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #667eea;
    }

    .course-level {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .level-beginner {
        background: rgba(72, 187, 120, 0.1);
        color: #38a169;
    }

    .level-intermediate {
        background: rgba(246, 173, 85, 0.1);
        color: #ed8936;
    }

    .level-advanced {
        background: rgba(245, 101, 101, 0.1);
        color: #e53e3e;
    }

    /* Título del curso */
    .course-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 12px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 3.5em;
    }

    /* Descripción */
    .course-description {
        color: #718096;
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 16px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }

    /* Perfil del mentor */
    .mentor-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .mentor-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        flex-shrink: 0;
    }

    .mentor-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .mentor-info {
        flex: 1;
    }

    .mentor-name {
        font-weight: 600;
        color: #2d3748;
        font-size: 0.95rem;
        margin-bottom: 2px;
    }

    .mentor-specialty {
        color: #718096;
        font-size: 0.85rem;
    }

    /* Estadísticas del curso */
    .course-stats {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #718096;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .stat-item i {
        color: #667eea;
    }

    .rating-stars {
        display: flex;
        align-items: center;
        gap: 2px;
        color: #f6ad55;
    }

    /* Precio y acciones */
    .course-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }

    .course-price {
        font-size: 1.5rem;
        font-weight: 800;
        color: #2d3748;
        display: flex;
        align-items: baseline;
        gap: 2px;
    }

    .price-currency {
        font-size: 0.9rem;
        color: #718096;
        font-weight: 500;
        margin-right: 2px;
    }

    .course-price.free {
        color: #38a169;
    }

    .course-actions {
        display: flex;
        gap: 8px;
    }

    .btn-view {
        padding: 8px 16px;
        background: transparent;
        border: 2px solid #667eea;
        color: #667eea;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-view:hover {
        background: #667eea;
        color: white;
        transform: translateY(-1px);
    }

    .btn-enroll {
        padding: 8px 16px;
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-enroll:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    /* Paginación */
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        margin-top: 40px;
    }

    .pagination-btn {
        padding: 8px 16px;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        color: #4a5568;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .pagination-btn:hover:not(:disabled) {
        border-color: #667eea;
        color: #667eea;
        transform: translateY(-1px);
    }

    .pagination-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .page-number {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        border: 2px solid #e2e8f0;
        color: #4a5568;
        font-size: 0.9rem;
    }

    .page-number:hover:not(.active) {
        border-color: #667eea;
        color: #667eea;
    }

    .page-number.active {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }

    /* Estados vacíos */
    .empty-state {
        text-align: center;
        padding: 60px 32px;
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
    }

    .empty-state__icon {
        font-size: 3rem;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .empty-state__title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 12px;
    }

    .empty-state__description {
        color: #718096;
        font-size: 1rem;
        max-width: 400px;
        margin: 0 auto 24px;
        line-height: 1.5;
    }
</style>
<?php $__env->stopPush(); ?>

<?php
    // DATOS DE EJEMPLO COMPLETOS - SIN CONDICIONES
    $catalog = collect([
        [
            'id' => 1,
            'title' => 'Inglés para Negocios Internacionales - Nivel Avanzado',
            'mentor' => 'Sarah Johnson',
            'mentor_specialty' => 'Profesora de Inglés Empresarial con 10+ años de experiencia',
            'mentor_avatar' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?auto=format&fit=crop&w=200&q=80',
            'category' => 'Idiomas',
            'category_slug' => 'idiomas',
            'price' => 299,
            'original_price' => 399,
            'rating' => 4.9,
            'students' => 1245,
            'reviews' => 342,
            'duration' => '48 horas',
            'lessons' => 24,
            'image' => 'https://images.unsplash.com/photo-1517077304055-6e89abbf09b0?auto=format&fit=crop&w=900&q=80',
            'description' => 'Domina el inglés empresarial para reuniones, negociaciones y presentaciones internacionales. Curso práctico con casos reales y simulaciones de situaciones profesionales.',
            'level' => 'Avanzado',
            'badge' => 'popular',
            'language' => 'Inglés'
        ],
        [
            'id' => 2,
            'title' => 'Desarrollo Web Full Stack: React, Node.js y MongoDB',
            'mentor' => 'Carlos Rodríguez',
            'mentor_specialty' => 'Senior Full Stack Developer en empresas Fortune 500',
            'mentor_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
            'category' => 'Programación',
            'category_slug' => 'programacion',
            'price' => 449,
            'original_price' => 599,
            'rating' => 4.8,
            'students' => 2156,
            'reviews' => 567,
            'duration' => '60 horas',
            'lessons' => 30,
            'image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=900&q=80',
            'description' => 'Aprende a crear aplicaciones web completas desde cero usando React, Node.js, Express y MongoDB. Proyectos reales con despliegue en producción.',
            'level' => 'Intermedio',
            'badge' => 'bestseller',
            'language' => 'Español'
        ],
        [
            'id' => 3,
            'title' => 'Marketing Digital: Estrategias Avanzadas para Redes Sociales',
            'mentor' => 'Laura Martínez',
            'mentor_specialty' => 'Directora de Marketing Digital - Especialista en Growth Hacking',
            'mentor_avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=200&q=80',
            'category' => 'Marketing',
            'category_slug' => 'marketing',
            'price' => 199,
            'original_price' => 299,
            'rating' => 4.7,
            'students' => 1876,
            'reviews' => 423,
            'duration' => '32 horas',
            'lessons' => 16,
            'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=900&q=80',
            'description' => 'Estrategias efectivas para Facebook, Instagram y LinkedIn. Aumenta tu alcance, engagement y conversiones con técnicas probadas de marketing digital.',
            'level' => 'Principiante',
            'badge' => 'new',
            'language' => 'Español'
        ],
        [
            'id' => 4,
            'title' => 'Fotografía Profesional: Técnicas de Iluminación y Composición',
            'mentor' => 'Miguel Ángel Torres',
            'mentor_specialty' => 'Fotógrafo Profesional - Ganador de premios internacionales',
            'mentor_avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80',
            'category' => 'Fotografía',
            'category_slug' => 'fotografia',
            'price' => 0,
            'original_price' => 199,
            'rating' => 4.6,
            'students' => 3120,
            'reviews' => 845,
            'duration' => '28 horas',
            'lessons' => 14,
            'image' => 'https://images.unsplash.com/photo-1542038784456-1ea8e935640e?auto=format&fit=crop&w=900&q=80',
            'description' => 'Aprende técnicas profesionales de iluminación para retratos, productos y fotografía de estudio. Domina la composición y el manejo de cámaras réflex.',
            'level' => 'Intermedio',
            'badge' => 'free',
            'language' => 'Español'
        ],
        [
            'id' => 5,
            'title' => 'Diseño UX/UI con Figma: Del Wireframe al Prototipo Interactivo',
            'mentor' => 'Ana López',
            'mentor_specialty' => 'Diseñadora UX/UI Senior en empresas de tecnología',
            'mentor_avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80',
            'category' => 'Diseño',
            'category_slug' => 'diseno',
            'price' => 349,
            'original_price' => 449,
            'rating' => 4.9,
            'students' => 1567,
            'reviews' => 412,
            'duration' => '45 horas',
            'lessons' => 22,
            'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?auto=format&fit=crop&w=900&q=80',
            'description' => 'Aprende diseño de interfaces profesionales con Figma. Incluye investigación de usuarios, sistemas de diseño y creación de prototipos interactivos.',
            'level' => 'Principiante',
            'badge' => 'popular',
            'language' => 'Español'
        ]
    ]);

    $catalog = $cursos ?? $catalog;

    $categories = [
        ['name' => 'Idiomas', 'count' => 156, 'slug' => 'idiomas'],
        ['name' => 'Programación', 'count' => 234, 'slug' => 'programacion'],
        ['name' => 'Diseño', 'count' => 98, 'slug' => 'diseno'],
        ['name' => 'Marketing', 'count' => 87, 'slug' => 'marketing'],
        ['name' => 'Negocios', 'count' => 65, 'slug' => 'negocios'],
        ['name' => 'Fotografía', 'count' => 42, 'slug' => 'fotografia'],
        ['name' => 'Música', 'count' => 31, 'slug' => 'musica']
    ];

    $priceRanges = [
        ['label' => 'Todos los precios', 'value' => 'all'],
        ['label' => 'Cursos Gratis', 'value' => 'free'],
        ['label' => 'Menos de S/ 100', 'value' => '<100'],
        ['label' => 'S/ 100 - 300', 'value' => '100-300'],
        ['label' => 'S/ 300 - 600', 'value' => '300-600'],
        ['label' => 'Más de S/ 600', 'value' => '>600']
    ];

    $levels = ['Principiante', 'Intermedio', 'Avanzado'];
    
    $totalCursos = $catalog->count();
?>

<?php $__env->startSection('content'); ?>
<div class="courses-page">
    <div class="courses-container">
        <!-- Header del catálogo -->
        <header class="catalog-header animate-fade-in-up">
            <h1>Catálogo de Cursos Premium</h1>
            <p class="catalog-subtitle">
                Descubre <?php echo e($totalCursos); ?> cursos especializados con mentores expertos. 
                Aprende habilidades demandadas y transforma tu carrera profesional.
            </p>
            
            <!-- Búsqueda principal -->
            <div class="search-container" style="max-width: 600px; margin: 0 auto;">
                <div class="search-input-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" 
                           class="search-input" 
                           placeholder="Buscar cursos por nombre, categoría o mentor..."
                           x-model="searchQuery"
                           @input.debounce.300ms="filterCourses()">
                </div>
            </div>
        </header>

        <!-- Layout principal -->
        <div class="courses-layout" x-data="courseCatalog()" x-init="init()">
            <!-- Panel de filtros -->
            <aside class="filters-panel animate-slide-left">
                <div class="filters-header">
                    <h2><i class="fas fa-sliders-h"></i> Filtros</h2>
                    <button type="button" 
                            class="clear-filters"
                            @click="clearFilters()">
                        <i class="fas fa-times"></i> Limpiar
                    </button>
                </div>

                <form @submit.prevent="applyFilters()">
                    <!-- Categorías -->
                    <div class="filter-group">
                        <label>Categorías</label>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="filter-option">
                                <input type="checkbox" 
                                       id="cat-<?php echo e($category['slug']); ?>"
                                       x-model="selectedCategories"
                                       value="<?php echo e($category['slug']); ?>"
                                       @change="filterCourses()">
                                <span class="custom-checkbox"></span>
                                <span class="filter-text"><?php echo e($category['name']); ?></span>
                                <span class="filter-count"><?php echo e($category['count']); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Precio -->
                    <div class="filter-group">
                        <label>Rango de Precio</label>
                        <?php $__currentLoopData = $priceRanges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="filter-option">
                                <input type="radio" 
                                       id="price-<?php echo e($loop->index); ?>"
                                       name="price"
                                       x-model="selectedPrice"
                                       value="<?php echo e($range['value']); ?>"
                                       @change="filterCourses()">
                                <span class="custom-radio"></span>
                                <span class="filter-text"><?php echo e($range['label']); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Nivel -->
                    <div class="filter-group">
                        <label>Nivel de Dificultad</label>
                        <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="filter-option">
                                <input type="checkbox" 
                                       id="level-<?php echo e(Str::slug($level)); ?>"
                                       x-model="selectedLevels"
                                       value="<?php echo e($level); ?>"
                                       @change="filterCourses()">
                                <span class="custom-checkbox"></span>
                                <span class="filter-text"><?php echo e($level); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <button type="button" class="apply-filters" @click="applyFilters()">
                        <i class="fas fa-check-circle"></i>
                        Aplicar Filtros
                    </button>
                </form>
            </aside>

            <!-- Resultados -->
            <section class="courses-results">
                <!-- Topbar de resultados -->
                <div class="results-topbar">
                    <div class="results-info">
                        <h1 x-text="filteredCourses.length + ' cursos encontrados'"></h1>
                        <p class="results-count" x-show="selectedCategories.length > 0 || selectedLevels.length > 0">
                            <span x-show="selectedCategories.length > 0">
                                Categorías: <span x-text="getCategoryNames(selectedCategories)"></span>
                            </span>
                            <span x-show="selectedCategories.length > 0 && selectedLevels.length > 0"> • </span>
                            <span x-show="selectedLevels.length > 0">
                                Nivel: <span x-text="selectedLevels.join(', ')"></span>
                            </span>
                        </p>
                    </div>
                    
                    <div class="results-controls">
                        <select class="sort-select" x-model="sortBy" @change="sortCourses()">
                            <option value="relevance">Relevancia</option>
                            <option value="popular">Más populares</option>
                            <option value="rating">Mejor valorados</option>
                            <option value="price_asc">Precio: menor a mayor</option>
                            <option value="price_desc">Precio: mayor a menor</option>
                            <option value="newest">Más recientes</option>
                        </select>
                    </div>
                </div>

                <!-- Grid de cursos -->
                <div class="courses-grid">
                    <?php $__currentLoopData = $catalog; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $image = $course['image'] ?? ($course->image_url ?? null);
                            if ($course->image_url ?? false) {
                                $image = \Illuminate\Support\Str::startsWith($course->image_url, ['http://', 'https://'])
                                    ? $course->image_url
                                    : asset($course->image_url);
                            }
                            $image ??= 'https://source.unsplash.com/random/800x600/?course,learning';

                            $title = $course['title'] ?? ($course->title ?? 'Curso sin título');
                            $category = $course['category'] ?? ($course->category ?? 'General');
                            $categorySlug = \Illuminate\Support\Str::slug($category);
                            $level = $course['level'] ?? ($course->level ?? 'Intermedio');
                            $description = $course['description'] ?? ($course->description ?? 'Descripción no disponible.');
                            $mentorName = $course['mentor'] ?? ($course->mentor->name ?? 'Mentor');
                            $mentorSpecialty = $course['mentor_specialty'] ?? ($course->mentor->specialty ?? 'Mentor experto');
                            $mentorAvatar = $course['mentor_avatar'] ?? ($course->mentor->avatar_url ?? null);
                            $mentorAvatar = $mentorAvatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($mentorName) . '&background=667eea&color=fff&size=200';

                            $rating = $course['rating'] ?? ($course->rating ?? 4.8);
                            $reviews = $course['reviews'] ?? ($course->reviews ?? 0);
                            $students = $students ?? ($course->students ?? 0);
                            $durationRaw = $course['duration'] ?? ($course->duration ?? null);
                            $duration = is_numeric($durationRaw) ? $durationRaw . ' horas' : ($durationRaw ?: '0 horas');
                            $price = $course['price'] ?? ($course->price ?? 0);
                            $originalPrice = $originalPrice ?? ($course->original_price ?? null);
                            $badge = $course['badge'] ?? ($course->badge ?? 'popular');
                        ?>
                        <article class="course-card" style="--index: <?php echo e($index); ?>">
                            <!-- Imagen y badge -->
                            <div class="course-image-container">
                                <img src="<?php echo e($image); ?>" 
                                     alt="<?php echo e($title); ?>" 
                                     class="course-card__image">
                                <span class="course-badge badge-<?php echo e($badge); ?>">
                                    <?php if($badge == 'popular'): ?>
                                        Popular
                                    <?php elseif($badge == 'new'): ?>
                                        Nuevo
                                    <?php elseif($badge == 'free'): ?>
                                        Gratis
                                    <?php else: ?>
                                        Más Vendido
                                    <?php endif; ?>
                                </span>
                            </div>
                            
                            <!-- Contenido -->
                            <div class="course-content">
                                <!-- Categoría y nivel -->
                                <div class="course-meta-top">
                                    <div class="course-category">
                                        <?php if($categorySlug == 'idiomas'): ?>
                                            <i class="fas fa-language"></i>
                                        <?php elseif($categorySlug == 'programacion'): ?>
                                            <i class="fas fa-code"></i>
                                        <?php elseif($categorySlug == 'diseno'): ?>
                                            <i class="fas fa-palette"></i>
                                        <?php elseif($categorySlug == 'marketing'): ?>
                                            <i class="fas fa-chart-line"></i>
                                        <?php elseif($categorySlug == 'fotografia'): ?>
                                            <i class="fas fa-camera"></i>
                                        <?php else: ?>
                                            <i class="fas fa-graduation-cap"></i>
                                        <?php endif; ?>
                                        <span><?php echo e($category); ?></span>
                                    </div>
                                    <div class="course-level level-<?php echo e(strtolower($level)); ?>">
                                        <?php echo e($level); ?>

                                    </div>
                                </div>
                                
                                <!-- Título -->
                                <h3 class="course-title"><?php echo e($title); ?></h3>
                                
                                <!-- Descripción -->
                                <p class="course-description"><?php echo e($description); ?></p>
                                
                                <!-- Perfil del mentor -->
                                <div class="mentor-profile">
                                    <div class="mentor-avatar">
                                        <img src="<?php echo e($mentorAvatar); ?>" 
                                             alt="<?php echo e($mentorName); ?>"
                                             onerror="this.src='https://ui-avatars.com/api/?name=<?php echo e(urlencode($mentorName)); ?>&background=667eea&color=fff&size=200'">
                                    </div>
                                    <div class="mentor-info">
                                        <div class="mentor-name"><?php echo e($mentorName); ?></div>
                                        <div class="mentor-specialty"><?php echo e($mentorSpecialty); ?></div>
                                    </div>
                                </div>
                                
                                <!-- Estadísticas -->
                                <div class="course-stats">
                                    <div class="stat-item">
                                        <div class="rating-stars">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <i class="<?php echo e($i <= floor($rating) ? 'fas fa-star' : 'far fa-star'); ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <span><?php echo e($rating); ?></span>
                                        <span class="text-gray-400">(<?php echo e($reviews); ?> reseñas)</span>
                                    </div>
                                    <div class="stat-item">
                                        <i class="fas fa-user-graduate"></i>
                                        <?php if($students >= 1000): ?>
                                            <?php echo e(number_format($students / 1000, 1)); ?>K estudiantes
                                        <?php else: ?>
                                            <?php echo e($students); ?> estudiantes
                                        <?php endif; ?>
                                    </div>
                                    <div class="stat-item">
                                        <i class="far fa-clock"></i>
                                        <?php echo e($duration); ?>

                                    </div>
                                </div>
                                
                                <!-- Precio y acciones -->
                                <div class="course-footer">
                                    <div class="course-price <?php echo e($price === 0 ? 'free' : ''); ?>">
                                        <?php if($price > 0): ?>
                                            <div class="flex items-baseline">
                                                <span class="price-currency">S/</span>
                                                <span><?php echo e($price); ?></span>
                                            </div>
                                        <?php else: ?>
                                            <span class="font-bold">Gratis</span>
                                        <?php endif; ?>
                                        <?php if($originalPrice && $originalPrice > $price): ?>
                                            <span class="ml-2 text-sm text-gray-500 line-through">
                                                S/ <?php echo e($originalPrice); ?>

                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="course-actions">
                                        <a href="<?php echo e(route('cursos.show', $course->id)); ?>" 
                                           class="btn-view">
                                            <i class="far fa-eye"></i>
                                            Ver Curso
                                        </a>
                                        <button type="button" 
                                                class="btn-enroll"
                                                onclick="enrollCourse(<?php echo e($course->id); ?>, '<?php echo e($title); ?>')">
                                            <i class="fas fa-shopping-cart"></i>
                                            Inscribirme
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Paginación -->
                <div class="pagination-container">
                    <button type="button" class="pagination-btn" disabled>
                        <i class="fas fa-chevron-left"></i>
                        Anterior
                    </button>
                    
                    <div class="flex items-center gap-2">
                        <button type="button" class="page-number active">1</button>
                        <button type="button" class="page-number">2</button>
                        <span class="text-gray-400">...</span>
                        <button type="button" class="page-number">5</button>
                    </div>
                    
                    <button type="button" class="pagination-btn">
                        Siguiente
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
    function enrollCourse(courseId, courseTitle) {
        // Simulación de inscripción
        const notification = document.createElement('div');
        notification.className = 'fixed top-6 right-6 z-50 bg-white rounded-xl shadow-2xl p-4 max-w-sm border-l-4 border-green-500 transform transition-all duration-300 translate-x-full';
        
        notification.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h4 class="font-bold text-gray-900">🎉 ¡Inscripción exitosa!</h4>
                    <p class="mt-1 text-sm text-gray-600">Te has inscrito en: "${courseTitle}"</p>
                </div>
                <button onclick="this.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animar entrada
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
            notification.classList.add('translate-x-0');
        }, 10);
        
        // Auto-remover después de 5 segundos
        setTimeout(() => {
            notification.classList.remove('translate-x-0');
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }

    // Alpine.js para filtros
    function courseCatalog() {
        return {
            searchQuery: '',
            selectedCategories: [],
            selectedPrice: 'all',
            selectedLevels: [],
            sortBy: 'relevance',
            
            getCategoryNames(slugs) {
                const categoryMap = {
                    'idiomas': 'Idiomas',
                    'programacion': 'Programación',
                    'diseno': 'Diseño',
                    'marketing': 'Marketing',
                    'negocios': 'Negocios',
                    'fotografia': 'Fotografía',
                    'musica': 'Música'
                };
                
                return slugs.map(slug => categoryMap[slug] || slug).join(', ');
            },
            
            clearFilters() {
                this.searchQuery = '';
                this.selectedCategories = [];
                this.selectedPrice = 'all';
                this.selectedLevels = [];
            },
            
            applyFilters() {
                // Los filtros ya funcionan con Alpine.js
            }
        };
    }
</script>
<?php $__env->stopSection(); ?>










<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\NADHIRA\Downloads\SkillNest\resources\views/cursos/index.blade.php ENDPATH**/ ?>