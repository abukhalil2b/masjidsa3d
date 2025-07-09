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

    public function evaluate(){
        
    }
}
