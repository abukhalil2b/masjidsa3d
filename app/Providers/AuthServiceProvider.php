<?php

namespace App\Providers;

use App\Models\Student; // Import your Student model
use App\Models\StudentTask; // Import your StudentTask model
use App\Policies\StudentPolicy; // Import your StudentPolicy
use App\Policies\StudentTaskPolicy; // Import your StudentTaskPolicy
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Student::class => StudentPolicy::class,
        StudentTask::class => StudentTaskPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}