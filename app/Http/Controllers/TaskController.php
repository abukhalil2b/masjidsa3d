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

        // Get tasks that belong to teacher's task groups
        $tasks = Task::whereHas('group', function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->with(['studentTasks.student','group'])
            ->get();

        return view('tasks.evaluate.index', compact('tasks'));
    }

    public function evaluateForm(StudentTask $studentTask)
    {
        $student = Student::findOrFail($studentTask->student_id);

        $task = Task::findOrFail($studentTask->task_id);

        return view('tasks.evaluate.form', compact('studentTask','student','task'));
    }

    public function storeEvaluation(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'task_id' => 'required|exists:tasks,id',
            'achieved_point' => 'required|numeric|min:0|max:100',
        ]);

        StudentTask::updateOrCreate(
            [
                'student_id' => $validated['student_id'],
                'task_id' => $validated['task_id'],
            ],
            [
                'achieved_point' => $validated['achieved_point'],
                'done_at' => now(),
            ]
        );

        return redirect()->route('tasks.show', $validated['task_id'])
            ->with('success', 'تم حفظ التقييم بنجاح');
    }
}
