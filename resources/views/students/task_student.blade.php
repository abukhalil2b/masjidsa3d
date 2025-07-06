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
        $tasks = [
            'التوجيه',
            'التحيات',
            'الفاتحة',
            604,
            603,
            602,
            601,
            600,
            599,
            598,
        ];
    @endphp

    <div class="relative overflow-x-auto mt-4" id="printable-table">
        <div>
            كشف الحفظ
        </div>
        <table class="w-full text-right text-sm text-gray-700 border border-gray-300 rounded shadow-md">
            <thead class="bg-gray-100 text-gray-800">
                <tr class="text-center">
                    <th class="border px-4 py-2 bg-gray-200">الاسم</th>
                    @foreach ($tasks as $task)
                        <th class="border px-4 py-2">{{ $task }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 font-medium text-gray-900">{{ $student->name }}</td>
                        @foreach ($tasks as $task)
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
