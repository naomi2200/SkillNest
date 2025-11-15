<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\StudentProgress;
use Illuminate\Http\Request;

class CourseProgressController extends Controller
{
    public function classroom(Course $course)
    {
        $user = auth()->user();
        abort_unless($user, 403);

        if (!$course->isPurchasedBy($user) && !$course->isOwnedBy($user)) {
            return redirect()->route('cursos.show', $course)->withErrors('Debes adquirir el curso para acceder al aula.');
        }

        $course->load(['modules.lessons', 'modules.quiz.questions']);

        $progress = StudentProgress::where('student_id', $user->id)
            ->where('course_id', $course->id)
            ->get()
            ->groupBy(function ($record) {
                return "module_{$record->module_id}_lesson_{$record->lesson_id}";
            });

        return view('courses.classroom', compact('course', 'progress'));
    }

    public function storeLessonProgress(Request $request, Lesson $lesson)
    {
        $user = auth()->user();
        abort_unless($user, 403);

        $course = $lesson->module->course;
        abort_unless($course->isPurchasedBy($user) || $course->isOwnedBy($user), 403);

        $data = $request->validate([
            'status' => 'required|in:in_progress,completed',
            'score' => 'nullable|numeric|min:0|max:100',
        ]);

        $progress = StudentProgress::updateOrCreate(
            [
                'student_id' => $user->id,
                'course_id' => $course->id,
                'module_id' => $lesson->module_id,
                'lesson_id' => $lesson->id,
            ],
            [
                'status' => $data['status'],
                'score' => $data['score'] ?? null,
                'completed_at' => $data['status'] === 'completed' ? now() : null,
            ]
        );

        if ($data['status'] === 'completed') {
            $this->tryUnlockNextLesson($course, $lesson->module, $user->id);
        }

        return response()->json(['progress' => $progress]);
    }

    public function unlockModule(Request $request, Module $module)
    {
        $user = auth()->user();
        abort_unless($user, 403);

        $course = $module->course;
        abort_unless($course->isPurchasedBy($user) || $course->isOwnedBy($user), 403);

        StudentProgress::updateOrCreate(
            [
                'student_id' => $user->id,
                'course_id' => $course->id,
                'module_id' => $module->id,
                'lesson_id' => null,
            ],
            [
                'status' => 'in_progress',
                'unlocked_at' => now(),
            ]
        );

        return response()->json(['status' => 'unlocked']);
    }

    protected function tryUnlockNextLesson(Course $course, Module $module, int $studentId): void
    {
        $lessons = $module->lessons()->orderBy('position')->pluck('id');

        $completed = StudentProgress::where('student_id', $studentId)
            ->where('course_id', $course->id)
            ->whereIn('lesson_id', $lessons)
            ->where('status', 'completed')
            ->count();

        if ($completed === $lessons->count()) {
            // mark module completed
            StudentProgress::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'course_id' => $course->id,
                    'module_id' => $module->id,
                    'lesson_id' => null,
                ],
                [
                    'status' => 'completed',
                    'completed_at' => now(),
                ]
            );

            $nextModule = $course->modules()->where('position', '>', $module->position)->orderBy('position')->first();
            if ($nextModule) {
                StudentProgress::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'course_id' => $course->id,
                        'module_id' => $nextModule->id,
                        'lesson_id' => null,
                    ],
                    [
                        'status' => 'in_progress',
                        'unlocked_at' => now(),
                    ]
                );
            }
        }
    }
}
