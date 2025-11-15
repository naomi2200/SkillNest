<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        $cursos = Curso::with('mentor')->latest()->get();

        if ($request->expectsJson()) {
            return response()->json($cursos);
        }

        return view('cursos.index', compact('cursos'));
    }

    public function create()
    {
        return view('cursos.create');
    }

    public function store(Request $request)
    {
        try {
            Log::info('Datos recibidos para crear curso:', $request->all());

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'duration' => 'required|integer|min:1',
                'level' => 'required|string|in:principiante,intermedio,avanzado',
                'category' => 'required|string|max:255',
                'status' => 'nullable|string|max:50',
            ]);

            $mentor = $request->user();

            if (!$mentor) {
                $mentor = User::first();
            }

            if (!$mentor) {
                $mentor = User::create([
                    'name' => 'Mentor Principal',
                    'email' => 'mentor@skillnest.com',
                    'password' => bcrypt('password123'),
                    'role' => 'mentor',
                ]);
            }

            $curso = Curso::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'duration' => $validated['duration'],
                'level' => $validated['level'],
                'category' => $validated['category'],
                'mentor_id' => $mentor->id,
                'status' => $validated['status'] ?? 'borrador',
                'image_url' => $request->input('image_url'),
                'objectives' => $request->input('objectives'),
                'requirements' => $request->input('requirements'),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Curso creado exitosamente',
                    'course' => $curso,
                ], 201);
            }

            return redirect()
                ->route('cursos.show', $curso)
                ->with('status', 'Curso creado exitosamente');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors(),
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creando curso: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error del servidor: ' . $e->getMessage(),
                ], 500);
            }

            return back()->withErrors(['general' => 'Error interno al crear el curso'])->withInput();
        }
    }

    public function show(Curso $curso)
    {
        return view('cursos.show', compact('curso'));
    }

    public function edit(Curso $curso)
    {
        return view('cursos.edit', compact('curso'));
    }

    public function update(Request $request, Curso $curso)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'duration' => 'required|integer|min:1',
                'level' => 'required|string|in:principiante,intermedio,avanzado',
                'category' => 'required|string|max:255',
                'status' => 'required|string',
            ]);

            $curso->update($validated + [
                'image_url' => $request->input('image_url'),
                'objectives' => $request->input('objectives'),
                'requirements' => $request->input('requirements'),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Curso actualizado',
                    'course' => $curso,
                ]);
            }

            return redirect()
                ->route('cursos.edit', $curso)
                ->with('status', 'Curso actualizado correctamente');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors(),
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function destroy(Request $request, Curso $curso)
    {
        $curso->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Curso eliminado',
            ]);
        }

        return redirect()
            ->route('cursos.index')
            ->with('status', 'Curso eliminado correctamente');
    }

    public function enroll(Request $request, Curso $curso)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Debes iniciar sesión para inscribirte.']);
        }

        $curso->estudiantes()->syncWithoutDetaching([$user->id]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Estudiante inscrito correctamente',
            ]);
        }

        return redirect()
            ->route('student.courses')
            ->with('status', 'Te inscribiste en el curso correctamente.');
    }
}
