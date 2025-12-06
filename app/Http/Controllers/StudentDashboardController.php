<?php

namespace App\Http\Controllers;

use App\Models\StudentProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $courses = $user?->cursosInscritos()
            ->with(['mentor', 'modules.lessons'])
            ->withPivot('progress')
            ->get() ?? collect();

        $courseProgress = [];
        $progressValues = [];
        $completedCourses = 0;

        foreach ($courses as $course) {
            $totalLessons = $course->lessons->count();
            $completedLessons = StudentProgress::where('student_id', $user->id)
                ->where('course_id', $course->id)
                ->whereNotNull('completed_at')
                ->count();

            $progress = $course->pivot->progress
                ?? ($totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0);
            $progress = min(100, max(0, $progress));

            if ($progress >= 100) {
                $completedCourses++;
            }

            $progressValues[] = $progress;

            $courseProgress[] = [
                'title' => $course->title,
                'mentor' => $course->mentor->name ?? 'Mentor',
                'modules' => $course->modules->count(),
                'hours' => $course->duration,
                'progress' => $progress,
                'color' => 'linear-gradient(135deg,#667eea,#764ba2)',
            ];
        }

        $activeCourses = max(0, $courses->count() - $completedCourses);
        $averageProgress = $progressValues
            ? round(array_sum($progressValues) / count($progressValues))
            : 0;
        $totalHours = $courses->sum('duration');

        $mentorships = $user?->mentoriasComoEstudiante()
            ->with('mentor')
            ->whereIn('estado', ['confirmada', 'pendiente'])
            ->orderBy('fecha_programada')
            ->orderBy('hora_programada')
            ->take(4)
            ->get()
            ->map(function ($mentoria) {
                $name = $mentoria->mentor->name ?? 'Mentor';
                $initials = collect(explode(' ', $name))
                    ->filter()
                    ->map(fn ($part) => Str::upper(Str::substr($part, 0, 1)))
                    ->join('') ?: 'M';

                return [
                    'name' => $name,
                    'avatar' => $initials,
                    'specialty' => $mentoria->especialidad ?? $mentoria->titulo ?? 'Mentoría',
                    'date' => optional($mentoria->fecha_programada)->format('d M') ?? $mentoria->fecha_programada,
                    'hour' => $mentoria->hora_programada,
                    'status' => $mentoria->estado,
                ];
            }) ?? collect();

        $stats = [
            'active_courses' => $activeCourses,
            'completed_courses' => $completedCourses,
            'average_progress' => $averageProgress,
            'total_hours' => $totalHours,
        ];

        $mentorshipsArray = $mentorships instanceof \Illuminate\Support\Collection ? $mentorships->toArray() : [];
        $courseProgressArray = $courseProgress instanceof \Illuminate\Support\Collection ? $courseProgress->toArray() : $courseProgress;

        return view('student.dashboard', [
            'stats' => $stats,
            'courseProgress' => $courseProgressArray,
            'mentorships' => $mentorshipsArray,
            'upcomingEvents' => [],
        ]);
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
