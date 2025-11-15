<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Purchase;
use App\Models\StudentProgress;
use Illuminate\Http\Request;

class CoursePurchaseController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $user = auth()->user();
        abort_unless($user, 403);

        if ($course->isPurchasedBy($user)) {
            return back()->with('status', 'Ya cuentas con este curso.');
        }

        $data = $request->validate([
            'amount' => 'nullable|numeric|min:0',
        ]);

        $amount = $data['amount'] ?? $course->price;

        $purchase = Purchase::create([
            'course_id' => $course->id,
            'student_id' => $user->id,
            'amount' => $amount,
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $this->unlockFirstModule($course, $user->id);

        return redirect()->route('courses.classroom', $course)->with('status', 'Compra registrada correctamente.');
    }

    protected function unlockFirstModule(Course $course, int $studentId): void
    {
        $firstModule = $course->modules()->orderBy('position')->first();
        if (!$firstModule) {
            return;
        }

        StudentProgress::updateOrCreate(
            [
                'student_id' => $studentId,
                'course_id' => $course->id,
                'module_id' => $firstModule->id,
            ],
            [
                'status' => 'in_progress',
                'unlocked_at' => now(),
            ]
        );
    }
}
