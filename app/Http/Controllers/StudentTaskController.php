<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Student;
use App\Models\StudentTask; // Ensure this is correctly used for pivot model
use App\Models\TaskGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // If needed for authorization checks

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
        // Get task group IDs assigned to the student's group
        $taskGroupIds = \DB::table('group_task_assignments')
            ->where('student_group_id', $student->student_group_id)
            ->pluck('task_group_id');

        // Get all tasks in those groups
        $tasks = \App\Models\Task::whereIn('task_group_id', $taskGroupIds)->get();

        // Get student_tasks records for the student and these tasks
        $studentTasks = \App\Models\StudentTask::where('student_id', $student->id)
            ->whereIn('task_id', $tasks->pluck('id'))
            ->get()->keyBy('task_id');

        // Collect tasks not done yet (no student_task or done_at is null)
        $tasksToShow = [];

        foreach ($tasks as $task) {
            $studentTask = $studentTasks->get($task->id);

            if (!$studentTask || $studentTask->done_at === null) {
                $tasksToShow[] = (object)[
                    'task' => $task,
                    'student_task' => $studentTask,
                ];
            }
        }

        return view('student_tasks.bulk_edit', compact('student', 'tasksToShow'));
    }


public function bulkUpdate(Request $request, Student $student)
{
    $validated = $request->validate([
        'task_ids' => 'required|array',
        'task_ids.*' => 'integer|exists:tasks,id',
        'achieved_point' => 'required|integer|min:0|max:100',
    ]);

    $achievedPoint = $validated['achieved_point'];

    foreach ($validated['task_ids'] as $taskId) {
        $studentTask = \App\Models\StudentTask::firstOrNew([
            'student_id' => $student->id,
            'task_id' => $taskId,
        ]);

        $studentTask->achieved_point = $achievedPoint;
        $studentTask->done_at = now();
        $studentTask->save();
    }

    return redirect()->route('student_tasks.bulk.edit', $student->id)
        ->with('success', 'Selected tasks marked as done with point ' . $achievedPoint);
}

}
