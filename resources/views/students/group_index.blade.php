<x-app-layout>
    <x-slot name="header">
        <h2 class="text-md font-semibold text-gray-800">إدارة المجموعات</h2>
    </x-slot>
    <x-primary-button x-data x-on:click.prevent="$dispatch('open-modal', 'create-student-group')">
        {{ __('إضافة مجموعة طلاب') }}
    </x-primary-button>


        @forelse ($studentGroups as $group)
            <div class="bg-white shadow-md rounded-lg mb-6 p-4">
                <form method="POST" action="{{ route('student_groups.update_title', $group->id) }}"
                    class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4 mb-4 border-b pb-4">
                    @csrf
                    @method('PATCH')

                    <input type="text" name="title" value="{{ $group->title }}"
                        class="border-gray-300 rounded-md w-full sm:max-w-xs px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" />

                    <x-primary-button class="shrink-0 w-full sm:w-auto text-xs py-2 px-4">
                        {{ __('تحديث الاسم') }}
                    </x-primary-button>
                </form>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700 mb-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h-2v-2a4 4 0 00-8 0v2H7a2 2 0 01-2-2V9a2 2 0 012-2h10a2 2 0 012 2v9a2 2 0 01-2 2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.5 14h5"></path>
                        </svg>
                        <span class="font-semibold">{{ __('عدد الطلاب:') }}</span>
                        <span class="text-gray-900">{{ $group->students_count }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span class="font-semibold">{{ __('عدد المهام المربوطة:') }}</span>
                        <span class="text-gray-900">{{ $group->task_groups_count }}</span>
                    </div>
                </div>

            </div>
        @empty
            <div class="bg-white shadow-md rounded-lg p-6 text-center text-gray-600">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10v11h18V10M6 6v2m8-2v2m6-4H6a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H6z"></path>
                </svg>
                <p class="mt-4 text-lg font-medium">
                    {{ __('لا توجد مجموعات طلاب حالياً.') }}
                </p>
                <p class="mt-1 text-sm">
                    {{ __('ابدأ بإنشاء مجموعات لطلابك لتنظيمهم.') }}
                </p>
            </div>
        @endforelse
    </div>

    <x-modal name="create-student-group" :show="$errors->any()" focusable>
        <form method="POST" action="{{ route('student_groups.store') }}" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                {{ __('إضافة مجموعة طلاب جديدة') }}
            </h2>

            <div class="mb-4">
                <x-input-label for="title" :value="__('اسم المجموعة')" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required
                    autofocus />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div class="flex gap-1 justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('إلغاء') }}
                </x-secondary-button>

                <x-primary-button class="ml-3">
                    {{ __('حفظ') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

</x-app-layout>
