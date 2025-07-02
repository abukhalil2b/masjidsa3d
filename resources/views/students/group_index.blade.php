<x-app-layout>
    <x-slot name="header">
        <h2 class="text-md font-semibold text-gray-800">إدارة المجموعات</h2>
    </x-slot>
   <div class="py-3">
     <x-primary-button x-data x-on:click.prevent="$dispatch('open-modal', 'create-student-group')">
        {{ __('إضافة مجموعة طلاب') }}
    </x-primary-button>

   </div>

    @forelse ($studentGroups as $group)
        <div class="bg-white shadow-lg rounded-xl p-6 mb-8 border border-gray-100">
    <form method="POST" action="{{ route('student_groups.update_title', $group->id) }}"
        class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b pb-5">
        @csrf
        @method('PATCH')

        <input type="text" name="title" value="{{ $group->title }}"
            class="w-full sm:max-w-sm px-4 py-2 text-sm rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />

        <x-primary-button class="w-full sm:w-auto px-6 py-2 text-sm font-semibold rounded-md shadow-sm">
            {{ __('تحديث الاسم') }}
        </x-primary-button>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-gray-700 mt-6">
        <div class="flex items-center gap-3">
            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <div>
                <p class="text-gray-500 font-medium">{{ __('عدد الطلاب') }}</p>
                <p class="text-gray-900 font-semibold text-base">{{ $group->students_count }}</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                </path>
            </svg>
            <div>
                <p class="text-gray-500 font-medium">{{ __('عدد المهام المربوطة') }}</p>
                <p class="text-gray-900 font-semibold text-base">{{ $group->task_groups_count }}</p>
            </div>
        </div>
    </div>
</div>

    @empty
        <div class="bg-white shadow-md rounded-lg p-6 text-center text-gray-600">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                aria-hidden="true">
                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10v11h18V10M6 6v2m8-2v2m6-4H6a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H6z">
                </path>
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
