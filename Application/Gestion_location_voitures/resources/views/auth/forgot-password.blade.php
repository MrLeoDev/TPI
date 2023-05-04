<x-guest-layout>

    <x-slot name="namepage">{{ __('forgot_password.Title') }}</x-slot>

    <div class="mb-4 text-sm text-gray-600 dark:text-black">
        {{ __('forgot_password.Description') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('forgot_password.labelEmail')" />
            <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('forgot_password.btnReset') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
