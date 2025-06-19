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
}
