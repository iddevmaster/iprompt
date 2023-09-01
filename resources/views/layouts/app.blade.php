<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('dist/img/logoiddrives.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('dist/img/logoiddrives.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/css/app.css' , 'resources/js/app.js'])

    <style>
        :root{
    --bs-dark: rgb(242, 255, 255);
  }

  .theme-container {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    position: fixed;
    bottom: 20px;
    left: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: 0.5s;
  }

  .theme-container:hover {
    opacity: 0.8;
  }

  @keyframes change {
    0% {
      transform: scale(1);
    }

    100% {
      transform: scale(1.4);
    }
  }

  .change {
    animation-name: change;
    animation-duration: 1s;
    animation-direction: alternate;
  }
  .bi-moon-stars{
    color: white;
  }
  .nav-light{
    background-color: white;
    color: black;
  }

  .nav-dark{
    background-color: black;
    color: white;
  }
  .nav-dark .navbarMenu{
    color: white;
  }
  .nav-dark .navbarMenu:hover{
    color: pink;
  }
    </style>
</head>
<body>
<?php $permis = Auth::user()->role ?? '' ;
      $dpm = Auth::user()->dpm ?? '';
?>
    <div id="app">
        <nav class="navbar navbar-expand-md nav-light shadow-sm" id="navb">
            <div class="container">
                <a id="brand" class="navbar-brand" href="{{ url('/home') }}">
                    <img src="{{ asset('dist/img/logoiddrives.png') }}" height="50">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item "><a href="{{ route('home') }}" class="nav-link navbarMenu">หน้าแรก</a></li>
                        <li class="nav-item dropdown ">
                            <a id="navbarDropdown" href="" class="nav-link dropdown-toggle navbarMenu" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                หนังสือรับเข้า</a>

                            <ul class="dropdown-menu dropdown-menu-end ">
                                <div class="d-flex flex-column justify-content-center">
                                    @php
                                        $userDpm = (App\Models\department::find((Auth::user())->dpm ?? ''))->prefix ?? '-';
                                    @endphp
                                    @if ($userDpm === 'AD' || Auth::user()->role === 'admin')
                                        <li><a class="dropdown-item" href="{{ route('imported') }}">รับเข้าหนังสือ</a></li>
                                    @endif
                                        <li><a class="dropdown-item" href="{{ route('importedTable') }}">ทะเบียนหนังสือ</a></li>
                                </div>
                            </ul>

                        </li>

                        @can('create')
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle navbarMenu" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                สร้างหนังสือ
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end ">
                                <div class="d-flex flex-column justify-content-center">
                                    @can('MOU')
                                        <li><a class="dropdown-item" href="{{ route('mouForm') }}">MOU</a></li>
                                    @endcan
                                    @can('PRO')
                                        <li><a class="dropdown-item" href="{{ route('projForm') }}">Project</a></li>
                                    @endcan
                                    @can('POL')
                                        <li><a class="dropdown-item" href="{{ route('policyForm') }}">Policy</a></li>
                                    @endcan
                                    @can('SOP')
                                        <li><a class="dropdown-item" href="{{ route('sopForm') }}">SOP</a></li>
                                    @endcan
                                    @can('WI')
                                        <li><a class="dropdown-item" href="{{ route('wiForm') }}">WI</a></li>
                                    @endcan
                                    @can('ANNO')
                                        <li><a class="dropdown-item" href="{{ route('annoForm') }}">Announce</a></li>
                                    @endcan
                                </div>
                            </ul>
                        </li>
                        @endcan

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle navbarMenu" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                ทะเบียนหนังสือ
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end ">
                                <div class="d-flex flex-column justify-content-center">
                                    @can('MOU')
                                        <li><a class="dropdown-item" href="{{ route('mouTable') }}">MOU</a></li>
                                    @endcan
                                    @can('PRO')
                                        <li><a class="dropdown-item" href="{{ route('projTable') }}">Project</a></li>
                                    @endcan
                                    @can('POL')
                                        <li><a class="dropdown-item" href="{{ route('policyTable') }}">Policy</a></li>
                                    @endcan
                                    @can('SOP')
                                        <li><a class="dropdown-item" href="{{ route('sopTable') }}">SOP</a></li>
                                    @endcan
                                    @can('WI')
                                        <li><a class="dropdown-item" href="{{ route('wiTable') }}">WI</a></li>
                                    @endcan
                                    @can('ANNO')
                                        <li><a class="dropdown-item" href="{{ route('annoTable') }}">Announce</a></li>
                                    @endcan
                                </div>
                            </ul>
                        </li>
                        @if (auth()->check() && (auth()->user()->can('approve') || auth()->user()->can('inspect')))
                            <li class="nav-item"><a href="{{ route('verifyDoc') }}" class="nav-link navbarMenu">ตรวจสอบ/อนุมัติ</a></li>
                        @endif
                        @role('admin')
                        <li class="nav-item "><a href="{{ route('alluser') }}" class="nav-link navbarMenu">จัดการบัญชีผู้ใช้</a></li>
                        @endrole
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            <!-- @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif -->
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle navbarMenu" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end " aria-labelledby="navbarDropdown">
                                    <div class="d-flex flex-column justify-content-center">
                                        <li class="text-center"><a class="dropdown-item" href="{{ route('profile') }}">ตั้งค่าบัญชี</a></li>
                                        <li>
                                            <a class="dropdown-item text-center" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                {{ __('ออกจากระบบ') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        <h5 class="fixed-bottom m-5">
            <div class="theme-container shadow-light" >
                <i class="bi bi-sun" id="theme-icon"></i>
            </div>
        </h5>
    </div>
    @include('sweetalert::alert')
</body>

<script>
    document.body.style="background-color: var(--bs-dark);transition: 0.5s;"
const sun = "bi-sun";
const moon = "bi-moon-stars"

var theme = "light";
const root = document.querySelector(":root");
const container = document.getElementsByClassName("theme-container")[0];
const themeIcon = document.getElementById("theme-icon");
const navb = document.getElementById("navb");
container.addEventListener("click", setTheme);

function setTheme() {
    switch (theme) {
        case "dark":
            setLight();
            theme = "light";
            break;
        case "light":
            setDark();
            theme = "dark";
            break;
    }
}

function setLight() {
    root.style.setProperty(
        "--bs-dark",
        "rgb(242, 255, 255)"
    );
    container.classList.remove("shadow-dark");
    themeIcon.classList.remove(moon);
    navb.classList.remove("nav-dark");
    setTimeout(() => {
        container.classList.add("shadow-light");
        themeIcon.classList.remove("change");
    }, 300);
    themeIcon.classList.add("change");
    navb.classList.add("nav-light");
    themeIcon.classList.add(sun);
}

function setDark() {
    root.style.setProperty("--bs-dark", "#212529");
    container.classList.remove("shadow-light");
    themeIcon.classList.remove(sun);
    navb.classList.remove("nav-light");
    setTimeout(() => {
        container.classList.add("shadow-dark");
        themeIcon.classList.remove("change");
    }, 300);
    themeIcon.classList.add("change");
    navb.classList.add("nav-dark");
    themeIcon.classList.add(moon);
}
</script>
</html>
