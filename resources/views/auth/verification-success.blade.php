<x-guest-layout>
    @section('page-title', 'Verification Successfull')
    <div class="login-box">
        <div class="img-check">
            <img src="{{asset('assets/img/check-circle.svg')}}" alt="" class="img-fluid">
        </div>
        <h3>Senha alterada com sucesso</h3>
        <p>Entre em sua conta novamente</p>
        <form class="needs-validation" action="{{route('login')}}" novalidate>
            <div class="fm-item">
                <button class="btn btn-fm" type="submit">Login</button>
            </div>
        </form>
    </div>
</x-guest-layout>
