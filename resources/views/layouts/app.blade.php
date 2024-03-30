<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h1 class="h5 mb-0">{{ config('app.name')}}
                        @auth
                            @if (Auth::user()->role_id == 1)
                                <span class="h6 mb-0 text-danger ms-3"> for {{ Auth::user()->name }}</span>
                            @else
                                <span class="h6 mb-0 text-secondary ms-3"> for {{ Auth::user()->name }}</span>
                            @endif
                        @endauth
                    </h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto mb-0">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            {{-- Home --}}
                            <li class="nav-item" title="home">
                                <a href="{{ route('index') }}" class="nav-link"><i class="fa-solid fa-house icon-sm"></i></a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('panel') }}" class="nav-link"><i class="fa-solid fa-file icon-sm"></i></a>
                            </li>

                            {{-- Dashboard only for the admins --}}
                            @can('admin')
                                {{-- @can() ~~ checks if the AUTH user has certain action/permissions --}}
                                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                    <i class="fa-solid fa-chart-line icon-sm"></i>
                                </a>
                            @endcan

                            {{-- Admin controll --}}
                            @can('admin')
                                <a href="{{ route('admin.setting.promoters') }}" class="nav-link">
                                    <i class="fa-solid fa-gear icon-sm"></i>
                                </a>
                            @endcan

                            {{-- Create Report --}}
                            <li class="nav-item">
                                <a href="{{ route('report.create') }}" class="nav-link"><i class="fa-solid fa-plus icon-sm"></i></a>
                            </li>

                            {{-- Account --}}
                            <li class="nav-item dropdown">
                                <button class="btn nav-link" id="account-dropdown" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-circle-user icon-sm"></i>
                                </button>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="account-dropdown">
                                    {{-- Logout --}}
                                    <a href="" class="dropdown-item"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                            <i class="fa-solid fa-right-to-bracket"></i> {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>

                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
