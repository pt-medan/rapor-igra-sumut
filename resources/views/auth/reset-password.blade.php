<x-guest-layout>
    <script src="{{ asset('js/toast.js') }}"></script>
    <script src="{{ asset('js/form-persistence.js') }}"></script>

    <form method="POST" action="{{ route('password.store') }}" id="resetPasswordForm">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="'Kata Sandi Baru'" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required autocomplete="new-password" />
                <button type="button" class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-target="password">
                    <svg class="eye-closed w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg class="eye-open w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-2.391m5.005-2.905A9.005 9.005 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.053 10.053 0 01-4.132 5.814M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1015 12m0 0a3 3 0 01-5.878 1.879m5.878-1.879L15 12"></path>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="'Konfirmasi Kata Sandi'" />
            <div class="relative">
                <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10" type="password" name="password_confirmation" required autocomplete="new-password" />
                <button type="button" class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-target="password_confirmation">
                    <svg class="eye-closed w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg class="eye-open w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-2.391m5.005-2.905A9.005 9.005 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.053 10.053 0 01-4.132 5.814M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1015 12m0 0a3 3 0 01-5.878 1.879m5.878-1.879L15 12"></path>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                Atur Ulang Kata Sandi
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Form Persistence
            FormPersistence.init('resetPasswordForm', {
                storageKey: 'reset_password_form_data',
                autoSaveDelay: 500
            });

            // Password Toggle Event Listeners
            document.querySelectorAll('.password-toggle').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const fieldId = this.getAttribute('data-target');
                    const inputField = document.getElementById(fieldId);
                    const eyeClosed = this.querySelector('.eye-closed');
                    const eyeOpen = this.querySelector('.eye-open');

                    if (inputField.type === 'password') {
                        inputField.type = 'text';
                        eyeClosed.classList.add('hidden');
                        eyeOpen.classList.remove('hidden');
                    } else {
                        inputField.type = 'password';
                        eyeClosed.classList.remove('hidden');
                        eyeOpen.classList.add('hidden');
                    }
                });
            });
        });
    </script>
</x-guest-layout>
