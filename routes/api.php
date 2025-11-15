<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MentoriaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 🔹 Rutas públicas de autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login'); // ✅ SOLO UNA vez con name

// 🔹 Rutas de recuperación de contraseña
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])
    ->name('password.reset');

// 🔹 Ruta de prueba
Route::get('/test', function () {
    return response()->json(['message' => 'El backend funciona correctamente']);
});

// 🔹 Rutas públicas para cursos y mentorías
Route::get('/cursos', [CursoController::class, 'index']);
Route::get('/cursos/{id}', [CursoController::class, 'show']);
Route::post('/cursos', [CursoController::class, 'store']); // ✅ MOVIDO fuera del middleware auth
Route::get('/mentorias', [MentoriaController::class, 'index']);
Route::get('/mentorias/{id}', [MentoriaController::class, 'show']);

// 🔹 Rutas protegidas con Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/user', function (Request $request) {
        return response()->json([
            'user' => [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'role' => $request->user()->role,
            ]
        ]);
    });

    // 🔹 Rutas del dashboard del mentor
    Route::get('/mentor/courses', [CursoController::class, 'getMentorCourses']);
    Route::get('/mentor/mentorships', [MentoriaController::class, 'getMentorMentorships']);
    Route::get('/mentor/sessions/pending', [MentoriaController::class, 'getPendingSessions']);
    Route::put('/mentor/sessions/{id}/status', [MentoriaController::class, 'updateSessionStatus']);

    // 🔹 Recursos protegidos (excepto store que ya está público)
    Route::apiResource('cursos', CursoController::class)->except(['index', 'show', 'store']);
    Route::apiResource('mentorias', MentoriaController::class)->except(['index', 'show']);
});