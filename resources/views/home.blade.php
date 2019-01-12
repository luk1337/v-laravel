@extends('layouts.app', ['title' => __('Home')])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>{{ __('Home') }}</h2>

            <p>{{ __('Welcome to V.') }}</p>

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
</div>
@endsection