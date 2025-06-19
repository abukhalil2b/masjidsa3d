<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StudentGroup;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function dashboard()
    {
        $loggedUser = Auth::user();

        if ($loggedUser->role == 'admin') {
            return $this->adminDashboard($loggedUser);
        }

        if ($loggedUser->role == 'teacher') {
            return $this->teacherDashboard($loggedUser);
        }
        abort(403);
    }

    private function adminDashboard($loggedUser)
    {
        $teachers = User::where('role', 'teacher')->paginate(50);
        return view('dashboard', compact('teachers', 'loggedUser'));
    }

    private function teacherDashboard($loggedUser)
    {
        $studentGroups = StudentGroup::where('teacher_id', $loggedUser->id)->get();

        $students = Student::with('group')->where('teacher_id', $loggedUser->id)->paginate(50);

        return view('dashboard', compact('students', 'loggedUser', 'studentGroups'));
    }



    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required'
        ]);

        $request->user()->name = $request->name;

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
}
