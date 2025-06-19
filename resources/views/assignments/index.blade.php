<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            ربط المهام بالمجموعات
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <x-alert type="success" :message="session('success')" class="mb-4" />
            @endif

            <div class="bg-white p-6 shadow rounded-lg">
                <h3 class="text-lg font-medium text-gray-700 mb-4">
                    ربط مجموعة مهام بمجموعة طلاب
                </h3>

                <form method="POST" action="{{ route('assignments.store') }}">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="student_group_id" :value="__('اختر مجموعة طلاب')" />
                        <select name="student_group_id" id="student_group_id"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">{{ __('اختر...') }}</option>
                            @foreach ($studentGroups as $group)
                                <option value="{{ $group->id }}">{{ $group->title }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('student_group_id')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="task_group_id" :value="__('اختر مجموعة مهام')" />
                        <select name="task_group_id" id="task_group_id"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">{{ __('اختر...') }}</option>
                            @foreach ($taskGroups as $group)
                                <option value="{{ $group->id }}">{{ $group->title }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('task_group_id')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-primary-button>
                            ربط المجموعة
                        </x-primary-button>
                    </div>
                </form>
            </div>

            @if ($assignments->count())
                <div class="bg-white mt-8 p-6 shadow rounded-lg">
                    <h3 class="text-md font-semibold text-gray-800 mb-4">المجموعات المرتبطة:</h3>
                    <table class="min-w-full text-sm text-right border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2 border">مجموعة الطلاب</th>
                                <th class="p-2 border">مجموعة المهام</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignments as $assignment)
                                <tr>
                                    <td class="p-2 border">{{ $assignment->studentGroup->title }}</td>
                                    <td class="p-2 border">{{ $assignment->taskGroup->title }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</x-app-layout>
