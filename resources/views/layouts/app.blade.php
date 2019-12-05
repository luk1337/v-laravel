<!DOCTYPE html>
<html lang="en">
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
        <nav class="navbar" role="navigation" aria-label="main navigation">
            <div class="container">
                <div class="navbar-brand">
                    <a class="navbar-item" href="{{ url('/') }}">
                        V
                    </a>

                    <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false"
                       data-target="navbarBasicExample">
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                    </a>
                </div>

                <div id="navbarBasicExample" class="navbar-menu">
                    <div class="navbar-start">
                        <a class="navbar-item" href="{{ route('home') }}">
                            {{ __('Home') }}
                        </a>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link">
                                Lists
                            </a>

                            <div class="navbar-dropdown">
                                @auth
                                    <a class="navbar-item" href="{{ route('list/my') }}">
                                        {{ __('My lists') }}
                                    </a>
                                    <a class="navbar-item" href="{{ route('list/my/subscriptions') }}">
                                        {{ __('My subscribed lists') }}
                                    </a>
                                @endauth
                                <a class="navbar-item" href="{{ route('list/public') }}">
                                    {{ __('Public lists') }}
                                </a>
                                @auth
                                    <hr class="navbar-divider">
                                    <a class="navbar-item" href="{{ route('list/create') }}">
                                        {{ __('Create new list') }}
                                    </a>
                                @endauth
                            </div>
                        </div>
                        <a class="navbar-item" href="{{ route('latest-bans') }}">
                            {{ __('Latest bans') }}
                        </a>
                    </div>

                    <div class="navbar-end">
                        <!-- Authentication Links -->
                        @guest
                            <a class="navbar-item" href="{{ route('login') }}">
                                {{ __('Login') }}
                            </a>
                            @if (Route::has('register'))
                                <a class="navbar-item" href="{{ route('register') }}">
                                    {{ __('Register') }}
                                </a>
                            @endif
                        @else
                            <div class="navbar-item has-dropdown is-hoverable">
                                <a class="navbar-link">
                                    {{ Auth::user()->email }}
                                </a>

                                <div class="navbar-dropdown">
                                    <a class="navbar-item" href="{{ route('api-key') }}">
                                        {{ __('API key') }}
                                    </a>
                                    <a class="navbar-item" href="{{ route('change-password') }}">
                                        {{ __('Change password') }}
                                    </a>
                                    <a class="navbar-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
        </nav>

        <section id="content" class="section">
            @yield('content')
        </section>

        <footer class="footer">
            <div class="container">
                <div class="is-pulled-left">
                    <a href="https://github.com/luk1337/v-laravel">{{ __('Source code') }}</a>
                </div>
                <div class="is-pulled-right">
                    Copyright &copy; {{ Date("Y") }}, <a href="mailto:priv.luk@gmail.com">LuK1337</a>.
                </div>
            </div>
        </footer>

        @yield('scripts')
    </body>
</html>
