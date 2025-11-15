<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseReviewController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();

        $courses = Course::with('mentor')
            ->whereIn('review_status', [Course::REVIEW_PENDING, Course::REVIEW_REJECTED])
            ->latest()
            ->get();

        return view('admin.courses.review', compact('courses'));
    }

    public function approve(Course $course)
    {
        $this->authorizeAdmin();

        $course->update([
            'review_status' => Course::REVIEW_APPROVED,
            'status' => 'activo',
            'rejection_reason' => null,
            'published_at' => now(),
        ]);

        return back()->with('status', "Curso {$course->title} aprobado.");
    }

    public function reject(Request $request, Course $course)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $course->update([
            'review_status' => Course::REVIEW_REJECTED,
            'rejection_reason' => $data['reason'],
        ]);

        return back()->with('status', "Curso {$course->title} rechazado.");
    }

    protected function authorizeAdmin()
    {
        $user = auth()->user();
        abort_unless($user && $user->isAdmin(), 403);
        return $user;
    }
}
