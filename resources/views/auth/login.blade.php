<x-guest-layout>
    <script src="{{ asset('js/toast.js') }}"></script>
    <script src="{{ asset('js/form-persistence.js') }}"></script>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Success Messages -->
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
            <div class="font-semibold mb-1">✓ {{ session('success') }}</div>
        </div>
    @endif

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="'Kata Sandi'" />

            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <button type="button" class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none" data-target="password">
                    <!-- Eye Closed -->
                    <svg class="eye-closed w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <!-- Eye Open -->
                    <svg class="eye-open w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-2.391m5.005-2.905A9.005 9.005 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.053 10.053 0 01-4.132 5.814M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1015 12m0 0a3 3 0 01-5.878 1.879m5.878-1.879L15 12"></path>
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4 gap-4">
            <div class="flex-1">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        Lupa kata sandi?
                    </a>
                @endif
            </div>

            <x-primary-button>
                Masuk
            </x-primary-button>
        </div>

        <!-- Register Link -->
        <div class="mt-6 text-center border-t border-gray-200 pt-6">
            <p class="text-sm text-gray-600">Belum memiliki akun?</p>
            <a href="{{ route('register') }}" class="mt-2 inline-block px-6 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
                ➕ Daftar Sebagai Guru
            </a>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Form Persistence
            FormPersistence.init('loginForm', {
                storageKey: 'login_form_data',
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

            // Show error toast if there are errors
            const errors = document.querySelectorAll('[role="alert"]');
            if (errors.length > 0) {
                errors.forEach(error => {
                    const message = error.textContent.trim();
                    if (message) {
                        Toast.error(message);
                    }
                });
            }
        });
    </script>
</x-guest-layout>