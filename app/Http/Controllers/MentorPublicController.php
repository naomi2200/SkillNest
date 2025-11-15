<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Mentoria;
use App\Models\User;
use Illuminate\Http\Request;

class MentorPublicController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only([
            'categoria',
            'nivel',
            'modalidad',
            'precio_min',
            'precio_max',
        ]);

        $publicMentoriasQuery = Mentoria::query()
            ->where('estado', 'publicada')
            ->whereNull('estudiante_id')
            ->with(['mentor', 'mentor.mentorProfile'])
            ->latest('created_at');

        if ($category = $request->string('categoria')->toString()) {
            $publicMentoriasQuery->where(function ($query) use ($category) {
                $query->where('especialidad', 'like', '%' . $category . '%')
                    ->orWhereHas('mentor.mentorProfile', function ($profile) use ($category) {
                        $profile->where('profesion', 'like', '%' . $category . '%')
                            ->orWhere('categorias', 'like', '%' . $category . '%');
                    });
            });
        }

        if ($level = $request->string('nivel')->toString()) {
            $publicMentoriasQuery->whereHas('mentor.mentorProfile', function ($profile) use ($level) {
                $profile->where('nivel_experiencia', $level);
            });
        }

        if ($modalidad = $request->string('modalidad')->toString()) {
            $publicMentoriasQuery->where('modalidad', $modalidad);
        }

        if ($request->filled('precio_min')) {
            $publicMentoriasQuery->whereRaw('COALESCE(monto, precio) >= ?', [$request->float('precio_min')]);
        }

        if ($request->filled('precio_max')) {
            $publicMentoriasQuery->whereRaw('COALESCE(monto, precio) <= ?', [$request->float('precio_max')]);
        }

        $publicMentorias = $publicMentoriasQuery->get();

        $categories = [
            'frontend' => 'Frontend',
            'backend' => 'Backend',
            'fullstack' => 'Fullstack',
            'ux-ui' => 'UX/UI',
            'marketing' => 'Marketing Digital',
            'datos' => 'Bases de datos',
            'ia' => 'IA / ML',
            'devops' => 'DevOps',
        ];

        $experienceLevels = [
            'junior' => 'Junior (0-2 años)',
            'mid' => 'Mid (3-6 años)',
            'senior' => 'Senior (7+ años)',
        ];

        $modalities = [
            'virtual' => 'Virtual',
            'presencial' => 'Presencial',
        ];

        return view('mentor-market.index', [
            'publicMentorias' => $publicMentorias,
            'categories' => $categories,
            'experienceLevels' => $experienceLevels,
            'modalities' => $modalities,
            'filters' => $filters,
        ]);
    }

    public function show(User $mentor)
    {
        abort_unless($mentor->isMentor(), 404);

        // Crear perfil si no existe
        if (!$mentor->mentorProfile) {
            $mentor->mentorProfile()->create([
                'profesion' => 'Generalista',
                'descripcion' => 'Este mentor aún no ha completado su perfil.',
                'experiencia_anios' => 0,
                'skills' => '',
                'categorias' => '',
                'precio_hora' => 0,
                'nivel_experiencia' => 'junior',
            ]);
        }

        // Cargar relaciones actualizadas
        $mentor->load(['mentorProfile', 'courses']);
        $profile = $mentor->mentorProfile;
        $courses = $mentor->courses ?? collect();

        $mentoriaActiva = Mentoria::where('mentor_id', $mentor->id)
            ->where('estado', 'publicada')
            ->first();

        return view('mentor-market.show', [
            'mentor' => $mentor,
            'profile' => $profile,
            'mentoria' => $mentoriaActiva,
            'courses' => $courses,
        ]);
    }

    public function agendar(User $mentor)
    {
        abort_unless($mentor->isMentor(), 404);

        if (!$mentor->mentorProfile) {
            $mentor->mentorProfile()->create([
                'profesion' => 'Generalista',
                'descripcion' => 'Este mentor aún no ha completado su perfil.',
                'experiencia_anios' => 0,
                'skills' => '',
                'categorias' => '',
                'precio_hora' => 0,
                'nivel_experiencia' => 'junior',
            ]);
        }

        $mentor->load('mentorProfile');

        $mentoriaActiva = Mentoria::where('mentor_id', $mentor->id)
            ->where('estado', 'publicada')
            ->first();

        abort_unless($mentoriaActiva, 404);

        return view('mentor-market.book', [
            'mentor' => $mentor,
            'profile' => $mentor->mentorProfile,
            'mentoria' => $mentoriaActiva,
        ]);
    }
}

