<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentGroup extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function taskGroups()
    {
        return $this->belongsToMany(TaskGroup::class, 'group_task_assignments', 'student_group_id', 'task_group_id');
    }
}
