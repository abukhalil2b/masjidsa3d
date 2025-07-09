<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center px-2">
            <h2 class="font-bold text-lg text-gray-800">
                {{ __('المهام') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6" x-data="{ selectedGroup: '' }">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="mb-4 flex flex-col sm:flex-row justify-between items-center gap-2 px-2">
                <x-primary-button x-data x-on:click.prevent="$dispatch('open-modal', 'create-task')"
                    class="text-xs px-3 py-1">
                    <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __('إضافة') }}
                </x-primary-button>

                <a href="{{ route('assignments.index') }}"
                    class="text-xs px-3 py-1 rounded-md font-medium text-white bg-gray-800 hover:bg-gray-700 transition duration-150 ease-in-out">
                    ربط المهام بالطلاب
                </a>
            </div>

            <div class="mb-6 px-2 flex flex-col sm:flex-row items-center gap-2 text-sm">
                <label for="groupFilter" class="text-gray-700 font-medium">تصفية حسب الالبرنامج:</label>
                <select id="groupFilter" name="group" x-model="selectedGroup"
                    class="w-full sm:w-auto border-gray-300 rounded-md shadow-sm text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">الكل</option>
                    @foreach ($taskGroups as $group)
                        <option value="{{ $group->id }}">{{ $group->title }}</option>
                    @endforeach
                </select>
            </div>

            @if ($tasks->count())
                <div class="grid gap-4 md:hidden px-2">
                    @foreach ($tasks as $task)
                        <div class="bg-white rounded-lg shadow-md p-3 border border-gray-100 text-sm"
                            x-show="selectedGroup === '' || selectedGroup == {{ $task->group->id ?? 'null' }}">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-semibold text-gray-800">{{ $task->title }}</h3>
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 font-medium">
                                    {{ $task->point }} نقاط
                                </span>
                            </div>

                            <div class="flex justify-between items-center text-xs text-gray-600">
                                <span class="font-medium">الالبرنامج:</span>
                                @php
                                    $groupColor = [
                                        'bg-green-100 text-green-700',
                                        'bg-yellow-100 text-yellow-700',
                                        'bg-pink-100 text-pink-700',
                                        'bg-purple-100 text-purple-700',
                                        'bg-red-100 text-red-700',
                                        'bg-indigo-100 text-indigo-700',
                                    ];
                                    $colorIndex = ($task->group->id ?? 0) % count($groupColor); // Use group ID for consistent color
                                    $color = $groupColor[$colorIndex];
                                @endphp
                                <span class="px-2 py-0.5 rounded-full {{ $color }} font-medium">
                                    {{ $task->group->title ?? 'بدون البرنامج' }}
                                </span>
                            </div>

                            <div class="mt-4 flex flex-col gap-2">
                                <x-primary-button-link href="{{ route('tasks.show', $task->id) }}"
                                    class="text-xs text-center py-1.5 w-full justify-center">
                                    الطلاب
                                </x-primary-button-link>

                                <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" x-data
                                    x-ref="deleteForm"
                                    @submit.prevent="if (confirm('هل أنت متأكد من رغبتك في حذف هذه المهمة؟')) $refs.deleteForm.submit();">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button type="submit" class="w-full text-xs py-1.5 justify-center">
                                        حذف
                                    </x-danger-button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="hidden md:grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 px-2">
                    @foreach ($tasks as $task)
                        <div class="bg-white rounded-lg shadow-md p-4 border border-gray-100 text-sm"
                            x-show="selectedGroup === '' || selectedGroup == {{ $task->group->id ?? 'null' }}">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-bold text-gray-900 text-base">{{ $task->title }}</h3>
                                <span class="text-xs p-1 min-w-[24px] h-6 flex items-center justify-center rounded-full bg-blue-100 text-blue-800 font-semibold">
                                    {{ $task->point }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-xs text-gray-600 mb-4">
                                <span class="font-medium">الالبرنامج:</span>
                                @php
                                    $groupColor = [
                                        'bg-green-100 text-green-700',
                                        'bg-yellow-100 text-yellow-700',
                                        'bg-pink-100 text-pink-700',
                                        'bg-purple-100 text-purple-700',
                                        'bg-red-100 text-red-700',
                                        'bg-indigo-100 text-indigo-700',
                                    ];
                                    $colorIndex = ($task->group->id ?? 0) % count($groupColor); // Use group ID for consistent color
                                    $color = $groupColor[$colorIndex];
                                @endphp
                                <span class="px-2 py-0.5 rounded-full {{ $color }} font-medium">
                                    {{ $task->group->title ?? 'بدون البرنامج' }}
                                </span>
                            </div>

                            <div class="flex gap-2 justify-end">
                                <a class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    href="{{ route('tasks.show', $task->id) }}">الطلاب</a>
                                <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" x-data
                                    x-ref="deleteForm"
                                    @submit.prevent="if (confirm('هل أنت متأكد من رغبتك في حذف هذه المهمة؟')) $refs.deleteForm.submit();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        حذف
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 text-sm text-gray-500">
                    <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                    </svg>
                    <p class="mt-3">لا توجد مهام حالياً</p>
                </div>
            @endif
        </div>
    </div>

    <x-modal name="create-task" focusable>
        <form method="POST" action="{{ route('tasks.store') }}" class="p-6 text-sm">
            @csrf
            <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('إضافة مهمة جديدة') }}</h2>

            <div class="space-y-4">
                <div>
                    <x-input-label for="title" value="{{ __('عنوان المهمة') }}" class="mb-1" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full text-sm"
                        required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2 text-xs" />
                </div>

                <div>
                    <x-input-label for="point" value="{{ __('النقاط') }}" class="mb-1" />
                    <x-text-input id="point" name="point" type="number" class="mt-1 block w-full text-sm"
                        required />
                    <x-input-error :messages="$errors->get('point')" class="mt-2 text-xs" />
                </div>
            </div>

            <div x-data="{ newGroup: false }" class="mt-5">
                <x-input-label for="task_group_id" value="اختر البرنامج" class="mb-1" />
                <select id="task_group_id" name="task_group_id" x-show="!newGroup"
                    class="mt-1 block w-full border-gray-300 focus:ring-indigo-500 text-sm rounded-md shadow-sm">
                    <option value="">اختر البرنامج</option>
                    @foreach ($taskGroups as $group)
                        <option value="{{ $group->id }}">{{ $group->title }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('task_group_id')" class="mt-2 text-xs" />

                <button type="button" class="text-indigo-600 text-xs mt-3 hover:text-indigo-800 transition duration-150 ease-in-out" x-show="!newGroup"
                    x-on:click="newGroup = true">
                    {{ __('أو إنشاء برنامج جديد') }}
                </button>

                <div x-show="newGroup" class="mt-3">
                    <x-input-label for="new_group_title" value="{{ __('اسم الالبرنامج الجديدة') }}" class="mb-1" />
                    <x-text-input id="new_group_title" name="new_group_title" type="text"
                        class="mt-1 block w-full text-sm" />
                    <x-input-error :messages="$errors->get('new_group_title')" class="mt-2 text-xs" />

                    <button type="button" class="text-red-600 text-xs mt-3 hover:text-red-800 transition duration-150 ease-in-out" x-on:click="newGroup = false">
                        {{ __('اختر من المجموعات الموجودة بدلاً من ذلك') }}
                    </button>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="text-xs px-4 py-2">
                    {{ __('إلغاء') }}
                </x-secondary-button>
                <x-primary-button class="text-xs px-4 py-2" type="submit">
                    {{ __('حفظ') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>