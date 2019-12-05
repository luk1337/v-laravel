@extends('layouts.app', ['title' => 'Verify your E-Mail address'])

@section('content')
    <div class="container">
        <h1 class="title">{{ __('Verify your E-Mail address') }}</h1>

        <div class="columns is-mobile is-centered">
            <div class="column is-half">
                @if (session('resent'))
                    <div class="notification is-success">
                        {{ __('A fresh verification link has been sent to your E-Mail address.') }}
                    </div>
                @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf

                        <button type="submit" class="button is-primary">
                            {{ __('click here to request another') }}
                        </button>
                    </form>
            </div>
        </div>
    </div>
@endsection
