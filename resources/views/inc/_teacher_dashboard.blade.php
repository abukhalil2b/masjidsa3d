<div class="py-12" x-data="{ filter: '' }">
    <div class="max-w-7xl mx-auto sm:px-2 lg:px-6">

        <!-- Filter Input -->
        <div class="mb-4">
            <input
                type="text"
                x-model="filter"
                placeholder="ابحث باسم الطالب..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-indigo-300"
            />
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-xs">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-right">{{ __('الاسم') }}</th>
                        <th class="px-4 py-3 text-right">{{ __('المجموعة') }}</th>
                        <th class="px-4 py-3 text-right">{{ __('المهام') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr x-show="{{ json_encode($student->name) }}.toLowerCase().includes(filter.toLowerCase())">
                            <td class="px-4 py-4">{{ $student->name }}</td>
                            <td class="px-4 py-4">{{ $student->group->title ?? '-' }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('students.show_tasks', $student->id) }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('المهام') }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
