<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Student;
use App\Models\StudentGroup; // Ensure this is correctly used for pivot model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // If needed for authorization checks

class StudentGroupController extends Controller
{
    public function index()
    {
        $teacherId = auth()->id();

        $studentGroups = StudentGroup::where('teacher_id', $teacherId)
            ->withCount('students') // Count students directly
            ->withCount('taskGroups') // Count assigned task groups (missions)
            ->get();

        return view('students.group_index', compact('studentGroups'));
    }

    public function updateTitle(Request $request, StudentGroup $group)
    {
        $request->validate([
            'title' => 'required|string|max:100',
        ]);

        if ($group->teacher_id !== auth()->id()) {
            abort(403);
        }

        $group->update([
            'title' => $request->title,
        ]);

        return redirect()->route('student_groups')->with('success', 'تم تحديث اسم المجموعة بنجاح');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
        ]);

        StudentGroup::create([
            'title' => $validated['title'],
            'teacher_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'تم إنشاء المجموعة بنجاح.');
    }
}
