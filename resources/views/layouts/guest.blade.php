<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page-title')</title>
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
<section id="login">
    <div class="container-fluid g-0">
        <div class="row g-0">
            <div class="col-12 col-lg-6">
                <div class="login-bg"></div>
            </div>
            <div class="col-12 col-lg-6 align-self-center">
                <select class="form-select lag-select">
                    <option selected>Português</option>
                    <option value="1">English</option>
                    <option value="2">Bangla</option>
                </select>
                <div class="login-fm">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="img-fluid logo">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/script.js')}}"></script>
</body>

</html>
