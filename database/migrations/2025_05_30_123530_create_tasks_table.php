<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->foreignIdFor(User::class, 'teacher_id')->constrained('users')->onDelete('cascade');
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->unsignedTinyInteger('point');
            $table->foreignId('task_group_id')->constrained('task_groups')->onDelete('cascade');
        });

        Schema::create('student_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
            $table->unsignedTinyInteger('achieved_point')->nullable();
            $table->timestamp('done_at')->nullable();
        });

        Schema::create('group_task_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_group_id')->constrained()->onDelete('cascade');
            $table->foreignId('task_group_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_task_assignments');
        Schema::dropIfExists('task_groups');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('student_tasks');
    }
};
