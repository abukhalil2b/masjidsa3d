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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:8',
            'grade' => 'nullable|string|max:12',
            'student_group_id' => 'nullable|exists:student_groups,id',
            'new_group_title' => 'nullable|string|max:100',
        ]);

        $teacherId = Auth::id();

        if ($request->filled('new_group_title')) {
            $group = StudentGroup::create([
                'title' => $request->new_group_title,
                'teacher_id' => $teacherId,
            ]);
            $groupId = $group->id;
        } else {
            $groupId = $request->student_group_id;
        }

        Student::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'grade' => $request->grade,
            'teacher_id' => $teacherId,
            'student_group_id' => $groupId,
        ]);

        return back()->with('success', __('تم إضافة الطالب بنجاح!'));
    }

    public function update(Request $request, Student $student)
    {
         $request->validate([
        'name' => 'required|string|max:100',
        'phone' => 'nullable|string|max:8',
        'grade' => 'nullable|string|max:12',
        'student_group_id' => 'nullable|exists:student_groups,id',
        'new_group_title' => 'nullable|string|max:100',
    ]);

    $teacherId = Auth::id();

    if ($request->filled('new_group_title')) {
        $group = StudentGroup::create([
            'title' => $request->new_group_title,
            'teacher_id' => $teacherId,
        ]);
        $groupId = $group->id;
    } else {
        $groupId = $request->student_group_id;
    }

    $student->update([
        'name' => $request->name,
        'phone' => $request->phone,
        'grade' => $request->grade,
        'student_group_id' => $groupId,
    ]);
        return redirect()->route('dashboard')
            ->with('success', 'تم تحديث بيانات الطالب بنجاح');
    }


    public function destroy(Student $student)
    {

        $student->delete();

        return back()->with('success', 'تم حذف الطالب بنجاح!');
    }

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
}
