<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page-title', 'KYC Management System')</title>
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @stack('styles')
</head>
<body class="bg">
<header id="header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="ds-logo">
                    <a href="index.html">
                        <img src="{{asset('assets/img/logo.png')}}" alt="" class="img-fluid">
                    </a>
                </div>
            </div>
            <div class="col-6 col-sm-8 col-lg-9">
                <div class="ds-top">
                    <div class="ds-search">
                        <form class="needs-validation" novalidate>
                            <input type="search" class="form-control" id="search"
                                   placeholder="Pesquise Nomes, CPFs ou E-mails"
                                   required>
                            <button type="submit" class="icon">
                                <img src="{{asset('assets/img/slas.png')}}" alt="">
                            </button>
                        </form>
                    </div>
                    <div class="ds-notify">
                        <button class="bell">
                            <img src="{{asset('assets/img/bell.png')}}" alt="">
                        </button>
                        <span class="count">99</span>
                    </div>
                    <div class="ds-user">
                        <a href="profile.html" class="user">
                            <img src="{{asset('assets/img/user2.png')}}" alt="" class="img-fluid"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<section id="dashobard">
    <div class="sidebar d-flex flex-column" id="sidebar">
        <ul class="nav nav-das flex-column">
            @if(isAdmin())
                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="nav-link {{isActiveRoute('admin.dashboard')}}">
                        <img src="{{asset('assets/img/home.png')}}" alt="">
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.groups.index')}}" class="nav-link {{isActiveRoute('admin.groups.index')}}">
                        <i class="bi-collection" style="font-size: 1.5rem; font-weight: bolder"></i>
                        <span>Groups</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.clients.index')}}"
                       class="nav-link {{isActiveRoute('admin.clients.index')}}">
                        <i class="bi-person-rolodex" style="font-size: 1.5rem; font-weight: bolder"></i>
                        <span>Clients</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.agents.index')}}" class="nav-link {{isActiveRoute('admin.agents.index')}}">
                        <i class="bi-people" style="font-size: 1.5rem; font-weight: bolder"></i>
                        <span>Agents</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.supervisors.index')}}"
                       class="nav-link {{isActiveRoute('admin.supervisors.index')}}">
                        <i class="bi-person" style="font-size: 1.5rem; font-weight: bolder"></i>
                        <span>Supervisors</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.auditors.index')}}"
                       class="nav-link {{isActiveRoute('admin.auditors.index')}}">
                        <i class="bi-person-badge" style="font-size: 1.5rem; font-weight: bolder"></i>
                        <span>Auditors</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('admin.sales.index')}}"
                       class="nav-link {{isActiveRoute('admin.sales.index')}}">
                        <i class="bi-receipt-cutoff" style="font-size: 1.5rem; font-weight: bolder"></i>
                        <span>Conversions</span>
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link {{isActiveRoute('dashboard')}}">
                        <img src="{{asset('assets/img/home.png')}}" alt="">
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="conversion.html" class="nav-link">
                        <i class="bi-alarm" style="font-size: 1.5rem; font-weight: bolder"></i>
                        <span>Minhas Conversões</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link green" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                       aria-controls="offcanvasRight">
                        <i class="bi-alarm" style="font-size: 1.5rem; font-weight: bolder"></i>
                        <span>Cadastrar Conversões</span>
                    </a>
                </li>
            @endif
        </ul>
        <ul class="nav nav-bottom">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <img src="{{asset('assets/img/setting.png')}}" alt="">
                    <span>Configurações</span></a>
                <button class="btn-nav" id="toggleSidebar">
                    <img src="{{asset('assets/img/arrow-left.png')}}" alt="">
                </button>
            </li>
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
    </div>
    <div id="content" class="content">
        {{ $slot }}
    </div>
</section>

<div class="offcanvas offcanvas-end sidebar-ds" tabindex="-1" id="offcanvasRight"
     aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Cadastro de conversão realizada.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form class="needs-validation row g-3" novalidate>
            <div class="col-12 fm-item2">
                <label for="" class="form-label">Qual o Cliente?<span>*</span></label>
                <select class="form-select">
                    <option selected>7k.bet.br</option>
                    <option value="1">7k.bet.br</option>
                </select>
            </div>
            <div class="col-12 col-lg-6 fm-item2">
                <label for="" class="form-label">Status no Jira<span>*</span></label>
                <select class="form-select">
                    <option selected>Aguardando atendimento</option>
                    <option value="1">Aguardando atendimento</option>
                </select>
            </div>
            <div class="col-12 col-lg-6 fm-item2">
                <label for="" class="form-label">ID Backoffice<span>*</span></label>
                <input type="text" class="form-control" id="" required>
            </div>
            <div class="col-12 col-lg-6 fm-item2">
                <label for="" class="form-label">Data<span>*</span></label>
                <input type="date" class="form-control" id="" required>
            </div>
            <div class="col-12 col-lg-6 fm-item2">
                <label for="" class="form-label">Hora<span>*</span></label>
                <input type="time" class="form-control" id="" placeholder="Selecione a data" required>
            </div>
            <div class="col-12 col-lg-6 fm-item2">
                <label for="" class="form-label">ID Jira<span>*</span></label>
                <input type="text" class="form-control" id="" placeholder="Selecione a hora" required>
                <p>Ex: CDT-532</p>
            </div>
            <div class="col-12 col-lg-6 fm-item2">
                <label for="" class="form-label">Bônus<span>*</span></label>
                <input type="text" class="form-control" id="" placeholder="100 Rodadas Tigre Sortudo" required>
            </div>
            <div class="col-12 fm-item2">
                <label for="" class="form-label">Upload do comprovante<span>*</span></label>
                <input type="file" class="form-control" id="" placeholder="" required>
                <p>JPG, PNG, JPEG e PDF</p>
            </div>
            <div class="fm-item2 fm-button col lign-self-end">
                <button type="submit" class="btn-cn">Cancelar</button>
                <button type="submit" class="btn-fm">Enviar para auditoria</button>
            </div>
        </form>
    </div>
</div>

@stack('scripts')

<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{asset('assets/js/script.js')}}"></script>
</body>

</html>
