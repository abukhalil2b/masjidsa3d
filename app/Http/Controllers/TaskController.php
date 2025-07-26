<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Student;
use App\Models\TaskGroup;
use App\Models\StudentTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

    public function taskCompletedCount()
    {
        $students = Student::all();
        $data = [];

        foreach ($students as $student) {
            // Count how many tasks this student completed (done_at is not null)
            $completedCount = StudentTask::where('student_id', $student->id)
                ->whereNotNull('done_at')
                ->count();

            $data[] = [
                'name' => $student->name,
                'completed' => $completedCount,
            ];
        }

        // Sort by most tasks completed
        $data = collect($data)->sortByDesc('completed')->values();

        return view('tasks.completed_count', compact('data'));
    }



    public function index()
    {
        $taskGroupIds = TaskGroup::where('teacher_id', Auth::id())->pluck('id')->toArray();
        $taskGroups = TaskGroup::with('tasks')->where('teacher_id', Auth::id())->get();
        $tasks = Task::with('group')->whereIn('task_group_id', $taskGroupIds)->get();

        return view('tasks.index', compact('tasks', 'taskGroups'));
    }


    public function show(Task $task)
    {
        $student_group_id = DB::table('group_task_assignments')
            ->where('task_group_id', $task->task_group_id)
            ->value('student_group_id');

        if (!$student_group_id) {

            return back()->with([
                'type' => 'error',
                'message' => 'لا توجد مجموعة طلاب مرتبطة بهذه المهمة.',
            ]);
        }

        $students = Student::where('student_group_id', $student_group_id)->get();

        $studentTasks = StudentTask::where('task_id', $task->id)
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->keyBy('student_id');

        return view('tasks.show', compact('task', 'students', 'studentTasks'));
    }




    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:50',
            'point' => 'required|integer|min:1|max:255',
            'task_group_id' => 'nullable|exists:task_groups,id',
            'new_group_title' => 'nullable|string|max:50',
        ]);

        $teacherId = auth()->id();
        $groupId = null;

        // If a new group title is provided, create the group
        if ($request->filled('new_group_title')) {
            $newGroup = TaskGroup::create([
                'title' => $request->new_group_title,
                'teacher_id' => $teacherId,
            ]);

            $groupId = $newGroup->id;
        } elseif ($request->filled('task_group_id')) {
            $group = TaskGroup::where('id', $request->task_group_id)
                ->where('teacher_id', $teacherId)
                ->first();

            if (!$group) {

                return redirect()->back()->with([
                    'type' => 'error',
                    'message' =>  'المجموعة غير صالحة أو لا تتبعك.',
                ]);
            }

            $groupId = $group->id;
        } else {
            return redirect()->back()->withErrors(['task_group_id' => 'يرجى اختيار مجموعة أو إنشاء مجموعة جديدة.']);
        }

        Task::create([
            'title' => $request->title,
            'point' => $request->point,
            'task_group_id' => $groupId,
        ]);

        return redirect()->route('tasks.index')->with('success', 'تم إضافة المهمة بنجاح');
    }


    public function update(Request $request, Task $task)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'point' => 'required|integer|min:0|max:10'
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'تم تحديث المهمة بنجاح');
    }


    public function destroy(Task $task)
    {

        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'تم حذف المهمة بنجاح');
    }



    public function evaluateIndex()
    {
        $teacherId = Auth::id();

        // Fetch tasks belonging to the teacher's task groups
        $tasks = Task::whereHas('group', function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })
            ->with('group') // Eager load the task group for display
            ->get();

        // Prepare data for the view
        $tasksWithStudents = $tasks->map(function ($task) {
            // Get all student IDs from student groups associated with this task's group
            $studentIdsInAssignedGroups = Student::whereHas('group.taskGroups', function ($query) use ($task) {
                $query->where('task_groups.id', $task->task_group_id);
            })->pluck('id'); // Get only the IDs

            // Fetch all relevant students and their associated studentTask for THIS specific task
            $studentsForTask = Student::whereIn('id', $studentIdsInAssignedGroups)
                ->with(['studentTasks' => function ($query) use ($task) {
                    $query->where('task_id', $task->id);
                }])
                ->get();

            // Map students to their task status
            $evaluatedStudents = $studentsForTask->map(function ($student) use ($task) {
                $studentTaskRecord = $student->studentTasks->first(); // Get the single studentTask for this task

                return (object) [
                    'student' => $student,
                    'achieved_point' => $studentTaskRecord ? $studentTaskRecord->achieved_point : null,
                    'done_at' => $studentTaskRecord ? $studentTaskRecord->done_at : null,
                    'is_done' => (bool) $studentTaskRecord && $studentTaskRecord->achieved_point !== null,
                ];
            });

            // Calculate overall task status (e.g., how many students completed it)
            $completedCount = $evaluatedStudents->filter(fn($s) => $s->is_done)->count();
            $totalStudentsCount = $evaluatedStudents->count();


            return (object) [
                'task' => $task,
                'students_status' => $evaluatedStudents,
                'completed_count' => $completedCount,
                'total_students_count' => $totalStudentsCount,
            ];
        });

        return view('tasks.evaluate.index', compact('tasksWithStudents'));
    }

    // You will still need your evaluate.store and student-tasks.evaluate.form methods
    // based on the previous discussion.
    // For example, the form could be similar to the previous modal, but now triggered from this table.
    // Ensure the route `student-tasks.evaluate.form` correctly leads to a view/modal for evaluation.

}
