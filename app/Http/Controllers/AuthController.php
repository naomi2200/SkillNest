<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function register(Request $request)
    {
        if (!$request->expectsJson()) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'confirmed', Password::defaults()],
                'role' => 'required|in:student,mentor',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            Auth::login($user);

            return redirect()
                ->route($user->role === 'mentor' ? 'mentor.students' : 'dashboard')
                ->with('status', 'Cuenta creada correctamente.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|in:student,mentor',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            Log::info('=== REGISTRO DE NUEVO USUARIO ===');
            Log::info('Nombre: ' . $request->name);
            Log::info('Email: ' . $request->email);
            Log::info('Rol: ' . $request->role);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            Log::info('Usuario creado ID: ' . $user->id);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Usuario registrado exitosamente',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
                'token' => $token
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error al registrar usuario: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        if (!$request->expectsJson()) {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                $user = Auth::user();

                $redirectRoute = match ($user->role) {
                    'mentor' => route('mentor.students'),
                    'admin' => route('admin.dashboard'),
                    default => route('dashboard'),
                };

                return redirect()
                    ->intended($redirectRoute)
                    ->with('status', 'Bienvenido de nuevo, ' . $user->name);
            }

            return back()->withErrors([
                'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ])->onlyInput('email');
        }

        Log::info('=== INTENTO DE LOGIN API ===');
        Log::info('Email recibido: ' . $request->email);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Log::error('Usuario no encontrado: ' . $request->email);
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            Log::error('Contraseña incorrecta para: ' . $user->email);
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        Log::info('Login exitoso para: ' . $user->email);

        $token = $user->createToken('auth_token')->plainTextToken;

        $redirectTo = match ($user->role) {
            'mentor' => '/mentor-dashboard',
            'admin' => '/admin/dashboard',
            default => '/dashboard',
        };

        return response()->json([
            'message' => 'Login exitoso',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'token' => $token,
            'redirect_to' => $redirectTo
        ]);
    }

    public function logout(Request $request)
    {
        if (!$request->expectsJson()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('status', 'Sesión cerrada correctamente.');
        }

        $user = $request->user();
        Log::info('Logout API: ' . $user->email);

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return response()->json([
            'message' => 'Sesi��n cerrada exitosamente'
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        Log::info('Solicitud de recuperación: ' . $request->email);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Log::error('Usuario no encontrado para recuperaci��n: ' . $request->email);
            return response()->json([
                'message' => 'Si el email existe, te enviaremos un enlace de recuperación'
            ]);
        }

        Log::info('Enlace de recuperación enviado a: ' . $user->email);

        return response()->json([
            'message' => 'Si el email existe, te enviaremos un enlace de recuperación'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'token' => 'required'
        ]);

        Log::info('Restablecimiento de contraseña para: ' . $request->email);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Log::error('Usuario no encontrado para restablecer: ' . $request->email);
            return response()->json([
                'message' => 'Error al restablecer la contraseña'
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        Log::info('Contraseña actualizada para: ' . $user->email);

        return response()->json([
            'message' => 'Contraseña restablecida exitosamente'
        ]);
    }

    public function getUser(Request $request)
    {
        $user = $request->user();

        Log::info('Datos de usuario solicitados: ' . $user->email);

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ]);
    }
}
