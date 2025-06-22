<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">تقييم مهمة</h2>
    </x-slot>

    <div class="py-8 max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h3 class="text-lg font-medium text-gray-700 mb-4">
            تقييم الطالب: {{ $student->name }}
        </h3>

        <form method="POST" action="{{ route('student-tasks.evaluate.store') }}">
            @csrf
            @method('PUT')

            <input type="hidden" name="student_id" value="{{ $student->id }}">
            <input type="hidden" name="task_id" value="{{ $task->id }}">

            <div class="mb-4">
                <x-input-label for="achieved_point" value="النقاط المحققة" />
                <x-text-input type="number" step="0.1" name="achieved_point" class="mt-1 block w-full" value="{{$studentTask->achieved_point ?? 0}}" required />
                <x-input-error :messages="$errors->get('achieved_point')" class="mt-2" />
            </div>

            <x-primary-button>حفظ التقييم</x-primary-button>
        </form>

    </div>
</x-app-layout>
