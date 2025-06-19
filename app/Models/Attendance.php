<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
   protected $guarded = [];

   public function students()
   {
      return $this->belongsToMany(Student::class, 'student_attendances')
         ->withPivot('attend_at')
         ->withTimestamps();
   }

   public function studentAttendances()
   {
      return $this->hasMany(StudentAttendance::class);
   }
}
