<x-guest-layout>

    <x-slot name="namepage">Login</x-slot>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">

        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('login.LabelEmail')" />
            <x-text-input id="email" class="block w-full mt-1 dark:bg-white" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('login.LabelMdp')" />

            <x-text-input id="password" class="block w-full mt-1 dark:bg-white"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="text-indigo-600 border-gray-300 rounded shadow-sm dark:bg-gray-900 dark:border-gray-700 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ml-2 text-sm text-gray-600 dark:text-black">{{ __('login.Remember_Me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 underline rounded-md dark:text-black hover:text-gray-900 dark:hover:text-[#ab0800] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('login.MdpOublier') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('login.BtnLogin') }}
            </x-primary-button>
        </div>

    </form>
</x-guest-layout>
