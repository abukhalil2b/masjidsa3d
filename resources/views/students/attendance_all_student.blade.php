<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                جميع الطلاب
            </h2>
            <button onclick="printTable()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                طباعة الجدول
            </button>
        </div>
    </x-slot>

    @php
        $startDate = \Carbon\Carbon::create(2025, 7, 6); // starting from Sun 6-7
        $days = [];
        for ($week = 0; $week < 3; $week++) {
            foreach (['الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء'] as $i => $arabicDay) {
                $date = $startDate->copy()->addDays($week * 7 + $i);
                $days[] = $arabicDay . ' ' . $date->format('j-n');
            }
        }
    @endphp
 
    <div class="relative overflow-x-auto mt-4" id="printable-table">
           <div>
        كشف الحضور
    </div>
        <table class="w-full text-right text-sm text-gray-700 border border-gray-300 rounded shadow-md">
            <thead class="bg-gray-100 text-gray-800">
                <tr class="text-center">
                    <th class="border px-4 py-2 bg-gray-200">الاسم</th>
                    @foreach ($days as $day)
                        <th class="border px-4 py-2">{{ $day }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 font-medium text-gray-900">{{ $student->name }}</td>
                        @foreach ($days as $day)
                            <td class="border px-4 py-2"></td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function printTable() {
            const printContent = document.getElementById('printable-table').innerHTML;
            const originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
            window.location.reload(); // optional: reload to restore event listeners/styles
        }
    </script>
</x-app-layout>
