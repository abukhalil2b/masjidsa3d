<x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-student')">
    إضافة طالب
</x-primary-button>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-2 lg:px-6">
        @if ($students->count())
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right">{{ __('الاسم') }}</th>
                            <th class="px-4 py-3 text-right">{{ __('المجموعة') }}</th>
                            <th class="px-4 py-3 text-right">{{ __('الإجراءات') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td class="px-4 py-4">{{ $student->name }}</td>
                                <td class="px-4 py-4">{{ $student->group->title ?? '-' }}</td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-3"> {{-- Use flex to align buttons --}}
                                        <x-secondary-button x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'edit-student-{{ $student->id }}')"
                                            class="text-xs px-3 py-1.5" {{-- Adjusted padding for a friendlier look --}}>
                                            {{ __('تعديل') }}
                                        </x-secondary-button>

                                        <a href="{{ route('students.show_tasks', $student->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            {{ __('المهام') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $students->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">{{ __('لا يوجد طلاب') }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ __('ابدأ بإضافة طلاب جديدين') }}</p>
                <div class="mt-6">
                    <x-primary-button x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'create-student')">
                        {{ __('إضافة طالب') }}
                    </x-primary-button>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Create Student Modal -->
<x-modal name="create-student" :show="$errors->isNotEmpty()" focusable>
    <form method="POST" action="{{ route('students.store') }}" class="p-6">
        @csrf
        <h2 class="text-lg font-medium text-gray-900">{{ __('إضافة طالب جديد') }}</h2>

        <div class="mt-6 space-y-6">
            <div>
                <x-input-label for="name" value="{{ __('اسم الطالب') }}" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="phone" value="{{ __('رقم الهاتف') }}" />
                <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="grade" value="{{ __('الصف الدراسي') }}" />
                <select id="grade" name="grade"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">{{ __('اختر الصف') }}</option>
                    @foreach (range(1, 12) as $grade)
                        <option value="الصف {{ $grade }}">الصف {{ $grade }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('grade')" class="mt-2" />
            </div>
        </div>

        <div x-data="{ newGroup: false }" class="mt-6">
            <x-input-label for="student_group_id" value="اختر مجموعة أو الصف مثلا" />
            <select id="student_group_id" name="student_group_id" x-show="!newGroup"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">اختر مجموعة</option>
                @foreach ($studentGroups as $group)
                    <option value="{{ $group->id }}">{{ $group->title }}</option>
                @endforeach
            </select>

            <x-input-error :messages="$errors->get('student_group_id')" class="mt-2" />

            <button type="button" class="text-sm text-indigo-600 mt-2" x-show="!newGroup" x-on:click="newGroup = true">
                {{ __('أو إنشاء مجموعة جديدة') }}
            </button>

            <div x-show="newGroup" class="mt-4">
                <x-input-label for="new_group_title" value="{{ __('اسم المجموعة الجديدة') }}" />
                <x-text-input id="new_group_title" name="new_group_title" type="text" class="mt-1 block w-full" />

                <x-input-error :messages="$errors->get('new_group_title')" class="mt-2" />

                <button type="button" class="text-sm text-red-600 mt-2" x-on:click="newGroup = false">
                    {{ __('اختر من المجموعات الموجودة بدلاً من ذلك') }}
                </button>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('إلغاء') }}
            </x-secondary-button>

            <x-primary-button class="mr-3">
                {{ __('حفظ') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>

<!-- Edit Student Modals -->
@foreach ($students as $student)
    <x-modal name="edit-student-{{ $student->id }}" focusable>
        <form method="POST" action="{{ route('students.update', $student->id) }}" class="p-6">
            @csrf
            @method('PATCH')
            <h2 class="text-lg font-medium text-gray-900">{{ __('تعديل الطالب') }}</h2>

            <div class="mt-6 space-y-6">
                <div>
                    <x-input-label for="edit-name-{{ $student->id }}" value="{{ __('اسم الطالب') }}" />
                    <x-text-input id="edit-name-{{ $student->id }}" name="name" type="text"
                        class="mt-1 block w-full" value="{{ $student->name }}" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="edit-phone-{{ $student->id }}" value="{{ __('رقم الهاتف') }}" />
                    <x-text-input id="edit-phone-{{ $student->id }}" name="phone" type="tel"
                        class="mt-1 block w-full" value="{{ $student->phone }}" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="edit-grade-{{ $student->id }}" value="{{ __('الصف الدراسي') }}" />
                    <select id="edit-grade-{{ $student->id }}" name="grade"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">{{ __('اختر الصف') }}</option>
                        @foreach (range(1, 12) as $grade)
                            <option value="الصف {{ $grade }}" @selected($student->grade == 'الصف ' . $grade)>
                                الصف {{ $grade }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('grade')" class="mt-2" />
                </div>
            </div>

            <div x-data="{ newGroup: false }" class="mt-6">
                <x-input-label for="edit-student-group-{{ $student->id }}" value="{{ __('اختر مجموعة') }}" />
                <select id="edit-student-group-{{ $student->id }}" name="student_group_id" x-show="!newGroup"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">{{ __('اختر مجموعة') }}</option>
                    @foreach ($studentGroups as $group)
                        <option value="{{ $group->id }}" @selected($student->student_group_id == $group->id)>
                            {{ $group->title }}
                        </option>
                    @endforeach
                </select>

                <x-input-error :messages="$errors->get('student_group_id')" class="mt-2" />

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

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('إلغاء') }}
                </x-secondary-button>

                <x-primary-button class="mr-3">
                    {{ __('حفظ التعديلات') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
@endforeach
