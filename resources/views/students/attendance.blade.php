<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-md text-gray-800 leading-tight">
            سجل الحضور للطالب: {{ $student->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-right text-sm font-semibold text-gray-600">العنوان</th>
                        <th class="px-4 py-2 text-right text-sm font-semibold text-gray-600">الحالة</th>
                        <th class="px-4 py-2 text-right text-sm font-semibold text-gray-600">تاريخ الحضور</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($attendances as $item)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-800">
                                {{ $item['title'] }}
                            </td>
                            <td class="px-4 py-2 text-sm font-bold {{ $item['status'] === 'present' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $item['status'] === 'present' ? '✔️ حاضر' : '❌ غائب' }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-600">
                                {{ $item['attend_at'] ? \Carbon\Carbon::parse($item['attend_at'])->translatedFormat('Y/m/d h:i A') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-center text-gray-500">
                                لا توجد بيانات حضور.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
