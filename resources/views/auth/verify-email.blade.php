<x-guest-layout>
    @section('page-title', 'Verifique o seu e-mail')
    <div class="login-box">
        <h3>{{ __('Verifique o seu e-mail') }}</h3>
        <p>
            {{ __('Obrigado por se registrar! Antes de começar, por favor, verifique seu endereço de e-mail clicando no link que enviamos. Se você não recebeu o e-mail, teremos o prazer de enviar outro.') }}
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="fm-item">
                <div class="alert alert-success">
                    {{ __('Um novo link de verificação foi enviado para o endereço de e-mail que você forneceu durante o registro.') }}
                </div>
            </div>
        @endif

        <div class="fm-item">
            <form method="POST" action="{{ route('verification.send') }}" class="needs-validation" novalidate>
                @csrf
                <button class="btn btn-fm" type="submit">
                    {{ __('Reenviar e-mail de verificação') }}
                </button>
            </form>
        </div>

        <div class="fm-item">
            <form method="POST" action="{{ route('logout') }}" class="needs-validation" novalidate>
                @csrf
                <button type="submit" class="btn btn-fm">
                    {{ __('Voltar ao login') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
