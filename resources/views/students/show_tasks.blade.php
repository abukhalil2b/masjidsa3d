<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('مهام الطالب:') }} {{ $student->name }}
        </h2>
        <p class="text-sm text-gray-600">
            {{ __('المجموعة:') }} {{ $student->studentGroup->title ?? 'غير محددة' }}
        </p>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-2">
            @if ($studentTasksStatus->count() > 0)
                <div class="mb-6 bg-white p-4 sm:p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">
                        {{ __('إجمالي النقاط المحققة:') }}
                        <span class="text-green-600">{{ $totalAchievedPoints }}</span>
                    </h3>
                </div>

                <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6 text-gray-900">
                        <table class="min-w-full divide-y divide-gray-200 text-right text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-2 py-3 text-gray-600 font-semibold whitespace-nowrap">
                                        عنوان المهمة</th>
                                    <th class="px-2 py-3 text-gray-600 font-semibold whitespace-nowrap">
                                        تقييم</th>
                                    <th class="px-2 py-3 text-gray-600 font-semibold whitespace-nowrap">
                                        النقاط</th>
                                    <th class="px-2 py-3 text-gray-600 font-semibold whitespace-nowrap">
                                        تاريخ الإنجاز</th>

                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($studentTasksStatus as $taskStatus)
                                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                        <td class="px-2 py-3">
                                            <div
                                                class="{{ $taskStatus->achieved_point > 0 ? 'text-green-500' : 'text-gray-400' }}">
                                                {{ $taskStatus->task->title }}
                                            </div>
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap">
                                            <x-primary-button x-data
                                                x-on:click.prevent="$dispatch('open-modal', 'evaluate-task-{{ $taskStatus->task->id }}')">
                                                تقييم
                                            </x-primary-button>
                                        </td>
                                        <td class="px-2 py-3 text-gray-700 font-semibold whitespace-nowrap">
                                            {{ $taskStatus->achieved_point }}
                                        </td>
                                        <td class="px-2 py-3 text-gray-600 whitespace-nowrap">
                                            {{ $taskStatus->done_at ? $taskStatus->done_at->format('Y-m-d') : '-' }}
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @foreach ($studentTasksStatus as $taskStatus)
                            @php
                                $task = $taskStatus->task;
                            @endphp

                            <x-modal name="evaluate-task-{{ $task->id }}" focusable>
                                <form method="POST" action="{{ route('student_tasks.evaluate.store') }}"
                                    class="p-6" x-data="{ achievedPoint: {{ $taskStatus->achieved_point ?? 'null' }} }">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <input type="hidden" name="task_id" value="{{ $task->id }}">
                                    <input type="hidden" name="achieved_point" x-model="achievedPoint">

                                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                                        تقييم المهمة: <span class="text-indigo-600">{{ $task->title }}</span>
                                    </h2>

                                    <p class="mb-4 text-gray-700">اختر النقاط المحققة (الحد الأقصى: {{ $task->point }}
                                        نقاط):</p>

                                    <div
                                        class="grid grid-cols-5 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-10 gap-3 mb-6">
                                        @for ($i = 0; $i <= $task->point; $i++)
                                            <button type="button" @click="achievedPoint = {{ $i }}"
                                                :class="{
                                                    'bg-indigo-600 text-white shadow-lg': achievedPoint ==
                                                        {{ $i }},
                                                    'bg-gray-200 text-gray-800 hover:bg-gray-300': achievedPoint !=
                                                        {{ $i }}
                                                }"
                                                class="flex items-center justify-center w-10 h-10 rounded-full font-semibold text-lg transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                {{ $i }}
                                            </button>
                                        @endfor

                                        @if ($task->point > 0)
                                            <button type="button" @click="achievedPoint = null"
                                                :class="{
                                                    'bg-red-600 text-white shadow-lg': achievedPoint ===
                                                        null,
                                                    'bg-gray-200 text-gray-800 hover:bg-gray-300': achievedPoint !==
                                                        null
                                                }"
                                                class="flex items-center justify-center w-10 h-10 rounded-full font-semibold text-xs transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                مسح
                                            </button>
                                        @endif
                                    </div>

                                    <div class="mb-6 text-center text-lg font-bold text-gray-800">
                                        النقاط المختارة: <span
                                            x-text="achievedPoint !== null ? achievedPoint : 'لم يتم الاختيار'"></span>
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

                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-700">لا توجد مهام مخصصة</h3>
                        <p class="mt-1 text-sm text-gray-500">لا توجد مهام مرتبطة بمجموعة هذا الطالب.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
