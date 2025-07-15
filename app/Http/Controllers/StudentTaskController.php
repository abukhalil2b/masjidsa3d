<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Student;
use App\Models\StudentTask; // Ensure this is correctly used for pivot model
use App\Models\TaskGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // If needed for authorization checks
use Carbon\Carbon;

class StudentTaskController extends Controller
{
    public function markDone(Student $student, Task $task)
    {
        // Optional: confirm the student is allowed this task
        StudentTask::updateOrCreate([
            'student_id' => $student->id,
            'task_id' => $task->id,
        ], [
            'achieved_point' => $task->point,
            'assigned_at' => now(),
            'done_at' => now(),
        ]);

        return back()->with('success', 'تم تسجيل إنجاز المهمة.');
    }

    public function evaluate(Request $request)
    {
        StudentTask::updateOrCreate([
            'student_id' => $request->student_id,
            'task_id' => $request->task_id,
        ], [
            'achieved_point' => $request->achieved_point,
            'done_at' => now(),
        ]);

        return back()->with('success', 'تم تسجيل إنجاز المهمة.');
    }

    public function bulkEdit(Student $student)
    {
        // Get all task groups assigned to the student's group
        $assignedTaskGroupIds = $student->studentGroup
            ->groupTaskAssignments()
            ->pluck('task_group_id');

        // Get all task IDs already done by this student
        $doneTaskIds = $student->studentTasks()
            ->pluck('task_id')
            ->toArray();

        // Get tasks from assigned task groups that have NOT been done yet
        $tasks = Task::whereIn('task_group_id', $assignedTaskGroupIds)
            ->whereNotIn('id', $doneTaskIds)
            ->get();

        return view('student_tasks.bulk_edit', compact('student', 'tasks'));
    }



    public function bulkUpdate(Request $request, Student $student)
    {
        // Validate the input
        $validated = $request->validate([
            'task_ids' => 'required|array',
            'task_ids.*' => 'exists:tasks,id',
            'achieved_point' => 'required|integer|min:0',
        ]);

        $doneAt = Carbon::now();

        foreach ($validated['task_ids'] as $taskId) {
            StudentTask::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'task_id' => $taskId,
                ],
                [
                    'achieved_point' => $validated['achieved_point'],
                    'done_at' => $doneAt,
                ]
            );
        }

        return redirect()->route('dashboard')->with('success', 'Tasks successfully assigned.');
    }
}
