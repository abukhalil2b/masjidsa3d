<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'student_tasks')
            ->withPivot('achieved_point')
            ->withTimestamps();
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function group()
    {
        return $this->belongsTo(StudentGroup::class, 'student_group_id');
    }

    public function attendances()
    {
        return $this->belongsToMany(Attendance::class, 'student_attendances')
            ->withPivot('attend_at')
            ->withTimestamps();
    }

    public function studentTasks()
    {
        return $this->hasMany(StudentTask::class);
    }

    // This relationship is key to finding all tasks a student *should* have
    public function assignedTasks()
    {
        return $this->belongsToMany(Task::class,
            'group_task_assignments', // The pivot table name
            'student_group_id',       // Foreign key on pivot for StudentGroup
            'task_id',                // Foreign key on pivot for Task (indirectly through task_groups)
            'student_group_id',       // Local key on Student
            'task_group_id'           // Local key on Task (indirectly)
        )
        ->using(GroupTaskAssignment::class) // If you have a pivot model
        ->withPivot('task_group_id') // Include task_group_id from the pivot if needed
        ->join('tasks', 'group_task_assignments.task_group_id', '=', 'tasks.task_group_id')
        ->select('tasks.*'); // Select all columns from tasks
    }

    // Alternative: Get all task groups assigned to the student's group
    public function assignedTaskGroups()
    {
        return $this->belongsToMany(TaskGroup::class, 'group_task_assignments', 'student_group_id', 'task_group_id', 'student_group_id', 'id');
    }
}
