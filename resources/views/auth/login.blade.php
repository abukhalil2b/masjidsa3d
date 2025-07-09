<x-guest-layout>
    <div class="text-center mt-4">
        <h2 class="text-2xl font-bold text-gray-800">تسجيل الدخول</h2>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- البريد الإلكتروني -->
        <div>
            <x-input-label for="email" :value="'المعلم'" />
            <x-text-input id="email" class="block mt-1 w-full" name="email" :value="old('email')" required/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- تذكرني -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">تذكر بيانات الدخول</span>
            </label>
        </div>

        <div class="w-full">
            <button class="w-full flex justify-center items-center px-4 py-4 bg-white border border-blue-300 rounded-md font-bold text-xs text-blue-700 shadow-sm hover:bg-blue-50 ease-in-out duration-150">
                تسجيل الدخول
            </button>
        </div>
    </form>
</x-guest-layout>
