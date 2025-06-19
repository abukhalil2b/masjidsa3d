<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $guarded = [];

    public $timestamps = false;
 
    public function studentTasks()
    {
        return $this->hasMany(StudentTask::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(TaskGroup::class,'task_group_id');
    }
}
