<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Mentoria;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Panel principal para usuarios autenticados.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user?->isMentor()) {
            return redirect()->route('mentor.courses');
        }
        if ($user?->isStudent()) {
            return redirect()->route('student.dashboard');
        }

        $stats = [
            'courses_active' => Curso::where('status', 'aprobado')->count(),
            'courses_pending' => Curso::where('status', 'pendiente')->count(),
            'courses_drafts' => Curso::where('status', 'borrador')->count(),
            'courses_rejected' => Curso::where('status', 'rechazado')->count(),
            'mentorships_upcoming' => Mentoria::where('estado', 'confirmada')->count(),
            'mentorships_pending' => Mentoria::where('estado', 'pendiente')->count(),
        ];

        $recentCourses = Curso::latest()->take(5)->get();
        $pendingCourses = Curso::where('status', 'pendiente')->latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();
        $upcomingMentorships = Mentoria::whereNotNull('fecha_mentoria')
            ->orderBy('fecha_mentoria')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'stats',
            'recentCourses',
            'upcomingMentorships',
            'pendingCourses',
            'recentUsers',
            'user'
        ));
    }
}
