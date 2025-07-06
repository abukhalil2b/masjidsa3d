<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentGroupController;
use App\Http\Controllers\AssignmentController;

use App\Http\Controllers\TaskController;
use App\Http\Controllers\StudentTaskController; // Ensure this is correctly used for assignment
use Illuminate\Support\Facades\Route;

// --- Public Routes ---
Route::get('/', function () {
    return view('welcome');
});

// --- Authenticated Routes ---
Route::middleware('auth')->group(function () {

    // Dashboard Route
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');



    Route::get('assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::post('assignments', [AssignmentController::class, 'store'])->name('assignments.store');

    // Student marks task as done
    Route::post('students/{student}/tasks/{task}/done', [StudentTaskController::class, 'markDone'])->name('student_tasks.markDone');




    // Evaluation routes (related to student_tasks)
    Route::prefix('student-tasks')->name('student-tasks.')->group(function () {

        // Show form to evaluate a specific student task
        Route::get('{student}/task/{task}/evaluate', [TaskController::class, 'evaluateForm'])
            ->name('evaluate.form');

        // Store evaluation (achieved_point + done_at)
        Route::put('evaluate', [TaskController::class, 'storeEvaluation'])
            ->name('evaluate.store');
    });

    // Evaluation index — list all tasks that have student submissions
    Route::get('/tasks/evaluate', [TaskController::class, 'evaluateIndex'])
        ->name('tasks.evaluate.index');
    // Resource routes for TaskController (excluding create/edit views)
    Route::resource('tasks', TaskController::class)->except(['create', 'edit']);




    // Attendance Routes
    Route::get('attendances/index', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('attendances/create', [AttendanceController::class, 'create'])->name('attendances.create');
    Route::post('attendances/store', [AttendanceController::class, 'store'])->name('attendances.store');
    Route::get('attendances/{attendance}', [AttendanceController::class, 'show'])->name('attendances.show');
    Route::put('attendances/{attendance}', [AttendanceController::class, 'update'])->name('attendances.update');

    // Student Management Routes
    // Assuming you have an 'index' method for students somewhere,
    // otherwise, you might need a full resource for students or adjust as needed.
    Route::get('students/show_tasks/{student}', [StudentController::class, 'showTasks'])->name('students.show_tasks');

    Route::post('students/store', [StudentController::class, 'store'])->name('students.store');
    Route::patch('students/update/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('students/destroy/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

    Route::post('teachers/store', [TeacherController::class, 'store'])->name('teachers.store');
    Route::patch('teachers/update/{student}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('teachers/destroy/{student}', [TeacherController::class, 'destroy'])->name('teachers.destroy');

    Route::get('student_groups/index', [StudentGroupController::class, 'index'])->name('student_groups');
    Route::patch('student_groups/{group}/update_title', [StudentGroupController::class, 'updateTitle'])->name('student_groups.update_title');
    Route::post('student_groups', [StudentGroupController::class, 'store'])->name('student_groups.store');
});


Route::get('attendance_all_student', [AttendanceController::class, 'attendanceAllStudent'])->name('attendance_all_student');

Route::get('task_student/{group_id}', [AttendanceController::class, 'taskStudent'])->name('task_student');


require __DIR__ . '/auth.php';
