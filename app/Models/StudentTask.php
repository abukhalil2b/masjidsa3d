<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class StudentTask extends Pivot
{
    protected $table = 'student_tasks';
    protected $guarded = [];
    public $timestamps = false;
    protected $casts = [
        'done_at' => 'datetime',
    ];
    
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
