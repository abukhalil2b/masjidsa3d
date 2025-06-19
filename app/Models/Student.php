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
}
