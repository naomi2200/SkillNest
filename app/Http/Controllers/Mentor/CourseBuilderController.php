<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Controlador legacy: redirige todas las rutas del builder antiguo
 * hacia el editor principal para evitar flujos duplicados.
 */
class CourseBuilderController extends Controller
{
    public function create()
    {
        $mentor = $this->authorizeMentor();
        $curso = $this->createDraftForMentor($mentor);

        return redirect()
            ->route('cursos.editor', $curso)
            ->with('status', 'Usa el editor principal para continuar.');
    }

    public function store(Request $request)
    {
        $mentor = $this->authorizeMentor();
        $curso = $this->createDraftForMentor($mentor);

        return redirect()
            ->route('cursos.editor', $curso)
            ->with('status', 'Curso creado. Usa el editor principal para continuar.');
    }

    public function edit(Curso $course)
    {
        $this->authorizeMentor($course);

        return redirect()
            ->route('cursos.editor', $course)
            ->with('status', 'Usa el editor principal para editar este curso.');
    }

    public function update(Request $request, Curso $course)
    {
        $this->authorizeMentor($course);

        return redirect()
            ->route('cursos.editor', $course)
            ->with('status', 'Usa el editor principal para actualizar este curso.');
    }

    public function syncStructure(Request $request, Curso $course)
    {
        $this->authorizeMentor($course);

        return response()->json([
            'status' => 'redirect',
            'redirect_to' => route('cursos.editor', $course),
            'message' => 'Usa el editor principal para gestionar la estructura.',
        ]);
    }

    public function submitForReview(Curso $course)
    {
        $this->authorizeMentor($course);

        return redirect()
            ->route('cursos.editor', $course)
            ->with('status', 'Envia a revision desde el editor principal.');
    }

    protected function authorizeMentor(?Curso $course = null)
    {
        $user = auth()->user();

        abort_unless($user && $user->isMentor(), 403);

        if ($course) {
            abort_unless($course->mentor_id === $user->id, 403);
        }

        return $user;
    }

    protected function createDraftForMentor($mentor): Curso
    {
        return Curso::create([
            'mentor_id' => $mentor->id,
            'title' => 'Curso sin titulo',
            'description' => 'Agrega una descripcion atractiva a tu curso.',
            'price' => 0,
            'duration' => 1,
            'level' => 'principiante',
            'category' => 'General',
            'status' => 'borrador',
            'review_status' => 'draft',
            'image_url' => sprintf('https://picsum.photos/seed/%s/800/600', Str::uuid()),
            'objectives' => null,
            'requirements' => null,
        ]);
    }
}
