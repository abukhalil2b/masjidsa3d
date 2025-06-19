<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('تسجيل النقاط المحققة') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <p class="text-lg"><strong>الطالب:</strong> {{ $studentTask->student->name }}</p>
                        <p class="text-lg"><strong>المهمة:</strong> {{ $studentTask->task->title }}</p>
                        <p class="text-lg"><strong>أقصى نقاط:</strong> {{ $studentTask->task->point }}</p>
                    </div>

                    <form method="POST" action="{{ route('student-tasks.update', $studentTask) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <x-input-label for="achieved_point" value="{{ __('النقاط المحققة') }}" />
                            <x-text-input 
                                id="achieved_point" 
                                name="achieved_point" 
                                type="number" 
                                class="block mt-1 w-full"
                                value="{{ old('achieved_point', $studentTask->achieved_point) }}"
                                min="0"
                                max="{{ $studentTask->task->point }}"
                                required
                            />
                            <x-input-error :messages="$errors->get('achieved_point')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('حفظ النقاط') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>