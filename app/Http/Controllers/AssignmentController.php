<?php

namespace App\Http\Controllers;

use App\Models\StudentGroup;
use App\Models\TaskGroup;
use App\Models\GroupTaskAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    public function index()
    {
        $studentGroups = StudentGroup::where('teacher_id', auth()->id())->get();
        $taskGroups = TaskGroup::where('teacher_id', auth()->id())->get();

        $assignments = GroupTaskAssignment::with(['studentGroup', 'taskGroup'])
            ->whereIn('student_group_id', $studentGroups->pluck('id'))
            ->get();


        return view('assignments.index', compact('studentGroups', 'taskGroups', 'assignments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_group_id' => 'required|exists:student_groups,id',
            'task_group_id' => 'required|exists:task_groups,id',
        ]);

        $exists = GroupTaskAssignment::where('student_group_id', $request->student_group_id)
            ->where('task_group_id', $request->task_group_id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['task_group_id' => 'تم بالفعل ربط هذه المجموعتين.']);
        }

        GroupTaskAssignment::firstOrCreate([
            'student_group_id' => $request->student_group_id,
            'task_group_id' => $request->task_group_id,
        ]);

        return back()->with('success', 'تم ربط مجموعة المهام بمجموعة الطلاب.');
    }
}
