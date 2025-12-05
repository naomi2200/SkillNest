<style>
    .footer-modern {
        background: linear-gradient(180deg, #1f2937 0%, #0b1220 100%);
        color: #d1d5db;
    }
    .footer-modern .footer-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 80px 24px 32px;
    }
    .footer-modern .footer-top {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 48px;
        margin-bottom: 48px;
    }
    .footer-modern .footer-column {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .footer-modern .footer-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 24px;
        font-weight: 700;
    }
    .footer-modern .footer-logo .logo-text {
        background: linear-gradient(135deg, #a78bfa 0%, #c4b5fd 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .footer-modern .footer-description {
        color: #9ca3af;
        line-height: 1.7;
        margin: 0;
    }
    .footer-modern .footer-social {
        display: flex;
        gap: 12px;
    }
    .footer-modern .social-link {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: #d1d5db;
        transition: all 0.3s ease;
    }
    .footer-modern .social-link:hover {
        background: linear-gradient(135deg, #6c47ff, #8b5cf6);
        color: #fff;
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(108,71,255,0.3);
    }
    .footer-modern .footer-title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #fff;
    }
    .footer-modern .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .footer-modern .footer-links a {
        color: #9ca3af;
        text-decoration: none;
        transition: color 0.2s ease, transform 0.2s ease;
    }
    .footer-modern .footer-links a:hover {
        color: #a78bfa;
        transform: translateX(4px);
    }
    .footer-modern .footer-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        margin: 32px 0;
    }
    .footer-modern .footer-bottom {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        font-size: 0.9rem;
        color: #9ca3af;
    }
    .footer-modern .footer-legal {
        display: flex;
        gap: 20px;
    }
    .footer-modern .footer-legal a {
        color: #9ca3af;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .footer-modern .footer-legal a:hover {
        color: #a78bfa;
    }
    @media (max-width: 1024px) {
        .footer-modern .footer-top {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 768px) {
        .footer-modern .footer-top {
            grid-template-columns: 1fr;
        }
    }
</style>
<footer class="footer-modern">
    <div class="footer-container">
        <div class="footer-top">
            <div class="footer-column">
                <div class="footer-logo">
                    <span class="logo-icon">&#127891;</span>
                    <span class="logo-text">SkillNest</span>
                </div>
                <p class="footer-description">
                    La plataforma educativa donde expertos comparten conocimiento y estudiantes alcanzan sus metas profesionales.
                </p>
                <div class="footer-social">
                    <a href="#" class="social-link" aria-label="Facebook">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073C24 5.446 18.627 0 12 0S0 5.446 0 12.073c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078V12.07h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953h-1.513c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="social-link" aria-label="Twitter">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775A4.958 4.958 0 0023.163 2.6a9.864 9.864 0 01-3.127 1.184 4.92 4.92 0 00-8.384 4.482A13.978 13.978 0 011.671 3.149a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06c0 2.386 1.693 4.374 3.946 4.827a4.996 4.996 0 01-2.212.085c.624 1.956 2.444 3.379 4.6 3.42A9.869 9.869 0 010 19.54a13.94 13.94 0 007.548 2.213c9.055 0 14.009-7.496 14.009-13.986 0-.21-.005-.423-.014-.634A10.012 10.012 0 0024 4.59z"/></svg>
                    </a>
                    <a href="#" class="social-link" aria-label="LinkedIn">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.047c.476-.9 1.637-1.85 3.37-1.85 3.601 0 4.266 2.37 4.266 5.455v6.286zM5.337 7.433A2.062 2.062 0 113.275 5.37a2.062 2.062 0 012.062 2.063zM6.813 20.452H3.861V9h2.952v11.452z"/></svg>
                    </a>
                    <a href="#" class="social-link" aria-label="Instagram">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.2c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.918 4.918.058 1.266.07 1.645.07 4.85s-.012 3.584-.07 4.85c-.147 3.225-1.664 4.771-4.918 4.918-1.266.058-1.645.07-4.85.07s-3.584-.012-4.85-.07c-3.225-.147-4.771-1.664-4.918-4.918-.058-1.266-.07-1.645-.07-4.85s.012-3.584.07-4.85C2.379 3.961 3.896 2.415 7.12 2.268 8.387 2.21 8.766 2.2 12 2.2zm0 1.8c-3.158 0-3.522.012-4.766.069-2.562.117-3.75 1.305-3.867 3.867-.057 1.244-.067 1.608-.067 4.766s.01 3.522.067 4.766c.117 2.557 1.3 3.75 3.867 3.867 1.244.057 1.608.069 4.766.069s3.522-.012 4.766-.069c2.557-.117 3.75-1.305 3.867-3.867.057-1.244.069-1.608.069-4.766s-.012-3.522-.069-4.766c-.117-2.557-1.305-3.75-3.867-3.867C15.522 4.012 15.158 4 12 4zm0 3.067a4.933 4.933 0 110 9.866 4.933 4.933 0 010-9.866zm6.267-2.2a1.067 1.067 0 11-1.067 1.067 1.067 1.067 0 011.067-1.067z"/></svg>
                    </a>
                </div>
            </div>
            <div class="footer-column">
                <h3 class="footer-title">Plataforma</h3>
                <ul class="footer-links">
                    <li><a href="<?php echo e(url('/cursos')); ?>">Explorar cursos</a></li>
                    <li><a href="<?php echo e(url('/mentor-market')); ?>">Buscar mentores</a></li>
                    <li><a href="<?php echo e(url('/mentorias/create')); ?>">Convi&eacute;rtete en mentor</a></li>
                    <li><a href="#">C&oacute;mo funciona</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3 class="footer-title">Recursos</h3>
                <ul class="footer-links">
                    <li><a href="#">Centro de ayuda</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Gu&iacute;as</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3 class="footer-title">Empresa</h3>
                <ul class="footer-links">
                    <li><a href="#">Sobre nosotros</a></li>
                    <li><a href="#">Contacto</a></li>
                    <li><a href="#">Trabaja con nosotros</a></li>
                    <li><a href="#">Prensa</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-divider"></div>
        <div class="footer-bottom">
            <p>&copy; <?php echo e(now()->year); ?> SkillNest. Todos los derechos reservados.</p>
            <div class="footer-legal">
                <a href="#">T&eacute;rminos</a>
                <a href="#">Privacidad</a>
                <a href="#">Soporte</a>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/partials/footer.blade.php ENDPATH**/ ?>