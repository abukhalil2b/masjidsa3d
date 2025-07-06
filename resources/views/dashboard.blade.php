<x-app-layout>

    @if (session('success'))
        <x-alert type="success" :message="session('success')" class="mb-4" />
    @endif
    <a href="{{ route('attendance_all_student') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">كشف الحضور لكل الطلاب</a>
    <a href="{{ route('task_student',1) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">كشف المهام المجموعة 1 </a>
    <a href="{{ route('task_student',2) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">كشف المهام المجموعة 2 </a>
    <a href="{{ route('task_student',3) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">كشف المهام المجموعة 3 </a>
    @if ($loggedUser->role == 'teacher')
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('الطلاب') }}
                </h2>
            </div>
        </x-slot>
        @include('inc._teacher_dashboard')
    @endif

    @if ($loggedUser->role == 'admin')
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('المعلمين') }}
                </h2>
            </div>
        </x-slot>
        @include('inc._admin_dashboard')
    @endif

</x-app-layout>
