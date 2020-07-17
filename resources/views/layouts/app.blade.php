<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstra‌p.min.css">
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap‌.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="collapse navbar-collapse show">
                <ul class="navbar-nav mr-auto">
                    @guest
                        <li class="nav-item profile">
                            <a class="nav-link" href="{{ route('login') }}">Вход</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                        </li>
                    @else
                        <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
                            <a class="nav-link" href="/home">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                     class="bi bi-house-door-fill" fill="currentColor"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.5 10.995V14.5a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5V11c0-.25-.25-.5-.5-.5H7c-.25 0-.5.25-.5.495z"/>
                                    <path fill-rule="evenodd"
                                          d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                                </svg>
                            </a>
                        </li>
                        <li class="nav-item dropdown {{ request()->is('gladiator') || request()->is('slave') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                Рынок
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/gladiator">Гладиаторы</a>
                                <a class="dropdown-item" href="/slave">Рабыни</a>
                            </div>
                        </li>
                        <li class="nav-item {{ request()->is('users') ? 'active' : '' }}">
                            <a class="nav-link" href="/users">Игроки</a>
                        </li>
                        <li class="nav-item {{ request()->is('myGladiators') ? 'active' : '' }}">
                            <a class="nav-link" href="/myGladiators">Мои гладиаторы</a>
                        </li>
                        <li class="nav-item {{ request()->is('mySlaves') ? 'active' : '' }}">
                            <a class="nav-link" href="/mySlaves">Мои рабыни</a>
                        </li>
                        <li class="nav-item {{ request()->is('sendInvite') ? 'active' : '' }}">
                            <a class="nav-link" href="/sendInvite">Пригласить друга</a>
                        </li>
                        <li class="nav-item dropdown profile {{ request()->is('profile') ? 'active' : '' }}">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <span style="margin-right: 5px">{{ Auth::user()->name }}</span>
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                     class="bi bi-person-circle" fill="currentColor"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.468 12.37C12.758 11.226 11.195 10 8 10s-4.757 1.225-5.468 2.37A6.987 6.987 0 0 0 8 15a6.987 6.987 0 0 0 5.468-2.63z"/>
                                    <path fill-rule="evenodd" d="M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    <path fill-rule="evenodd"
                                          d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z"/>
                                </svg>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="/profile">
                                    Профиль
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    Выход
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
    </header>

    <main class="py-4">
        @yield('content')
    </main>
</div>

<style>
    .header .profile {
        margin-left: auto;
    }
    .header .navbar-nav {
        width: 100%;

    }
    .header .nav-item:nth-child(2) {
        margin-left: auto;
    }
    .card {
        margin: 10px;
    }
</style>

</body>
</html>
