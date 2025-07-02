<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskGroup extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }


    public function studentGroups()
    {
        return $this->belongsToMany(StudentGroup::class, 'group_task_assignments', 'task_group_id', 'student_group_id');
    }
}
