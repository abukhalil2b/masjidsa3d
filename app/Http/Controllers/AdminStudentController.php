<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentGroup;
use App\Models\StudentTask;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminStudentController extends Controller
{
    public function index(StudentGroup $student_group)
    {

        $studentGroups = StudentGroup::all();

        $students = Student::where('student_group_id', $student_group->id)->get();

        return view('admin.students.index', compact('students', 'student_group','studentGroups'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:8',
            'grade' => 'nullable|string|max:12',
            'student_group_id' => 'nullable|exists:student_groups,id',
        ]);

        $teacherId = Auth::id();

        $groupId = $request->student_group_id;

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
        return back()
            ->with('success', 'تم تحديث بيانات الطالب بنجاح');
    }


    public function destroy(Student $student)
    {

        $student->delete();

        return back()->with('success', 'تم حذف الطالب بنجاح!');
    }
    
}
