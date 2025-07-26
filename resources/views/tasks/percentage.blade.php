<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-md text-gray-800 leading-tight">
            نسبة إنجاز المهام
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4">
        @forelse($data as $student)
            <div class="bg-white rounded-xl shadow mb-4 p-4">
                <div class="flex justify-between items-center mb-1">
                    <span class="font-semibold text-gray-700">{{ $student['name'] }}</span>
                    <span class="text-sm text-gray-500">{{ $student['percentage'] }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-blue-500 h-3 rounded-full" style="width: {{ $student['percentage'] }}%"></div>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500">لا توجد بيانات مهام.</div>
        @endforelse
    </div>
</x-app-layout>
