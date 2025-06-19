<?php

namespace App\Policies;

use App\Models\StudentTask;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StudentTaskPolicy
{
    
   public function recordPoints(User $user, StudentTask $studentTask): Response|bool
    {
        // Only the student's teacher can record points
        // Make sure the StudentTask model has a relationship to Student,
        // and the Student model has a 'teacher_id'.
        // For example, if StudentTask has a student_id, you can access it like:
        // $studentTask->student->teacher_id
        return $user->id === $studentTask->student->teacher_id
                    ? Response::allow()
                    : Response::deny('You are not authorized to record points for this task.'); // Optional: Custom denial message
    }
}
