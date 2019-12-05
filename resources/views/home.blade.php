@extends('layouts.app', ['title' => __('Home')])

@section('content')
    <div class="container">
        <h1 class="title">{{ __('Home') }}</h1>
        <h2 class="subtitle">{{ __('Welcome to V') }}</h2>

        <div class="content">
            <p>{{ __('By creating an account here you\'ll be able to:') }}</p>
            <ul>
                <li>{{ __('Add suspicious players to your list(s).') }}</li>
                <li>{{ __('Subscribe to public / unlisted list(s).') }}</li>
                <li>{{ __('Get notified whenever somebody gets banned.') }}</li>
            </ul>

            <p>{{ __('As an unregistered user you\'ll be able to:') }}</p>
            <ul>
                <li>{{ __('View public / unlisted lists.') }}</li>
                <li>{{ __('View list of latest bans.') }}</li>
            </ul>
        </div>
    </div>
@endsection
