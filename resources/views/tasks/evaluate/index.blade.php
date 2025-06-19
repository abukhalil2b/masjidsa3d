<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">تقييم المهام</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto">
            @if (session('success'))
                <x-alert type="success" :message="session('success')" class="mb-4" />
            @endif

            @foreach ($tasks as $task)
                <div class="mb-6 bg-white rounded shadow p-4">
                    <h3 class="text-lg font-bold text-gray-800">{{ $task->title }}</h3>
                    <p class="text-sm text-gray-500 mb-2">النقاط: {{ $task->point }}</p>

                    @if ($task->studentTasks->count())
                        <table class="w-full text-sm text-right table-auto border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2 border">اسم الطالب</th>
                                    <th class="p-2 border">النقاط المحققة</th>
                                    <th class="p-2 border">تم الانتهاء؟</th>
                                    <th class="p-2 border">إجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($task->studentTasks as $studentTask)
                                    <tr class="border-t">
                                        <td class="p-2 border">{{ $studentTask->student->name }}</td>
                                        <td class="p-2 border">{{ $studentTask->achieved_point ?? '-' }}</td>
                                        <td class="p-2 border">
                                            {{ $studentTask->done_at ? 'نعم' : 'لا' }}
                                        </td>
                                        <td class="p-2 border">
                                            <a href="{{ route('student-tasks.evaluate.form', $studentTask->id) }}"
                                                class="text-indigo-600 hover:underline">تقييم</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-sm text-gray-500">لا يوجد طلاب مسجلين في هذه المهمة.</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
