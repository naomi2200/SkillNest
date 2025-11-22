<?php

// use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CourseReviewController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseEditorController;
use App\Http\Controllers\CourseProgressController;
use App\Http\Controllers\CoursePurchaseController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MentorPublicController;
use App\Http\Controllers\MentoriaBookingController;
use App\Http\Controllers\MentoriaController;
use App\Http\Controllers\Mentor\CourseBuilderController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\StudentDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('home'))->name('home');

// Catálogo público de mentorías y perfil del mentor (acceso libre)
Route::get('/mentorias', [MentorPublicController::class, 'index'])->name('mentor-market.index');
Route::get('/mentorias/mentor/{mentor}', [MentorPublicController::class, 'show'])->name('mentor.public.show');
Route::get('/mentorias/mentor/{mentor}/agendar', [MentorPublicController::class, 'agendar'])->name('mentor.book.form');

// Flujo de autenticación (login, registro, logout, recuperación)
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/forgot-password', 'showForgotForm')->name('password.request');
});

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

// Route::prefix('admin')->name('admin.')->group(function () {
//     Route::middleware('guest:admin')->group(function () {
//         Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
//         Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
//     });
//
//     Route::middleware('auth:admin')->group(function () {
//         Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
//         Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
//
//         Route::get('/courses/review', [CourseReviewController::class, 'index'])->name('courses.review');
//         Route::post('/courses/{course}/approve', [CourseReviewController::class, 'approve'])->name('courses.approve');
//         Route::post('/courses/{course}/reject', [CourseReviewController::class, 'reject'])->name('courses.reject');
//     });
// });

