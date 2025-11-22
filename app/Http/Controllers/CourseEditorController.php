<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseEditorController extends Controller
{
    public function updateBasics(Request $request, Curso $curso)
    {
        $this->authorizeCourse($request->user(), $curso);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'level' => ['required', 'in:principiante,intermedio,avanzado'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:1'],
            'description' => ['required', 'string'],
            'objectives' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
        ]);

        $curso->update($data);

        return response()->json(['course' => $curso->fresh()]);
    }

    public function addModule(Request $request, Curso $curso)
    {
        $this->authorizeCourse($request->user(), $curso);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $position = ($curso->modules()->max('position') ?? 0) + 1;

        $module = $curso->modules()->create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'position' => $position,
            'requires_quiz' => false,
        ]);

        return response()->json(['module' => $module]);
    }

    public function updateModule(Request $request, Module $module)
    {
        $curso = $module->course;
        $this->authorizeCourse($request->user(), $curso);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $module->update($data);

        return response()->json(['module' => $module]);
    }

    public function deleteModule(Request $request, Module $module)
    {
        $curso = $module->course;
        $this->authorizeCourse($request->user(), $curso);

        $module->lessons()->delete();
        $module->delete();

        return response()->json(['status' => 'module_deleted']);
    }

    public function addLesson(Request $request, Module $module)
    {
        $curso = $module->course;
        $this->authorizeCourse($request->user(), $curso);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:video,reading,quiz,live,file'],
        ]);

        $position = ($module->lessons()->max('position') ?? 0) + 1;

        $lesson = $module->lessons()->create([
            'title' => $data['title'],
            'type' => $data['type'],
            'position' => $position,
        ]);

        return response()->json(['lesson' => $lesson]);
    }

    public function updateLesson(Request $request, Lesson $lesson)
    {
        $module = $lesson->module;
        $curso = $module->course;
        $this->authorizeCourse($request->user(), $curso);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:video,reading,quiz,live,file'],
            'content' => ['nullable'],
            'video_url' => ['nullable', 'string', 'max:500'],
            'resource_url' => ['nullable', 'string', 'max:500'],
        ]);

        $lesson->update([
            'title' => $data['title'],
            'type' => $data['type'],
            'content' => $data['content'] ?? null,
            'video_url' => $data['video_url'] ?? null,
            'resource_url' => $data['resource_url'] ?? null,
        ]);

        return response()->json(['lesson' => $lesson]);
    }

    public function deleteLesson(Request $request, Lesson $lesson)
    {
        $module = $lesson->module;
        $curso = $module->course;
        $this->authorizeCourse($request->user(), $curso);

        $lesson->delete();

        return response()->json(['status' => 'lesson_deleted']);
    }

    public function reorder(Request $request, Curso $curso)
    {
        $this->authorizeCourse($request->user(), $curso);

        $data = $request->validate([
            'modules' => ['array'],
            'modules.*' => ['integer'],
            'lessons' => ['array'],
        ]);

        if (! empty($data['modules'])) {
            foreach ($data['modules'] as $index => $moduleId) {
                Module::where('id', $moduleId)
                    ->where('course_id', $curso->id)
                    ->update(['position' => $index + 1]);
            }
        }

        if (! empty($data['lessons'])) {
            foreach ($data['lessons'] as $moduleId => $lessonIds) {
                foreach ($lessonIds as $index => $lessonId) {
                    Lesson::where('id', $lessonId)
                        ->whereHas('module', fn ($query) => $query->where('course_id', $curso->id))
                        ->update(['position' => $index + 1]);
                }
            }
        }

        return response()->json(['status' => 'reordered']);
    }

    public function updateImage(Request $request, Curso $curso)
    {
        $this->authorizeCourse($request->user(), $curso);

        $request->validate([
            'image' => ['required', 'image', 'max:4096'],
        ]);

        if ($curso->image_url && Str::startsWith($curso->image_url, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $curso->image_url));
        }

        $path = $request->file('image')->store('courses', 'public');

        $url = Storage::url($path);
        $curso->update(['image_url' => $url]);

        return response()->json(['image_url' => asset($url)]);
    }

    protected function authorizeCourse($user, Curso $curso): void
    {
        abort_unless(
            $user
            && method_exists($user, 'isMentor')
            && $user->isMentor()
            && (int) $curso->mentor_id === (int) $user->id,
            403
        );
    }
}
