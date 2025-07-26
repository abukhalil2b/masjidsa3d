<x-app-layout>

    @if (session('success'))
        <x-alert type="success" :message="session('success')" class="mb-4" />
    @endif
   
    @if ($loggedUser->role == 'teacher')
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                   الطلاب
                </h2>
            </div>
        </x-slot>
        @include('inc._teacher_dashboard')
    @endif

    @if ($loggedUser->role == 'admin')
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                  المعلمين
                </h2>
            </div>
        </x-slot>
        @include('inc._admin_dashboard')
    @endif

</x-app-layout>
