<?php

use App\Http\Controllers\AdminStudentController;
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
    Route::put('student_tasks/evaluate/store', [StudentTaskController::class, 'evaluate'])->name('student_tasks.evaluate.store');


    // Evaluation index — list all tasks that have student submissions
    Route::get('/tasks/evaluate', [TaskController::class, 'evaluateIndex'])
        ->name('tasks.evaluate.index');

    // Resource routes for TaskController (excluding create/edit views)
    Route::resource('tasks', TaskController::class)->except(['create', 'edit']);


    Route::get('students/{student}/bulk-tasks', [StudentTaskController::class, 'bulkEdit'])->name('student_tasks.bulk.edit');
    Route::post('students/{student}/bulk-tasks', [StudentTaskController::class, 'bulkUpdate'])->name('student_tasks.bulk.update');


    // Attendance Routes
    Route::get('attendances/index', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('attendances/create', [AttendanceController::class, 'create'])->name('attendances.create');
    Route::post('attendances/store', [AttendanceController::class, 'store'])->name('attendances.store');
    Route::get('attendances/{attendance}', [AttendanceController::class, 'show'])->name('attendances.show');
    Route::put('attendances/{attendance}', [AttendanceController::class, 'update'])->name('attendances.update');

    Route::get('students/show_tasks/{student}', [StudentController::class, 'showTasks'])->name('students.show_tasks');

    // Student Management Routes
    Route::get('admin/students/index/{student_group}', [AdminStudentController::class, 'index'])->name('admin.students.index');
    Route::post('admin/students/store', [AdminStudentController::class, 'store'])->name('admin.students.store');
    Route::patch('admin/students/update/{student}', [AdminStudentController::class, 'update'])->name('admin.students.update');
    Route::delete('admin/students/destroy/{student}', [AdminStudentController::class, 'destroy'])->name('admin.students.destroy');

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
