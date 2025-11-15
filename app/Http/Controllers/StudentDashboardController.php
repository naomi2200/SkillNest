<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $courses = $user?->cursosInscritos()
            ->withPivot('progress')
            ->get() ?? collect();

        $mentoriasQuery = $user?->mentoriasComoEstudiante()
            ->whereIn('estado', ['confirmada', 'pagada', 'completada'])
            ->latest('fecha_mentoria');

        $stats = [
            'courses' => $courses->count(),
            'mentorias' => (clone $mentoriasQuery)?->count() ?? 0,
        ];

        $nextCourse = $courses->sortByDesc(fn ($course) => $course->pivot->progress ?? 0)->first();
        $upcomingMentorias = $mentoriasQuery
            ? $mentoriasQuery->take(4)->get()
            : collect();

        return view('student.dashboard', compact('stats', 'nextCourse', 'upcomingMentorias'));
    }

    public function cursos(Request $request)
    {
        $user = $request->user();

        $courses = $user?->cursosInscritos()
            ->withPivot('progress')
            ->get() ?? collect();

        return view('student.courses.index', compact('courses'));
    }

    public function mentorias(Request $request)
    {
        $user = $request->user();

        $mentorias = $user?->mentoriasComoEstudiante()
            ->with('mentor')
            ->orderByDesc('fecha_programada')
            ->orderByDesc('hora_programada')
            ->get() ?? collect();

        return view('dashboard.student.mentorias', compact('mentorias'));
    }

    public function perfil(Request $request)
    {
        $user = $request->user();

        return view('student.profile', compact('user'));
    }
}
