<x-app-layout>
    <div class="ds-profile">
        <div class="row g-0">
            <div class="col-12 col-md-12 col-lg-4 col-xl-3">
                <div class="pf-item pf-item1">
                    <h2>Configurações</h2>
                    <p>Gerencie as configurações da sua conta e defina preferências</p>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="dark">
                        <label class="form-check-label" for="dark">Dark mode</label>
                    </div>
                    <hr>
                    <ul class="nav-pf">
                        <li>
                            <a href="{{ route('user.profile') }}"
                               class="{{isActiveRoute('user.profile')}}">Minha Conta</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-8 col-xl-9">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-app-layout>
