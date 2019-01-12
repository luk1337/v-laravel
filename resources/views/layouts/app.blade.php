<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}{{ !empty($title) ? " 〜 " . $title : '' }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>

                    <!-- Collapsed Hamburger -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarLists" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Lists
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarLists">
                                    @auth
                                        <a class="dropdown-item" href="{{ route('list/my') }}">My lists</a>
                                        <a class="dropdown-item" href="{{ route('list/my/subscriptions') }}">My subscribed lists</a>
                                    @endauth
                                    <a class="dropdown-item" href="{{ route('list/public') }}">Public lists</a>
                                    @auth
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('list/create') }}">Create new list</a>
                                    @endauth
                                </div>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('latest-bans') }}">Latest bans</a></li>
                        </ul>
                        <ul class="navbar-nav">
                            @guest
                                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarUser" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ Auth::user()->email }}
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarUser">
                                        <a class="dropdown-item" href="{{ route('change-password') }}">Change password</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            @yield('content')

            <footer>
                <div class="container">
                    <div class="float-left">
                        <a href="https://github.com/luk1337/v-laravel">Source code</a>
                    </div>
                    <div class="float-right">
                        Copyright &copy; {{ Date("Y") }}, <a href="mailto:priv.luk@gmail.com">LuK1337</a>.
                    </div>
                </div>
            </footer>
        </div>

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}"></script>
        @yield('scripts')
    </body>
</html>
