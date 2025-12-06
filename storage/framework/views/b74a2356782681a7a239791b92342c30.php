<nav x-data="{ scrolled: false, mobileMenuOpen: false }"
     @scroll.window="scrolled = window.pageYOffset > 10"
     :class="scrolled ? 'glass-effect shadow-soft py-4' : 'bg-transparent py-6'"
     class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a href="<?php echo e(url('/')); ?>" class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-lg gradient-primary flex items-center justify-center shadow-soft">
                    <div class="w-8 h-8 rounded-md bg-white flex items-center justify-center">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"
                                  fill="url(#logoGradient)"/>
                            <defs>
                                <linearGradient id="logoGradient" x1="2" y1="2" x2="22" y2="21" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#667eea"/>
                                    <stop offset="1" stop-color="#764ba2"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
                <div>
                    <span class="font-poppins text-2xl font-bold gradient-text">SkillNest</span>
                    <span class="block text-xs text-gray-500 font-medium">PLATAFORMA EDUCATIVA</span>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="<?php echo e(url('/cursos')); ?>" class="nav-link">
                    <i class="fas fa-graduation-cap mr-2"></i>Cursos
                </a>
                <a href="<?php echo e(route('mentor-market.index')); ?>" class="nav-link">
                    <i class="fas fa-users mr-2"></i>Mentorías
                </a>
                <a href="<?php echo e(url('/mentorias/create')); ?>" class="nav-link">
                    <i class="fas fa-chalkboard-teacher mr-2"></i>Ser Mentor
                </a>
                <a href="<?php echo e(route('home')); ?>" class="nav-link">
                    <i class="fas fa-briefcase mr-2"></i>Empresas
                </a>
            </div>

            <!-- Auth & CTA -->
            <div class="hidden lg:flex items-center space-x-4">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="text-gray-600 hover:text-purple-600 font-medium transition-colors">
                        <i class="fas fa-tachometer-alt mr-2"></i>Panel
                    </a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-primary flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i>Salir
                        </button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="text-gray-600 hover:text-purple-600 font-medium transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i>Ingresar
                    </a>
                    <a href="<?php echo e(route('register')); ?>" class="btn-primary flex items-center">
                        <i class="fas fa-user-plus mr-2"></i>Crear Cuenta
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile menu button -->
            <div class="lg:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="text-gray-700 hover:text-purple-600 p-2">
                    <i class="fas fa-bars text-xl" x-show="!mobileMenuOpen"></i>
                    <i class="fas fa-times text-xl" x-show="mobileMenuOpen"></i>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="lg:hidden mt-4 glass-effect rounded-xl shadow-soft p-4"
             x-cloak>
            <div class="flex flex-col space-y-3">
                <a href="<?php echo e(url('/cursos')); ?>" class="flex items-center text-gray-700 hover:text-purple-600 py-2 px-3 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-graduation-cap mr-3"></i>Cursos
                </a>
                <a href="<?php echo e(route('mentor-market.index')); ?>" class="flex items-center text-gray-700 hover:text-purple-600 py-2 px-3 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-users mr-3"></i>Mentorías
                </a>
                <a href="<?php echo e(url('/mentorias/create')); ?>" class="flex items-center text-gray-700 hover:text-purple-600 py-2 px-3 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-chalkboard-teacher mr-3"></i>Ser Mentor
                </a>
                <a href="<?php echo e(route('home')); ?>" class="flex items-center text-gray-700 hover:text-purple-600 py-2 px-3 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-briefcase mr-3"></i>Empresas
                </a>
                <div class="pt-3 border-t border-gray-200 space-y-3">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center text-gray-700 hover:text-purple-600 py-2 px-3 rounded-lg hover:bg-gray-50">
                            <i class="fas fa-tachometer-alt mr-3"></i>Panel
                        </a>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full btn-primary text-center">
                                <i class="fas fa-sign-out-alt mr-2"></i>Salir
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="flex items-center text-gray-700 hover:text-purple-600 py-2 px-3 rounded-lg hover:bg-gray-50">
                            <i class="fas fa-sign-in-alt mr-3"></i>Ingresar
                        </a>
                        <a href="<?php echo e(route('register')); ?>" class="btn-primary text-center flex items-center justify-center">
                            <i class="fas fa-user-plus mr-2"></i>Crear Cuenta
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH C:\Users\NADHIRA\Downloads\SkillNest\resources\views/components/navbar.blade.php ENDPATH**/ ?>