<ul class="nav nav-das flex-column">
    @foreach(getMenu() as $item)
        <li class="nav-item">
            <a href="{{ route($item['route']) }}"
               class="nav-link {{ isActiveRoute($item['route']) }}">
                @if($item['isImage'])
                    <img src="{{ $item['icon'] }}" alt=""/>
                @else
                    <i class="{{ $item['icon'] }}" style="font-size: 1.5rem; font-weight: bolder"></i>
                @endif
                <span>{{ $item['title'] }}</span>
            </a>
        </li>
    @endforeach

    @if(isUser())
        <li class="nav-item">
            <a href="#" class="nav-link green" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
               aria-controls="offcanvasRight">
                <i class="bi-alarm" style="font-size: 1.5rem; font-weight: bolder"></i>
                <span>Cadastrar Conversões</span>
            </a>
        </li>

        <div class="offcanvas offcanvas-end sidebar-ds"
             tabindex="-1"
             id="offcanvasRight"
             aria-labelledby="offcanvasRightLabel"
             style="z-index: 1200;">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasRightLabel">Cadastro de conversão realizada</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form action="{{ route('user.conversions.store') }}"
                      method="POST"
                      class="needs-validation row g-3"
                      enctype="multipart/form-data"
                      novalidate>
                    @csrf
                    <div class="col-12 fm-item2">
                        <label class="form-label">Qual o Cliente?<span>*</span></label>
                        <select name="client_id" class="form-select" required>
                            <option value="" selected disabled>Escolha um cliente...</option>
                            {{-- Hardcode or loop through your clients --}}
                            <option value="1">7k.bet.br</option>
                            <option value="2">OutroCliente.com</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, selecione um cliente.
                        </div>
                    </div>

                    <div class="col-12 fm-item2">
                        <label class="form-label">Grupo<span>*</span></label>
                        <select name="group_id" class="form-select" required>
                            <option value="" selected disabled>Escolha um grupo...</option>
                            <option value="10">Grupo A</option>
                            <option value="20">Grupo B</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, selecione um grupo.
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 fm-item2">
                        <label class="form-label">Status no Jira<span>*</span></label>
                        <select name="jira_status" class="form-select" required>
                            <option value="aguardando" selected>Aguardando atendimento</option>
                            <option value="resolvido">Resolvido</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, selecione um status do Jira.
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 fm-item2">
                        <label class="form-label">ID Backoffice<span>*</span></label>
                        <input type="text" class="form-control" name="backoffice_id" required>
                        <div class="invalid-feedback">
                            Por favor, insira o ID do Backoffice.
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 fm-item2">
                        <label class="form-label">Data<span>*</span></label>
                        <input type="date" class="form-control" name="date" required>
                        <div class="invalid-feedback">
                            Por favor, selecione a data.
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 fm-item2">
                        <label class="form-label">Hora<span>*</span></label>
                        <input type="time" class="form-control" name="hour" required>
                        <div class="invalid-feedback">
                            Por favor, selecione a hora.
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 fm-item2">
                        <label class="form-label">ID Jira<span>*</span></label>
                        <input type="text" class="form-control" name="jira_id" required>
                        <p class="small text-muted">Ex: CDT-532</p>
                        <div class="invalid-feedback">
                            Por favor, insira o ID do Jira.
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 fm-item2">
                        <label class="form-label">Bônus<span>*</span></label>
                        <input type="text" class="form-control" name="bonus" required>
                        <div class="invalid-feedback">
                            Por favor, insira o bônus.
                        </div>
                    </div>

                    <div class="col-12 fm-item2">
                        <label class="form-label">Upload do comprovante<span>*</span></label>
                        <input type="file" class="form-control"
                               name="voucher_image"
                               accept="image/*,application/pdf"
                               required>
                        <p class="small text-muted">Formatos aceitos: JPG, PNG, JPEG, PDF</p>
                        <div class="invalid-feedback">
                            Faça upload do comprovante (arquivo de imagem ou PDF).
                        </div>
                    </div>

                    <input type="hidden" name="status" value="pending">

                    <div class="col-12 fm-item2">
                        <label class="form-label">Descrição (opcional)</label>
                        <textarea class="form-control" name="description" rows="2"></textarea>
                    </div>

                    <div class="fm-item2 fm-button col">
                        <button type="button" class="btn-cn" data-bs-dismiss="offcanvas">
                            Cancelar
                        </button>
                        <button type="submit" class="btn-fm">
                            Enviar para auditoria
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</ul>
<ul class="nav nav-bottom">
    @if(isAdmin())
        <li class="nav-item">
            <a href="{{route('admin.configs.profile')}}" class="nav-link {{isActiveRoute('admin.configs.*')}}">
                <img src="{{asset('assets/img/setting.png')}}" alt="">
                <span>Configurações</span></a>
            <button class="btn-nav" id="toggleSidebar">
                <img src="{{asset('assets/img/arrow-left.png')}}" alt="">
            </button>
        </li>
    @elseif(isAuditor())
        <li class="nav-item">
            <a href="{{route('auditor.profile')}}"
               class="nav-link {{isActiveRoute('auditor.profile')}}">
                <img src="{{asset('assets/img/setting.png')}}" alt="">
                <span>Configurações</span></a>
            <button class="btn-nav" id="toggleSidebar">
                <img src="{{asset('assets/img/arrow-left.png')}}" alt="">
            </button>
        </li>
    @elseif(isUser())
        <li class="nav-item">
            <a href="{{route('user.profile')}}"
               class="nav-link {{isActiveRoute('user.profile')}}">
                <img src="{{asset('assets/img/setting.png')}}" alt="">
                <span>Configurações</span></a>
            <button class="btn-nav" id="toggleSidebar">
                <img src="{{asset('assets/img/arrow-left.png')}}" alt="">
            </button>
        </li>
    @elseif(isSupervisor())
        <li class="nav-item">
            <a href="{{route('supervisor.profile')}}"
               class="nav-link {{isActiveRoute('supervisor.profile')}}">
                <img src="{{asset('assets/img/setting.png')}}" alt="">
                <span>Configurações</span></a>
            <button class="btn-nav" id="toggleSidebar">
                <img src="{{asset('assets/img/arrow-left.png')}}" alt="">
            </button>
        </li>
    @endif
    <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="nav-link border-0 bg-transparent">
                <img src="{{ asset('assets/img/log-out.png') }}" alt="">
                <span>Sair</span>
            </button>
        </form>
    </li>
</ul>
