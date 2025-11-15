<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function myCourses(Request $request)
    {
        $user = $request->user();

        $courses = $user?->cursosInscritos()->with('mentor')->get() ?? collect();

        return view('dashboard.student.courses', compact('courses', 'user'));
    }

    public function myMentorias(Request $request)
    {
        $user = $request->user();

        $mentorias = $user?->mentoriasComoEstudiante()->with('mentor')->latest('fecha_mentoria')->get() ?? collect();

        return view('dashboard.student.mentorias', compact('mentorias', 'user'));
    }
}
