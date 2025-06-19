<x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-teacher')">
    إضافة معلم
</x-primary-button>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if ($teachers->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-right">{{ __('الاسم') }}</th>
                                    <th class="px-6 py-3 text-right">{{ __('الإجراءات') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teachers as $teacher)
                                    <tr>
                                        <td class="px-6 py-4">{{ $teacher->name }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <x-primary-button x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'edit-teacher-{{ $teacher->id }}')"
                                                class="text-sm">
                                                {{ __('تعديل') }}
                                            </x-primary-button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $teachers->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900"> لا يوجد معلم </h3>
                        <p class="mt-1 text-sm text-gray-500">ابدأ بإضافة معلم </p>
                        <div class="mt-6">
                            <x-primary-button x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'create-teacher')">
                                إضافة معلم
                            </x-primary-button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Create teacher Modal -->
<x-modal name="create-teacher" :show="$errors->isNotEmpty()" focusable>
    <form method="POST" action="{{ route('teachers.store') }}" class="p-6">
        @csrf

        <div>
            <x-input-label for="name" :value="'اسم المعلم واسم المستخدم وكلمة المرور'" />
            <label class="block font-medium text-sm text-gray-700"></label>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <x-primary-button class="ms-4">
            اضافة معلم جديد
        </x-primary-button>
    </form>
</x-modal>

<!-- Edit teacher Modals -->
@foreach ($teachers as $teacher)
    <x-modal name="edit-teacher-{{ $teacher->id }}" focusable>
        <form method="POST" action="{{ route('teachers.update', $teacher->id) }}" class="p-6">
            @csrf
            @method('PATCH')
            <h2 class="text-lg font-medium text-gray-900"> تعديل </h2>

            <div class="mt-6 space-y-6">
                <x-input-label for="edit-name-{{ $teacher->id }}" value="اسم المعلم" />
                <x-text-input id="edit-name-{{ $teacher->id }}" name="name" type="text"
                    class="mt-1 block w-full" value="{{ $teacher->name }}" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    إلغاء
                </x-secondary-button>

                <x-primary-button class="mr-3">
                    حفظ
                </x-primary-button>
            </div>
        </form>
    </x-modal>
@endforeach
