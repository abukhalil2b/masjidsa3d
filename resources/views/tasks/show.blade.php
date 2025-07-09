<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $task->title }}
        </h2>
        <div class="text-sm text-gray-600"> النقاط القصوى: {{ $task->point }}</div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            @if ($students->count())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6 text-gray-900">
                        <table class="min-w-full divide-y divide-gray-200 text-right text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-gray-600 font-semibold uppercase tracking-wider">اسم الطالب</th>
                                    <th class="px-4 py-3 text-gray-600 font-semibold uppercase tracking-wider">الحالة</th>
                                    <th class="px-4 py-3 text-gray-600 font-semibold uppercase tracking-wider">النقاط المحققة</th>
                                    <th class="px-4 py-3 text-gray-600 font-semibold uppercase tracking-wider">إجراء</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($students as $student)
                                    @php $studentTask = $studentTasks[$student->id] ?? null; @endphp
                                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                        <td class="px-4 py-3 text-gray-800">{{ $student->name }}</td>
                                        <td class="px-4 py-3">
                                            @if ($studentTask && $studentTask->achieved_point !== null)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    تم الإنجاز
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    لم يتم الإنجاز
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-gray-800 font-medium">
                                            {{ $studentTask->achieved_point ?? 'لم يتم التقييم' }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <x-primary-button x-data
                                                x-on:click.prevent="$dispatch('open-modal', 'evaluate-student-{{ $student->id }}')">
                                                تقييم
                                            </x-primary-button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10v11h18V10M6 6v2m8-2v2m6-4H6a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H6z"></path>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-700">لا يوجد طلاب</h3>
                        <p class="mt-1 text-sm text-gray-500">لا يوجد طلاب في المجموعة المرتبطة بهذه المهمة.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @foreach ($students as $student)
        @php $studentTask = $studentTasks[$student->id] ?? null; @endphp

        <x-modal name="evaluate-student-{{ $student->id }}" focusable>
            <form method="POST" action="{{ route('student_tasks.evaluate.store') }}" class="p-6" x-data="{ achievedPoint: {{ $studentTask->achieved_point ?? 'null' }} }">
                @csrf
                @method('PUT')

                <input type="hidden" name="student_id" value="{{ $student->id }}">
                <input type="hidden" name="task_id" value="{{ $task->id }}">
                <input type="hidden" name="achieved_point" x-model="achievedPoint">

                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    تقييم الطالب: <span class="text-indigo-600">{{ $student->name }}</span>
                </h2>

                <p class="mb-4 text-gray-700">اختر النقاط المحققة (الحد الأقصى: {{ $task->point }} نقاط):</p>

                <div class="grid grid-cols-5 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-10 gap-3 mb-6">
                    @for ($i = 0; $i <= $task->point; $i++)
                        <button type="button"
                            @click="achievedPoint = {{ $i }}"
                            :class="{ 'bg-indigo-600 text-white shadow-lg': achievedPoint == {{ $i }}, 'bg-gray-200 text-gray-800 hover:bg-gray-300': achievedPoint != {{ $i }} }"
                            class="flex items-center justify-center w-10 h-10 rounded-full font-semibold text-lg transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            {{ $i }}
                        </button>
                    @endfor
                   
                    @if ($task->point > 0)
                        <button type="button"
                            @click="achievedPoint = null"
                            :class="{ 'bg-red-600 text-white shadow-lg': achievedPoint === null, 'bg-gray-200 text-gray-800 hover:bg-gray-300': achievedPoint !== null }"
                            class="flex items-center justify-center w-10 h-10 rounded-full font-semibold text-xs transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        >
                            مسح
                        </button>
                    @endif
                </div>

                <div class="mb-6 text-center text-lg font-bold text-gray-800">
                    النقاط المختارة: <span x-text="achievedPoint !== null ? achievedPoint : 'لم يتم الاختيار'"></span>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button x-on:click="$dispatch('close')" type="button">
                        إلغاء
                    </x-secondary-button>
                    <x-primary-button type="submit">
                        حفظ التقييم
                    </x-primary-button>
                </div>
            </form>
        </x-modal>
    @endforeach
</x-app-layout>