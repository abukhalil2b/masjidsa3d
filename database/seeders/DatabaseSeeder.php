<?php

namespace Database\Seeders;

use App\Models\Mission;
use App\Models\Task;
use App\Models\TaskGroup;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'role' => 'admin',
            'email' => 'abukhalil2b@gmail.com',
            'password' => Hash::make('abukhalil2b@gmail.com'),
        ]);

        User::create([
            'name' => 'إبراهيم',
            'role' => 'teacher',
            'email' => 'إبراهيم',
            'password' => Hash::make('إبراهيم'),
        ]);

        DB::table('student_groups')->insert([
            'title'=>'المجموعة الأولى',
            'teacher_id'=>2,
        ]);

        TaskGroup::create([
            'title'=>'برنامج المتقن',
            'teacher_id'=>2
        ]);

        Task::create([
            'title'=>"حفظ التوجيه",
            'point'=>5,
            'task_group_id'=>1,
        ]);

        Task::create([
            'title'=>"حفظ التحيات",
            'point'=>5,
            'task_group_id'=>1,
        ]);

        Task::create([
            'title'=>"حفظ سورة النباء من الآية 1 إلى الآية 5",
            'point'=>5,
            'task_group_id'=>1,
        ]);

        Task::create([
            'title'=>"حفظ سورة النباء من الآية 6 إلى الآية 10",
            'point'=>5,
            'task_group_id'=>1,
        ]);

        Task::create([
            'title'=>"حفظ سورة النباء من الآية 11 إلى الآية 15",
            'point'=>5,
            'task_group_id'=>1,
        ]);

        Task::create([
            'title'=>"حفظ سورة النباء من الآية 16 إلى الآية 20",
            'point'=>5,
            'task_group_id'=>1,
        ]);

    }
}
