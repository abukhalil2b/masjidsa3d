<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            الحضور: {{ $attendance->title }}
        </h2>
    </x-slot>

    <form action="{{ route('attendances.update', $attendance->id) }}" method="POST"
        class="max-w-4xl mx-auto p-6 bg-white shadow rounded-lg">
        @csrf
        @method('PUT')

        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-right">اسم الطالب</th>
                    <th class="px-4 py-2 text-right">حضر</th>
                    <th class="px-4 py-2 text-right">تاريخ الحضور (إن وجد)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($students as $student)
                    <tr>
                        <td class="px-4 py-2">{{ $student->name }}</td>
                        <td class="px-4 py-2 text-center">
                            <input type="checkbox" name="attendance[{{ $student->id }}]" value="1"
                                {{ isset($attendanceRecords[$student->id]) ? 'checked' : '' }} />
                        </td>
                        <td class="px-4 py-2 text-center">
                            {{ $attendanceRecords[$student->id] ?? '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6 flex justify-end">
            <x-primary-button>
                {{ __('تحديث الحضور') }}
            </x-primary-button>
        </div>
    </form>
</x-app-layout>