// Todo lo que sigue requiere sesión activa
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD principal de cursos y progreso (Laravel resource)
    Route::post('/cursos/draft', [CursoController::class, 'createDraft'])->name('cursos.create-draft');
    Route::get('/cursos/{curso}/editor', [CursoController::class, 'editor'])->name('cursos.editor');
    Route::post('/cursos/{curso}/send-to-review', [CursoController::class, 'sendToReview'])->name('cursos.send-to-review');
    Route::put('/cursos/{curso}/basics', [CourseEditorController::class, 'updateBasics'])->name('cursos.update-basics');
    Route::post('/cursos/{curso}/image', [CourseEditorController::class, 'updateImage'])->name('cursos.update-image');
    Route::post('/cursos/{curso}/modules', [CourseEditorController::class, 'addModule'])->name('cursos.modules.store');
    Route::put('/modules/{module}', [CourseEditorController::class, 'updateModule'])->name('modules.update');
    Route::delete('/modules/{module}', [CourseEditorController::class, 'deleteModule'])->name('modules.destroy');
    Route::post('/modules/{module}/lessons', [CourseEditorController::class, 'addLesson'])->name('modules.lessons.store');
    Route::put('/lessons/{lesson}', [CourseEditorController::class, 'updateLesson'])->name('lessons.update');
    Route::delete('/lessons/{lesson}', [CourseEditorController::class, 'deleteLesson'])->name('lessons.destroy');
    Route::put('/cursos/{curso}/order', [CourseEditorController::class, 'reorder'])->name('cursos.order');

    Route::resource('cursos', CursoController::class);
    Route::post('/cursos/{curso}/enroll', [CursoController::class, 'enroll'])->name('cursos.enroll');
    Route::get('/courses/{course}/checkout', [CoursePurchaseController::class, 'create'])->name('courses.checkout');
    Route::post('/courses/{course}/purchase', [CoursePurchaseController::class, 'store'])->name('courses.purchase');
    Route::get('/courses/{course}/classroom', [CourseProgressController::class, 'classroom'])->name('courses.classroom');
    Route::post('/lessons/{lesson}/progress', [CourseProgressController::class, 'storeLessonProgress'])->name('lessons.progress');
    Route::post('/modules/{module}/unlock', [CourseProgressController::class, 'unlockModule'])->name('modules.unlock');

    // CRUD interno para mentorías dentro del dashboard (usa resource completo)
    Route::prefix('dashboard')->group(function () {
        Route::resource('mentorias', MentoriaController::class);
    });
    Route::get('/mentorias/{mentoria}/join', [MentoriaController::class, 'join'])->name('mentorias.join');

    // Acciones exclusivas de estudiantes (reservar y pagar mentorías)
    Route::middleware('student')->group(function () {
        Route::post('/mentorias/mentor/{mentor}/book', [MentoriaBookingController::class, 'store'])->name('mentor-market.book');
        Route::get('/mentorias/{mentoria}/pago', [PaymentController::class, 'show'])->name('mentorias.payment.show');
        Route::post('/mentorias/{mentoria}/pago', [PaymentController::class, 'store'])->name('mentorias.payment.store');
    });

    // Dashboard del estudiante (métricas, cursos y mentorías)
    Route::prefix('student')
        ->name('student.')
        ->middleware('student')
        ->group(function () {
            Route::get('/', [StudentDashboardController::class, 'index'])->name('dashboard');
            Route::get('/cursos', [StudentDashboardController::class, 'cursos'])->name('courses');
            Route::get('/mentorias', [StudentDashboardController::class, 'mentorias'])->name('mentorias');
            Route::get('/perfil', [StudentDashboardController::class, 'perfil'])->name('profile');
            Route::put('/perfil', [StudentProfileController::class, 'update'])->name('profile.update');
        });

    // Zona privada del mentor (cursos, mentorías y perfil)
    Route::prefix('mentor')->name('mentor.')->middleware('mentor')->group(function () {
        Route::get('/courses', [MentorController::class, 'courseStats'])->name('courses');
        Route::get('/courses/create', [CourseBuilderController::class, 'create'])->name('courses.create');
        Route::post('/courses', [CourseBuilderController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}/builder', [CourseBuilderController::class, 'edit'])->name('courses.builder');
        Route::put('/courses/{course}', [CourseBuilderController::class, 'update'])->name('courses.update');
        Route::post('/courses/{course}/structure', [CourseBuilderController::class, 'syncStructure'])->name('courses.structure');
        Route::post('/courses/{course}/submit', [CourseBuilderController::class, 'submitForReview'])->name('courses.submit');

        Route::get('/mentorias', [MentorController::class, 'mentorships'])->name('mentorias.index');
        Route::get('/mentorias/{mentoria}/edit', [MentoriaController::class, 'edit'])->name('mentorias.edit');
        Route::put('/mentorias/{mentoria}', [MentoriaController::class, 'update'])->name('mentorias.update');
        Route::delete('/mentorias/{mentoria}', [MentoriaController::class, 'destroy'])->name('mentorias.destroy');
        Route::post('/mentorias/{mentoria}/publicar', [MentoriaController::class, 'publicar'])->name('mentorias.publicar');
        Route::post('/mentorias/{mentoria}/aceptar', [MentoriaController::class, 'aceptar'])->name('mentorias.accept');
        Route::post('/mentorias/{mentoria}/rechazar', [MentoriaController::class, 'rechazar'])->name('mentorias.reject');
        Route::post('/mentorias/{mentoria}/completar', [MentoriaController::class, 'completar'])->name('mentorias.completar');

        Route::get('/profile', [MentorController::class, 'editProfile'])->name('profile');
        Route::post('/profile', [MentorController::class, 'updateProfile'])->name('profile.update');

        Route::get('/students', [MentorController::class, 'myStudents'])->name('students');
    });

    Route::middleware('admin')
        ->prefix('admin/courses')
        ->name('admin.courses.')
        ->group(function () {
            Route::get('/', [CourseReviewController::class, 'index'])->name('index');
            Route::get('/{id}', [CourseReviewController::class, 'show'])->name('show');
            Route::patch('/{id}/approve', [CourseReviewController::class, 'approve'])->name('approve');
            Route::patch('/{id}/reject', [CourseReviewController::class, 'reject'])->name('reject');
            Route::patch('/{id}/reset', [CourseReviewController::class, 'resetReview'])->name('reset');
            Route::delete('/{id}', [CourseReviewController::class, 'destroy'])->name('destroy');
        });
});
