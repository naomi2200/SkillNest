<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CourseSubmitted;
use Illuminate\Support\Str;
use App\Notifications\CoursePublished;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        $query = Curso::with('mentor')
            ->where('status', 'approved');

        $categoryIds = array_filter((array) $request->input('categories', []));
        if (!empty($categoryIds)) {
            $query->whereIn('category_id', $categoryIds);
        }

        $levels = array_filter((array) $request->input('levels', []));
        if (!empty($levels)) {
            $query->whereIn('level', $levels);
        }

        $range = $request->input('price_range');
        if ($range) {
            $query->when($range === 'free', fn ($q) => $q->where('price', 0))
                ->when($range === '<100', fn ($q) => $q->whereBetween('price', [0.01, 99.99]))
                ->when($range === '100-300', fn ($q) => $q->whereBetween('price', [100, 300]))
                ->when($range === '300-600', fn ($q) => $q->whereBetween('price', [300, 600]))
                ->when($range === '>600', fn ($q) => $q->where('price', '>', 600));
        }

        $cursos = $query->latest()->get();
        $categories = Curso::where('status', 'approved')
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        if ($request->expectsJson()) {
            return response()->json($cursos);
        }

        return view('cursos.index', [
            'cursos' => $cursos,
            'catalog' => $cursos,
            'categories' => $categories,
        ]);
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

            $image = $request->input('image_url') ?: sprintf(
                'https://picsum.photos/seed/%s/800/600',
                Str::uuid()
            );

            $curso = Curso::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'duration' => $validated['duration'],
                'level' => $validated['level'],
                'category' => $validated['category'],
                'mentor_id' => $mentor->id,
                'status' => $validated['status'] ?? 'borrador',
                'image_url' => $image,
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
                    'message' => 'Error de validaciÃ³n',
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
        return redirect()->route('cursos.editor', $curso);
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
                    'message' => 'Error de validaciÃ³n',
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
            return redirect()->route('login')->withErrors(['email' => 'Debes iniciar sesiÃ³n para inscribirte.']);
        }

        $hasPaid = $curso->purchases()
            ->where('student_id', $user->id)
            ->where('status', 'paid')
            ->exists();

        if (! $hasPaid && ! $curso->isOwnedBy($user)) {
            return redirect()->route('courses.checkout', $curso)
                ->withErrors(['payment' => 'Debes completar el pago antes de inscribirte.']);
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

    public function createDraft(Request $request)
    {
        $mentor = $request->user();
        abort_unless($mentor && method_exists($mentor, 'isMentor') && $mentor->isMentor(), 403);

        $image = sprintf('https://picsum.photos/seed/%s/800/600', Str::uuid());

        $curso = Curso::create([
            'mentor_id' => $mentor->id,
            'title' => 'Curso sin tÃ­tulo',
            'description' => 'AÃ±ade una descripciÃ³n atractiva a tu curso.',
            'price' => 0,
            'duration' => 1,
            'level' => 'principiante',
            'category' => 'General',
            'status' => 'borrador',
            'image_url' => $image,
            'objectives' => null,
            'requirements' => null,
        ]);

        return redirect()->route('mentor.courses.builder', $curso);
    }

    public function editor(Request $request, Curso $curso)
    {
        $this->authorizeCourseMentor($request->user(), $curso);

        $curso->load(['modules.lessons']);

        return view('cursos.editor', compact('curso'));
    }

    public function sendToReview(Request $request, Curso $curso)
    {
        $this->authorizeCourseMentor($request->user(), $curso);
 
        $basicFields = [
            $curso->title,
            $curso->description,
            $curso->category,
            $curso->level,
        ];
        if (in_array(null, $basicFields, true) || in_array('', $basicFields, true) || $curso->price <= 0 || $curso->duration <= 0) {
            return back()->withErrors('Completa los datos básicos del curso antes de enviarlo a revisión.');
        }
 
        $modulesCount = $curso->modules()->count();
        $lessonsCount = $curso->modules()->withCount('lessons')->get()->sum('lessons_count');
        if ($modulesCount === 0 || $lessonsCount === 0) {
            return back()->withErrors('Agrega al menos un módulo y una lección antes de enviarlo a revisión.');
        }
 
        if (in_array($curso->review_status, ['pending', 'submitted'], true)) {
            return back()->with('status', 'El curso ya fue enviado a revisión.');
        }

        $curso->update([
            'review_status' => 'pending',
            'status' => 'pendiente',
            'published_at' => null,
        ]);
 
        $admins = User::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new CourseSubmitted($curso));
        }
 
        return redirect()
            ->route('cursos.editor', $curso)
            ->with('status', 'Curso enviado a revisión.');
    }

    public function publish(Request $request, Curso $curso)
    {
        $this->authorizeCourseMentor($request->user(), $curso);

        if ($curso->status !== 'aprobado') {
            return back()->withErrors('Solo puedes publicar cursos aprobados por el administrador.');
        }

        $curso->update([
            'status' => 'publicado',
            'published_at' => now(),
            'review_status' => 'approved',
        ]);

        $admins = User::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new CoursePublished($curso));
        }

        return back()->with('status', 'Curso publicado correctamente.');
    }

    // CAMBIO INICIO
    /**
     * API: devuelve los cursos del mentor autenticado con relaciones básicas.
     */
    public function getMentorCourses(Request $request)
    {
        $mentor = $request->user();
        abort_unless($mentor && method_exists($mentor, 'isMentor') && $mentor->isMentor(), 403);

        $courses = Curso::withCount(['modules', 'lessons'])
            ->with('mentor')
            ->where('mentor_id', $mentor->id)
            ->latest('updated_at')
            ->get();

        return response()->json([
            'courses' => $courses,
        ]);
    }
    // CAMBIO FIN

    protected function authorizeCourseMentor(?User $user, Curso $curso): void
    {
        if ($user && method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return;
        }

        abort_unless(
            $user && method_exists($user, 'isMentor') && $user->isMentor() && $curso->mentor_id === $user->id,
            403
        );
    }
}



