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
    @livewireStyles
</head>
<body class="bg">
<header id="header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="ds-logo">
                    <a href="#">
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
                        <a href="#" class="user">
                            <img src="{{auth()->user()->avatar}}" alt="" class="img-fluid rounded-full"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<section id="dashboard">
    <div class="sidebar d-flex flex-column" id="sidebar">
        @include('layouts.sidebars.main-sidebar')
    </div>
    <div id="content" class="content">
        {{ $slot }}
    </div>
</section>


@stack('scripts')
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{asset('assets/js/script.js')}}"></script>
@livewireScripts

</body>

</html>
