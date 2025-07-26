<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-md text-gray-800 leading-tight">
            المهام المكتملة للطلاب
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 text-right">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-sm font-semibold text-gray-600">اسم الطالب</th>
                        <th class="px-4 py-2 text-sm font-semibold text-gray-600">عدد المهام المكتملة</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($data as $student)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $student['name'] }}</td>
                            <td class="px-4 py-2 text-sm text-blue-600 font-bold">{{ $student['completed'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-4 py-4 text-center text-gray-500">
                                لا توجد بيانات.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
