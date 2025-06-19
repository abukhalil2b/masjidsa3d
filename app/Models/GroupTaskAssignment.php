<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupTaskAssignment extends Model
{
    protected $guarded = [];

    public $timestamps = false;
    
    public function studentGroup()
    {
        return $this->belongsTo(StudentGroup::class);
    }

    public function taskGroup()
    {
        return $this->belongsTo(TaskGroup::class);
    }
}
