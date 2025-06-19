<?php

namespace App\Policies;

use App\Models\StudentTask;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StudentPolicy
{
    public function assignTask(User $user, Student $student): Response|bool
    {
        // Only the student's teacher can assign tasks
        return $user->id === $student->teacher_id
                    ? Response::allow()
                    : Response::deny('You do not own this student.'); // Optional: Custom denial message
    }

}
