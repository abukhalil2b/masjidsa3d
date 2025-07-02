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
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
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
                                    <th class="px-4 py-3 text-gray-600 font-semibold uppercase tracking-wider whitespace-nowrap">عنوان المهمة</th>
                                    <th class="px-4 py-3 text-gray-600 font-semibold uppercase tracking-wider whitespace-nowrap">النقاط</th>
                                    <th class="px-4 py-3 text-gray-600 font-semibold uppercase tracking-wider whitespace-nowrap">تاريخ الإنجاز</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($studentTasksStatus as $taskStatus)
                                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                        <td class="px-4 py-3 text-gray-800 whitespace-nowrap">{{ $taskStatus->task->title }}</td>
                                        <td class="px-4 py-3 text-gray-700 font-semibold whitespace-nowrap">
                                            @if ($taskStatus->achieved_point !== null)
                                                <span class="text-green-600">{{ $taskStatus->achieved_point }}</span> من {{ $taskStatus->task->point }}
                                            @else
                                                - من {{ $taskStatus->task->point }}
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                                            {{ $taskStatus->done_at ? $taskStatus->done_at->format('Y-m-d') : '-' }}
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
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-700">لا توجد مهام مخصصة</h3>
                        <p class="mt-1 text-sm text-gray-500">لا توجد مهام مرتبطة بمجموعة هذا الطالب.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>