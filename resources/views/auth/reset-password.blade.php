<x-guest-layout>
    @section('page-title', 'Reset Password')
    <div class="login-box">
        <h3>{{ __('Reset Password') }}</h3>
        <form method="POST" action="{{ route('password.store') }}" class="needs-validation" novalidate>
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <div class="fm-item">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input type="email"
                              field="email"
                              value="{{old('email', $request->email)}}"
                              required
                              autofocus
                              autocomplete="username" />
                <x-input-error field="email"/>
            </div>
            <div class="mt-4 fm-item">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password"
                              type="password"
                              field="password"
                              required
                              autocomplete="new-password" />
                <x-input-error field="password" />
            </div>
            <div class="mt-4 fm-item">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation"
                              type="password"
                              field="password_confirmation"
                              required
                              autocomplete="new-password" />
                <x-input-error field="password_confirmation"/>
            </div>

            <div class="valid-pass mt-4">
                <h3>{{ __('Sua senha deve conter:') }}</h3>
                <ul>
                    <li class="check"><i class="bi bi-check"></i> {{ __('Mais de 8 caracteres') }}</li>
                    <li class="check"><i class="bi bi-check"></i> {{ __('Letras maiúsculas (A-Z)') }}</li>
                    <li><i class="bi bi-x"></i> {{ __('Letras minúsculas (a-z)') }}</li>
                    <li class="check"><i class="bi bi-check"></i> {{ __('Números (0-9)') }}</li>
                    <li><i class="bi bi-x"></i> {{ __('Caracteres especiais') }}</li>
                </ul>
            </div>
            <div class="flex items-center justify-end mt-4 fm-item">
                <x-primary-button>
                    {{ __('Reset Password') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');

            function validatePasswordMatch() {
                if (password.value !== passwordConfirmation.value) {
                    passwordConfirmation.setCustomValidity("{{ __('As senhas não coincidem.') }}");
                } else {
                    passwordConfirmation.setCustomValidity('');
                }
            }
            password.addEventListener('change', validatePasswordMatch);
            passwordConfirmation.addEventListener('keyup', validatePasswordMatch);
        });
    </script>
</x-guest-layout>
