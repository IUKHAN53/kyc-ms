<x-guest-layout>
    @section('page-title', 'Forgot Password')
    <div class="login-box">
        <h3>Esqueceu sua senha?</h3>
        <p>Entre com o seu e-mail para receber instruções de recuperação da sua conta.</p>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="fm-item">
                <x-input-label for="email" :value="__('Email')"/>
                <x-text-input field="email" type="email" required autofocus/>
                <x-input-error field="email" />
            </div>
            <div class="fm-item">
                <x-primary-button>
                    Enviar link
                </x-primary-button>
            </div>
        </form>
        <p class="text-center mb-0">
            <a href="{{route('login')}}" class="fm-link">Voltar ao login</a>
        </p>
    </div>
</x-guest-layout>
