<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">إدارة المجموعات</h2>
    </x-slot>
    <x-primary-button x-data x-on:click.prevent="$dispatch('open-modal', 'create-student-group')">
        {{ __('إضافة مجموعة طلاب') }}
    </x-primary-button>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        @forelse ($studentGroups as $group)
            <div class="bg-white shadow rounded-lg mb-6 p-6">
                <!-- Group Title Edit Form -->
                <form method="POST" action="{{ route('student_groups.update_title', $group->id) }}"
                    class="flex items-center justify-between gap-4 mb-4">
                    @csrf
                    @method('PATCH')

                    <input type="text" name="title" value="{{ $group->title }}"
                        class="border-gray-300 rounded-md w-full max-w-xs px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" />

                    <x-primary-button class="shrink-0">
                        تحديث الاسم
                    </x-primary-button>
                </form>

                @if ($group->students->count())
                    <table class="min-w-full divide-y divide-gray-200 text-right text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2">اسم الطالب</th>
                                <th class="px-4 py-2">الهاتف</th>
                                <th class="px-4 py-2">الصف الدراسي</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($group->students as $student)
                                <tr>
                                    <td class="px-4 py-2">{{ $student->name }}</td>
                                    <td class="px-4 py-2">{{ $student->phone ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $student->grade ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500 text-sm mt-2">لا يوجد طلاب في هذه المجموعة.</p>
                @endif
            </div>
        @empty
            <div class="bg-white shadow rounded-lg p-6 text-center text-gray-500">
                لا توجد مجموعات حتى الآن. قم بإضافة طلاب لتكوين مجموعات.
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

            <div class="flex justify-end">
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
