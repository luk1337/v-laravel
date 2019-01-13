@extends('layouts.app', ['title' => 'Verify Your Email Address'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                <h2>{{ __('Verify Your Email Address') }}</h2>

                <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                <p>{{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.</p>
            </div>
        </div>
    </div>
@endsection