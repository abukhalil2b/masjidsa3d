<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-md text-gray-800 leading-tight">
            {{ __('سجل الحضور') }}
        </h2>
    </x-slot>

    <div class="py-2 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">سجلات الحضور</h2>
            <x-primary-button onclick="window.location='{{ route('attendances.create') }}'">جلسة جديدة</x-primary-button>
        </div>

        @if (session('success'))
            <x-alert type="success" :message="session('success')" class="mb-4" />
        @endif

        <table class="w-full table-auto border rounded text-xs">
            <thead class="bg-gray-100 text-right">
                <tr>
                    <th class="px-2 py-2">العنوان</th>
                    <th class="px-2 py-2">عدد الحضور</th>
                    <th class="px-2 py-2">التاريخ</th>
                    <th class="px-2 py-2">الحضور</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                    <tr class="border-b">
                        <td class="px-2 py-2">{{ $attendance->title }}</td>
                        <td class="px-2 py-2">{{ $attendance->students_count }}</td>
                        <td class="px-2 py-2">{{ $attendance->created_at->translatedFormat('Y/m/d') }}</td>
                        <td>
                            <a href="{{ route('attendances.show', $attendance->id) }}">الحضور</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-app-layout>
