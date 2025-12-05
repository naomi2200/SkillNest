<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CourseApproved;
use App\Notifications\CourseRejected;

class CourseReviewController extends Controller
{
    private array $allowedStatuses = ['pendiente', 'aprobado', 'rechazado', 'publicado'];

    private array $statusAliases = [
        'pending' => 'pendiente',
        'approved' => 'aprobado',
        'rejected' => 'rechazado',
        'pendiente' => 'pendiente',
        'aprobado' => 'aprobado',
        'rechazado' => 'rechazado',
        'publicado' => 'publicado',
    ];

    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $rawStatus = $request->query('status', 'pendiente');
        $currentStatus = $this->statusAliases[$rawStatus] ?? 'pendiente';
        if (! in_array($currentStatus, $this->allowedStatuses, true)) {
            $currentStatus = 'pendiente';
        }

        $courses = Curso::query()
            ->where('status', $currentStatus)
            ->with('mentor')
            ->withCount('modules')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $pendingPreview = Curso::query()
            ->where('status', 'pendiente')
            ->with('mentor')
            ->latest()
            ->take(5)
            ->get();

        $pendingCount = Curso::where('status', 'pendiente')->count();
        $approvedCount = Curso::where('status', 'aprobado')->count();
        $rejectedCount = Curso::where('status', 'rechazado')->count();
        $publishedCount = Curso::where('status', 'publicado')->count();

        return view('admin.courses.index', [
            'courses' => $courses,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'publishedCount' => $publishedCount,
            'totalCourses' => $pendingCount + $approvedCount + $rejectedCount + $publishedCount,
            'currentStatus' => $currentStatus,
            'pendingPreview' => $pendingPreview,
        ]);
    }

    public function show($id)
    {
        $this->authorizeAdmin();

        $course = Curso::with(['mentor', 'modules.lessons'])->findOrFail($id);

        return view('admin.courses.show', compact('course'));
    }

    public function approve($id)
    {
        $this->authorizeAdmin();

        $course = Curso::findOrFail($id);
        $course->forceFill([
            'status' => 'aprobado',
            'review_status' => 'approved',
            'rejection_reason' => null,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ])->save();

        if ($course->mentor) {
            Notification::send($course->mentor, new CourseApproved($course));
        }

        return redirect()
            ->route('admin.courses.index', ['status' => 'aprobado'])
            ->with('status', 'Curso aprobado correctamente.');
    }

    public function reject(Request $request, $id)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:2000'],
        ]);

        $course = Curso::findOrFail($id);
        $course->forceFill([
            'status' => 'rechazado',
            'review_status' => 'rejected',
            'rejection_reason' => $data['rejection_reason'],
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ])->save();

        if ($course->mentor) {
            Notification::send($course->mentor, new CourseRejected($course, $data['rejection_reason']));
        }

        return redirect()
            ->route('admin.courses.index', ['status' => 'rechazado'])
            ->with('status', 'Curso rechazado correctamente.');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        $course = Curso::findOrFail($id);
        $course->delete();

        return redirect()
            ->route('admin.courses.index')
            ->with('status', 'Curso eliminado correctamente.');
    }

    public function resetReview($id)
    {
        $this->authorizeAdmin();

        $course = Curso::findOrFail($id);
        $course->forceFill([
            'status' => 'pendiente',
            'review_status' => 'pending',
            'rejection_reason' => null,
        ])->save();

        return redirect()
            ->route('admin.courses.index', ['status' => 'pendiente'])
            ->with('status', 'El curso ha sido enviado nuevamente a revisión.');
    }

    protected function authorizeAdmin(): void
    {
        $user = auth()->user();
        abort_unless($user && $user->isAdmin(), 403);
    }
}
