<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title',50);
            $table->foreignIdFor(User::class,'teacher_id')->constrained('users')->onDelete('cascade');
        });

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_group_id')->constrained('student_groups')->onDelete('cascade');
            $table->string('name',100);
            $table->string('phone',8)->nullable();
            $table->string('grade',12)->nullable();
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_groups');
        Schema::dropIfExists('students');
    }
};
