<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Purchase;
use App\Models\StudentProgress;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CoursePurchaseController extends Controller
{
    public function create(Course $course)
    {
        $user = auth()->user();
        abort_unless($user, 403);

        if ($course->isOwnedBy($user)) {
            return redirect()->route('courses.classroom', $course);
        }

        if ($course->isPurchasedBy($user)) {
            return redirect()->route('courses.classroom', $course)
                ->with('status', 'Ya tienes acceso a este curso.');
        }

        return view('courses.checkout', [
            'course' => $course,
        ]);
    }

    public function store(Request $request, Course $course)
    {
        $user = auth()->user();
        abort_unless($user, 403);

        if ($course->isPurchasedBy($user)) {
            return back()->with('status', 'Ya cuentas con este curso.');
        }

        $data = $request->validate([
            'amount' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['required', Rule::in(['tarjeta', 'yape', 'plin'])],
            'card_name' => ['nullable', 'required_if:payment_method,tarjeta', 'string', 'max:255'],
            'card_number' => ['nullable', 'required_if:payment_method,tarjeta', 'digits:16'],
            'reference' => ['nullable', 'required_unless:payment_method,tarjeta', 'string', 'max:255'],
        ]);

        $amount = $data['amount'] ?? $course->price;
        $reference = $data['reference'] ?? null;
        if ($data['payment_method'] === 'tarjeta' && $data['card_number']) {
            $reference = 'CARD-' . substr($data['card_number'], -4);
        }

        $purchase = Purchase::create([
            'course_id' => $course->id,
            'student_id' => $user->id,
            'amount' => $amount,
            'status' => 'paid',
            'reference' => $reference,
            'metadata' => [
                'payment_method' => $data['payment_method'],
                'card_name' => $data['card_name'] ?? null,
            ],
            'paid_at' => now(),
        ]);

        $course->estudiantes()->syncWithoutDetaching([$user->id]);
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
