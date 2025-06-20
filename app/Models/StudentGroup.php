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
}
