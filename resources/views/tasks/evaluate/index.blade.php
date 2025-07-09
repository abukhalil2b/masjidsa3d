<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('تقييم المهام') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            @forelse ($tasksWithStudents as $taskData)
                <div class="mb-8 bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4 sm:p-6 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-xl font-extrabold text-gray-900 flex items-center justify-between">
                            <span>{{ $taskData->task->title }}</span>
                            <span class="text-sm font-semibold text-blue-700 bg-blue-100 px-3 py-1 rounded-full">
                                {{ $taskData->task->point }} نقاط
                            </span>
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">
                            <span class="font-medium">{{ __('المجموعة الرئيسية:') }}</span>
                            {{ $taskData->task->taskGroup->title ?? 'بدون مجموعة' }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            <span class="font-medium">{{ __('حالة التقييم:') }}</span>
                            <span class="text-gray-800 font-semibold">{{ $taskData->completed_count }}</span>
                            من
                            <span class="text-gray-800 font-semibold">{{ $taskData->total_students_count }}</span>
                            طالب/طالبة
                        </p>
                    </div>

                    @if ($taskData->students_status->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-right text-sm">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-gray-600 font-semibold uppercase tracking-wider whitespace-nowrap">
                                            اسم الطالب</th>
                                        <th
                                            class="px-4 py-3 text-gray-600 font-semibold uppercase tracking-wider whitespace-nowrap">
                                            النقاط المحققة</th>
                                        <th
                                            class="px-4 py-3 text-gray-600 font-semibold uppercase tracking-wider whitespace-nowrap">
                                            الحالة</th>
                                   
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach ($taskData->students_status as $studentStatus)
                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                            <td class="px-4 py-3 text-gray-800 whitespace-nowrap">
                                                {{ $studentStatus->student->name }}</td>
                                            <td class="px-4 py-3 text-gray-700 font-medium whitespace-nowrap">
                                                @if ($studentStatus->achieved_point !== null)
                                                    <span
                                                        class="text-green-600 font-bold">{{ $studentStatus->achieved_point }}</span>
                                                    / {{ $taskData->task->point }}
                                                @else
                                                    - / {{ $taskData->task->point }}
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if ($studentStatus->is_done)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        {{ __('تم التقييم') }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        {{ __('لم يتم التقييم') }}
                                                    </span>
                                                @endif
                                            </td>
                                           
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-6 text-gray-600 text-center">
                            <p>{{ __('لا يوجد طلاب مرتبطون بهذه المهمة بعد.') }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ __('تأكد من ربط مجموعات الطلاب بمجموعات المهام ذات الصلة.') }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-600">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium">
                        {{ __('لا توجد مهام متاحة للتقييم.') }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ __('تأكد من أن لديك مهام ضمن مجموعات مهام قمت بإنشائها.') }}
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
