<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);

        User::create([
            'role' => 'teacher',
            'name' => $request->name,
            'email' => $request->name,
            'password' => Hash::make($request->name),
            'plain_password' => $request->name,
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:100'
        ]);

        $student->update($validated);

        return redirect()->route('dashboard')
            ->with('success', 'تم تحديث بيانات المعلم بنجاح');
    }


    public function destroy(Student $student)
    {

        $student->delete();

        return back()->with('success', 'تم حذف المعلم بنجاح!');
    }
}
