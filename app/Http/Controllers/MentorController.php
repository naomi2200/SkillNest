<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Mentoria;
use App\Models\User;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    public function myStudents(Request $request)
    {
        $user = $request->user();

        $courses = Curso::with('estudiantes')
            ->when($user, fn ($query) => $query->where('mentor_id', $user->id))
            ->get();

        $students = $courses->flatMap->estudiantes->unique('id')->values()->map(function ($student) use ($courses) {
            $student->courses_count = $courses->filter(fn ($course) => $course->estudiantes->contains('id', $student->id))->count();
            return $student;
        });

        return view('dashboard.mentor.students', ['students' => $students]);
    }

    public function courseStats(Request $request)
    {
        $user = $request->user();

        $courses = Curso::withCount('estudiantes')
            ->when($user, fn ($query) => $query->where('mentor_id', $user->id))
            ->get();

        return view('dashboard.mentor.courses', compact('courses'));
    }

    public function editProfile(Request $request)
    {
        $user = $request->user();
        abort_unless($user?->isMentor(), 403);

        return view('dashboard.mentor.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        abort_unless($user?->isMentor(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'profesion' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'skills' => 'nullable|string',
            'experiencia_anios' => 'nullable|integer|min:0',
            'precio_hora' => 'nullable|numeric|min:0',
            'nivel_experiencia' => 'nullable|string|max:255',
            'categorias' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $data['name'],
        ]);

        $skills = $data['skills'] ?? null;
        $skillSet = $skills
            ? implode(', ', array_filter(array_map('trim', explode(',', $skills))))
            : null;

        $categories = $data['categorias'] ?? null;
        $categorySet = $categories
            ? implode(', ', array_filter(array_map('trim', explode(',', $categories))))
            : null;

        $user->mentorProfile()->updateOrCreate([], [
            'profesion' => $data['profesion'] ?? null,
            'descripcion' => $data['descripcion'] ?? null,
            'skills' => $skillSet,
            'categorias' => $categorySet,
            'experiencia_anios' => $data['experiencia_anios'] ?? null,
            'precio_hora' => $data['precio_hora'] ?? null,
            'nivel_experiencia' => $data['nivel_experiencia'] ?? null,
        ]);

        return back()->with('status', 'Perfil actualizado');
    }

    /**
     * Dashboard del mentor: agrupa borradores/publicadas y solicitudes activas para el panel.
     */
    public function mentorships(Request $request)
    {
        $user = $request->user();
        abort_unless($user?->isMentor(), 403);

        $createdMentorias = Mentoria::where('mentor_id', $user->id)
            ->whereNull('estudiante_id')
            ->whereIn('estado', ['borrador', 'publicada'])
            ->orderByDesc('created_at')
            ->get();

        $publishedMentorias = Mentoria::where('mentor_id', $user->id)
            ->whereNull('estudiante_id')
            ->where('estado', 'publicada')
            ->orderByDesc('created_at')
            ->get();

        $requests = Mentoria::with('estudiante')
            ->where('mentor_id', $user->id)
            ->whereNotNull('estudiante_id')
            ->whereIn('estado', ['pendiente', 'aceptada', 'pagada', 'confirmada', 'completada'])
            ->latest('fecha_solicitud')
            ->latest('created_at')
            ->get();

        $stats = [
            'total' => $requests->count(),
            'pending' => $requests->where('estado', 'pendiente')->count(),
            'accepted' => $requests->where('estado', 'aceptada')->count(),
            'active' => $requests->whereIn('estado', ['aceptada', 'pagada', 'confirmada'])->count(),
        ];

        return view('dashboard.mentor.mentorships', [
            'createdMentorias' => $createdMentorias,
            'publishedMentorias' => $publishedMentorias,
            'requests' => $requests,
            'stats' => $stats,
        ]);
    }

}

