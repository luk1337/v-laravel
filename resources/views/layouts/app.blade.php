<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}{{ !empty($title) ? " 〜 " . $title : '' }}</title>

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarLists" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Lists
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarLists">
                                    @auth
                                        <a class="dropdown-item" href="{{ route('list/my') }}">{{ __('My lists') }}</a>
                                        <a class="dropdown-item" href="{{ route('list/my/subscriptions') }}">{{ __('My subscribed lists') }}</a>
                                    @endauth
                                    <a class="dropdown-item" href="{{ route('list/public') }}">{{ __('Public lists') }}</a>
                                    @auth
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('list/create') }}">{{ __('Create new list') }}</a>
                                    @endauth
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('latest-bans') }}">{{ __('Latest bans') }}</a>
                            </li>
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->email }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('change-password') }}">
                                            {{ __('Change password') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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

            <footer>
                <div class="container">
                    <div class="float-left">
                        <a href="https://github.com/luk1337/v-laravel">{{ __('Source code') }}</a>
                    </div>
                    <div class="float-right">
                        Copyright &copy; {{ Date("Y") }}, <a href="mailto:priv.luk@gmail.com">LuK1337</a>.
                    </div>
                </div>
            </footer>

        </div>
        @yield('scripts')
    </body>
</html>
