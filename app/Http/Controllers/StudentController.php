<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentGroup;
use App\Models\StudentTask;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{


    

    public function storeAssignedStudents(Request $request, Task $task)
    {
        $this->authorize('assignStudents', $task);

        $request->validate([
            'student_ids'   => 'nullable|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $selectedStudentIds = $request->input('student_ids', []);

        $authorizedStudentIds = Student::where('teacher_id', Auth::id())->pluck('id')->toArray();
        $finalStudentIds = array_intersect($selectedStudentIds, $authorizedStudentIds);

        $syncData = [];
        foreach ($finalStudentIds as $studentId) {
            $syncData[$studentId] = [
                'points'         => $task->point,
                'achieved_point' => null,
                'status'         => 'pending',
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        $task->students()->sync($syncData);

        return redirect()->route('tasks.index')->with('success', 'تم إسناد المهمة للطلاب المحددين بنجاح!');
    }

    public function evaluateIndex()
    {
        $teacherId = Auth::id();

        $tasks = Task::where('user_id', $teacherId)
            ->with(['studentTasks' => function ($query) use ($teacherId) {
                // Eager load related student and task details for evaluation
                $query->whereHas('student', function ($q) use ($teacherId) {
                    $q->where('teacher_id', $teacherId);
                })->with('student', 'task');
            }])
            ->get();

        return view('tasks.evaluate.index', compact('tasks'));
    }

    public function evaluateForm(StudentTask $studentTask)
    {

        return view('tasks.evaluate.form', compact('studentTask'));
    }

    public function storeEvaluation(Request $request, StudentTask $studentTask)
    {

        $validated = $request->validate([
            // 'achieved_point' must be between 0 and the 'points' originally assigned to this specific student_task instance
            'achieved_point' => 'required|integer|min:0|max:' . $studentTask->points,
            'status'         => 'required|string|in:pending,completed,needs_review', // Example statuses
        ]);

        $studentTask->update([
            'achieved_point' => $validated['achieved_point'],
            'status'         => $validated['status'],
        ]);

        return redirect()->route('tasks.evaluate.index')
            ->with('success', 'النقاط المسجلة بنجاح للمهمة ' . $studentTask->task->title . ' للطالب ' . $studentTask->student->name);
    }

    public function showTasks(Student $student)
    {
        $assignedTasks = Task::whereHas('group.studentGroups', function ($query) use ($student) {
            $query->where('student_groups.id', $student->student_group_id);
        })->get();

        $doneTasks = $student->studentTasks()->with('task')->get()->keyBy('task_id');

        $totalAchievedPoints = 0; // Initialize total achieved points

        $studentTasksStatus = $assignedTasks->map(function ($task) use ($doneTasks, &$totalAchievedPoints) {
            $status = [
                'task' => $task,
                'is_done' => false,
                'achieved_point' => null,
                'done_at' => null,
            ];

            if ($doneTasks->has($task->id)) {
                $studentTaskRecord = $doneTasks->get($task->id);
                $status['is_done'] = true;
                $status['achieved_point'] = $studentTaskRecord->achieved_point;
                $status['done_at'] = $studentTaskRecord->done_at;

                // Add achieved points to the total
                $totalAchievedPoints += $studentTaskRecord->achieved_point ?? 0;
            }

            return (object) $status;
        });

        return view('students.show_tasks', compact('student', 'studentTasksStatus', 'totalAchievedPoints'));
    }
}
