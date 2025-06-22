<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                الطلاب
            </h2>
        </div>
    </x-slot>

    @if ($students->count())
        <table class="min-w-full divide-y divide-gray-200 text-right">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">اسم الطالب</th>
                    <th class="px-4 py-2">الحالة</th>
                    <th class="px-4 py-2">إجراء</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($students as $student)
                    @php $studentTask = $studentTasks[$student->id] ?? null; @endphp
                    <tr>
                        <td class="px-4 py-2">{{ $student->name }}</td>
                        <td class="px-4 py-2">
                            @if ($studentTask)
                                <span class="text-green-600 font-semibold">تم الإنجاز</span>
                            @else
                                <span class="text-gray-500">لم يتم الإنجاز</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <x-primary-button x-data
                                x-on:click.prevent="$dispatch('open-modal', 'evaluate-student-{{ $student->id }}')">
                                تقييم
                            </x-primary-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center py-12">
            <h3 class="text-lg text-gray-700">لا يوجد طلاب في المجموعة المرتبطة بهذه المهمة</h3>
        </div>
    @endif

    @foreach ($students as $student)
        @php $studentTask = $studentTasks[$student->id] ?? null; @endphp

        <x-modal name="evaluate-student-{{ $student->id }}" focusable>
            <form method="POST" action="{{ route('student-tasks.evaluate.store') }}" class="p-6">
                @csrf
                @method('PUT')

                <input type="hidden" name="student_id" value="{{ $student->id }}">
                <input type="hidden" name="task_id" value="{{ $task->id }}">

                <h2 class="text-lg font-medium text-gray-900 mb-4">
                    تقييم الطالب: {{ $student->name }}
                </h2>

                <div>
                    <x-input-label for="achieved_point_{{ $student->id }}" value="النقاط المحققة" />
                    <x-text-input id="achieved_point_{{ $student->id }}" name="achieved_point" type="number"
                        step="0.1" class="mt-1 block w-full" value="{{ $studentTask?->achieved_point }}" required />
                    <x-input-error :messages="$errors->get('achieved_point')" class="mt-2" />
                </div>

                <div class="mt-6 flex gap-1 justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        إلغاء
                    </x-secondary-button>
                    <x-primary-button class="ml-3">
                        حفظ التقييم
                    </x-primary-button>
                </div>
            </form>
        </x-modal>
    @endforeach

</x-app-layout>
