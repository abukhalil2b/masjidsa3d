<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('المهام') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <x-alert type="success" :message="session('success')" class="mb-4" />
            @endif

            <div class="mb-6 flex justify-end items-center space-x-4 rtl:space-x-reverse">

                <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-task')">
                    {{ __('إضافة مهمة جديدة') }}
                </x-primary-button>
                <a href="{{ route('assignments.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-md font-semibold text-xs text-white
                    bg-gray-800 border border-transparent 
                    hover:bg-gray-700">
                    ربط المهام بالطلاب
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($tasks->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-right">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-sm font-medium text-gray-700">عنوان المهمة</th>
                                        <th class="px-4 py-2 text-sm font-medium text-gray-700">النقاط</th>
                                        <th class="px-4 py-2 text-sm font-medium text-gray-700">الطلاب</th>
                                        <th class="px-4 py-2 text-sm font-medium text-gray-700">المجموعة</th>
                                        <th class="px-4 py-2 text-sm font-medium text-gray-700">حذف</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-800">{{ $task->title }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">{{ $task->point }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">
                                                <x-primary-button-link
                                                    href="{{ route('tasks.show', $task->id) }}">show</x-primary-button-link>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-600">{{ $task->group->title ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                <form method="POST" action="{{ route('tasks.destroy', $task->id) }}"
                                                    x-data x-ref="deleteForm"
                                                    @submit.prevent="if (confirm('هل أنت متأكد من رغبتك في حذف هذه المهمة؟')) $refs.deleteForm.submit();">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-danger-button type="submit">
                                                        {{ __('حذف') }}
                                                    </x-danger-button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">{{ __('لا توجد مهام') }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ __('ابدأ بإضافة مهمة جديدة') }}</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <x-modal name="create-task" focusable>
        <form method="POST" action="{{ route('tasks.store') }}" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-gray-900">{{ __('إضافة مهمة جديدة') }}</h2>

            <div class="mt-6 space-y-4">
                <div>
                    <x-input-label for="title" value="{{ __('عنوان المهمة') }}" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="point" value="{{ __('النقاط') }}" />
                    <x-text-input id="point" name="point" type="number" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('point')" class="mt-2" />
                </div>
            </div>

            <div x-data="{ newGroup: false }" class="mt-6">
                <x-input-label for="task_group_id" value="اختر مجموعة" />
                <select id="task_group_id" name="task_group_id" x-show="!newGroup"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">اختر مجموعة</option>
                    @foreach ($taskGroups as $group)
                        <option value="{{ $group->id }}">{{ $group->title }}</option>
                    @endforeach
                </select>

                <x-input-error :messages="$errors->get('task_group_id')" class="mt-2" />

                <button type="button" class="text-sm text-indigo-600 mt-2" x-show="!newGroup"
                    x-on:click="newGroup = true">
                    {{ __('أو إنشاء مجموعة جديدة') }}
                </button>

                <div x-show="newGroup" class="mt-4">
                    <x-input-label for="new_group_title" value="{{ __('اسم المجموعة الجديدة') }}" />
                    <x-text-input id="new_group_title" name="new_group_title" type="text"
                        class="mt-1 block w-full" />

                    <x-input-error :messages="$errors->get('new_group_title')" class="mt-2" />

                    <button type="button" class="text-sm text-red-600 mt-2" x-on:click="newGroup = false">
                        {{ __('اختر من المجموعات الموجودة بدلاً من ذلك') }}
                    </button>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3 rtl:space-x-reverse">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('إلغاء') }}
                </x-secondary-button>

                <x-primary-button>
                    {{ __('حفظ') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>


</x-app-layout>
