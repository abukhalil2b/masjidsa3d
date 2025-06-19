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
            <x-text-input id="email" class="block mt-1 w-full" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- كلمة المرور -->
        <div>
            <x-input-label for="password" :value="'كلمة المرور'" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- تذكرني -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">تذكر بيانات الدخول</span>
            </label>
        </div>

        <!-- الزر -->
        <div class="flex justify-end">
            <x-primary-button>تسجيل الدخول</x-primary-button>
        </div>
    </form>
</x-guest-layout>
