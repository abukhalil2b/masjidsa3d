<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('سجل الحضور') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">
        <h2 class="text-xl font-bold mb-6">تسجيل حضور جديد</h2>

        <form method="POST" action="{{ route('attendances.store') }}">
            @csrf

            <div class="mb-4">
                <x-input-label for="title" value="عنوان الجلسة" />
                <x-text-input name="title" id="title" class="w-full mt-1" required />
                <x-input-error :messages="$errors->get('title')" />
            </div>

            <div class="mb-4">
                <h3 class="font-medium text-gray-700 mb-2">اختر الطلاب الحاضرين</h3>
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($students as $student)
                        <label class="flex items-center space-x-2 rtl:space-x-reverse">
                            <input type="checkbox" name="students[]" value="{{ $student->id }}">
                            <span>{{ $student->name }}</span>
                        </label>
                    @endforeach
                </div>
                <x-input-error :messages="$errors->get('students')" />
            </div>

            <div class="flex justify-center">
                <x-primary-button type="submit">حفظ</x-primary-button>
            </div>
        </form>
    </div>

</x-app-layout>
