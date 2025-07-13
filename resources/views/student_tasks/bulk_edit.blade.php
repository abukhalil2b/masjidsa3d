<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Bulk Mark Tasks Done for:') }} {{ $student->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto">
        <form method="POST" action="{{ route('student_tasks.bulk.update', $student->id) }}">
            @csrf

            <div class="mb-4 flex items-center space-x-3">
                <label for="achieved_point" class="font-semibold text-gray-700">
                    {{ __('Achieved Point for all selected tasks:') }}
                </label>
                <input
                    id="achieved_point"
                    name="achieved_point"
                    type="number"
                    min="0"
                    max="100"
                    value="{{ old('achieved_point', 1) }}"
                    required
                    class="w-20 border rounded px-2 py-1 text-center"
                />
            </div>

            <table class="min-w-full divide-y divide-gray-200 text-right text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-2 py-3 text-gray-600 font-semibold whitespace-nowrap">تحديد</th>
                        <th class="px-2 py-3 text-gray-600 font-semibold whitespace-nowrap">عنوان المهمة</th>
                        <th class="px-2 py-3 text-gray-600 font-semibold whitespace-nowrap">النقاط القصوى</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($tasksToShow as $index => $item)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="px-2 py-3 text-center">
                                <input
                                    type="checkbox"
                                    name="task_ids[]"
                                    value="{{ $item->task->id }}"
                                    class="task-checkbox"
                                />
                            </td>
                            <td class="px-2 py-3">
                                {{ $item->task->title }}
                            </td>
                            <td class="px-2 py-3 text-center">{{ $item->task->point }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6 text-center">
                <x-primary-button type="submit">
                    {{ __('Mark Selected Tasks as Done') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
