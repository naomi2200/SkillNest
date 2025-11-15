<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseBuilderController extends Controller
{
    public function create()
    {
        $this->authorizeMentor();

        return view('mentor.create-course');
    }

    public function store(Request $request)
    {
        $mentor = $this->authorizeMentor();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'level' => 'required|in:principiante,intermedio,avanzado',
            'category' => 'required|string|max:255',
        ]);

        $course = Course::create(array_merge($data, [
            'mentor_id' => $mentor->id,
            'status' => 'borrador',
            'review_status' => Course::REVIEW_DRAFT,
        ]));

        return redirect()
            ->route('mentor.courses.builder', $course)
            ->with('status', 'Curso creado. Ahora agrega módulos y lecciones.');
    }

    public function edit(Course $course)
    {
        $this->authorizeMentor($course);

        $course->load('modules.lessons');

        $builderModules = $course->modules->map(function ($module) {
            return [
                'local_id' => (string) Str::uuid(),
                'title' => $module->title,
                'description' => $module->description,
                'requires_quiz' => (bool) $module->requires_quiz,
                'position' => $module->position,
                'lessons' => $module->lessons->map(function ($lesson) {
                    return [
                        'local_id' => (string) Str::uuid(),
                        'title' => $lesson->title,
                        'type' => $lesson->type,
                        'duration_minutes' => $lesson->duration_minutes,
                        'position' => $lesson->position,
                    ];
                })->values(),
            ];
        })->values();

        return view('mentor.create-course', compact('course', 'builderModules'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorizeMentor($course);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'level' => 'required|in:principiante,intermedio,avanzado',
            'category' => 'required|string|max:255',
            'image_url' => 'nullable|url',
        ]);

        $course->update($data);

        return back()->with('status', 'Curso actualizado.');
    }

    public function syncStructure(Request $request, Course $course)
    {
        $this->authorizeMentor($course);

        $payload = $request->validate([
            'modules' => 'required|array|min:1',
            'modules.*.title' => 'required|string|max:255',
            'modules.*.description' => 'nullable|string',
            'modules.*.position' => 'nullable|integer|min:1',
            'modules.*.requires_quiz' => 'boolean',
            'modules.*.lessons' => 'required|array|min:1',
            'modules.*.lessons.*.title' => 'required|string|max:255',
            'modules.*.lessons.*.type' => 'required|in:video,reading,live,quiz',
            'modules.*.lessons.*.content' => 'nullable|string',
            'modules.*.lessons.*.video_url' => 'nullable|url',
            'modules.*.lessons.*.resource_url' => 'nullable|url',
            'modules.*.lessons.*.duration_minutes' => 'nullable|integer|min:1',
        ]);

        DB::transaction(function () use ($course, $payload) {
            $course->modules()->delete();

            foreach ($payload['modules'] as $index => $moduleData) {
                $module = $course->modules()->create([
                    'title' => $moduleData['title'],
                    'description' => $moduleData['description'] ?? null,
                    'position' => $moduleData['position'] ?? ($index + 1),
                    'requires_quiz' => $moduleData['requires_quiz'] ?? true,
                ]);

                foreach ($moduleData['lessons'] as $lessonIndex => $lessonData) {
                    $module->lessons()->create([
                        'title' => $lessonData['title'],
                        'type' => $lessonData['type'],
                        'content' => $lessonData['content'] ?? null,
                        'video_url' => $lessonData['video_url'] ?? null,
                        'resource_url' => $lessonData['resource_url'] ?? null,
                        'duration_minutes' => $lessonData['duration_minutes'] ?? null,
                        'position' => $lessonIndex + 1,
                    ]);
                }
            }
        });

        return response()->json(['status' => 'estructura guardada']);
    }

    public function submitForReview(Course $course)
    {
        $this->authorizeMentor($course);

        if ($course->modules()->count() === 0) {
            return back()->withErrors('Agrega al menos un módulo antes de enviar a revisión.');
        }

        $course->update(['review_status' => Course::REVIEW_PENDING]);

        return back()->with('status', 'Curso enviado a revisión.');
    }

    protected function authorizeMentor(?Course $course = null)
    {
        $user = auth()->user();

        abort_unless($user && $user->isMentor(), 403);

        if ($course) {
            abort_unless($course->isOwnedBy($user), 403);
        }

        return $user;
    }
}
