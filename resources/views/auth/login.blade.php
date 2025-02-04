<x-guest-layout>
    @section('page-title', 'Login')
    <div class="login-box">
        <h2>Entrar</h2>
        <p>Digite seu e-mail abaixo para fazer login em sua conta</p>
        <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
            @csrf
            <div class="fm-item">
                <label for="email" class="form-label">{{ __('E-mail') }}</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="example@foxgreen.com.br"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                >
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="fm-item">
                <label for="password" class="form-label">{{ __('Senha') }}</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    required
                    autocomplete="current-password"
                >
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="fm-item">
                <button class="btn btn-fm" type="submit">
                    {{ __('Login') }}
                </button>
            </div>
        </form>
        <p class="text-center mb-0">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="fm-link">
                    {{ __('Esqueceu sua senha?') }}
                </a>
            @endif
        </p>
    </div>
</x-guest-layout>
