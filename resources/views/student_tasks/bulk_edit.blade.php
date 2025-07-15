<x-app-layout>
    <div class="max-w-md mx-auto px-4 py-4">
        <!-- Header with back button -->
        <div class="flex items-center mb-6">
            <a href="{{ url()->previous() }}" class="text-blue-600 p-2 rounded-full hover:bg-blue-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="text-xl font-bold text-gray-800 text-center flex-1">
                تعيين المهام للطالب: {{ $student->name }}
            </h2>
        </div>

        @if ($tasks->isEmpty())
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg shadow-sm mb-6">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-yellow-700 font-medium">لا توجد مهام متاحة للتعيين</span>
                </div>
            </div>
        @else
            <form action="{{ route('student_tasks.bulk.update', $student->id) }}" method="POST">
                @csrf

                <!-- Points input card -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-4">
                    <div class="flex items-center justify-between">
                        <label for="achieved_point" class="text-gray-700 font-medium">النقاط المحققة</label>
                        <input type="number" name="achieved_point" id="achieved_point" min="0"
                            class="w-24 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 text-right">
                    </div>
                </div>

                <!-- Select all card -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-4">
                    <label class="flex items-center justify-between cursor-pointer">
                        <span class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700 font-medium">اختيار الكل</span>
                        </span>
                        <input type="checkbox" id="select-all" class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500 border-gray-300">
                    </label>
                </div>

                <!-- Tasks list -->
                <div class="space-y-2 mb-6">
                    @foreach ($tasks as $task)
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <label class="flex items-start space-x-3 space-x-reverse cursor-pointer">
                                <input type="checkbox" name="task_ids[]" value="{{ $task->id }}"
                                    class="mt-1 form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500 border-gray-300 task-checkbox">
                                <div class="flex-1">
                                    <h3 class="text-gray-800 font-medium">{{ $task->title }}</h3>
                                    <div class="flex items-center mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="text-sm text-gray-600">{{ $task->point }} نقاط</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>

                <!-- Submit button -->
                <button type="submit" id="submit-btn"
                    class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transition duration-200 flex items-center justify-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span>حفظ المهام</span>
                </button>
            </form>
        @endif
    </div>
</x-app-layout>

<script>
    document.getElementById('select-all').addEventListener('change', function () {
        document.querySelectorAll('.task-checkbox').forEach(cb => cb.checked = this.checked);
    });

    document.addEventListener('DOMContentLoaded', function () {
        const hasTasks = document.querySelectorAll('.task-checkbox').length > 0;
        const submitBtn = document.getElementById('submit-btn');
        if (!hasTasks && submitBtn) {
            submitBtn.style.display = 'none';
        }
    });
</script>