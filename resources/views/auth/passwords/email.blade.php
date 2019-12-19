@extends('layouts.app', ['title' => 'Reset password'])

@section('content')
    <div class="container">
        <h1 class="title">{{ __('Reset passsword') }}</h1>

        <div class="columns is-mobile is-centered">
            <div class="column is-one-third">
                @if (session('status'))
                    <div class="notification is-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="field">
                        <label class="label">{{ __('E-Mail address') }}</label>
                        <div class="control">
                            <input class="input @error('email') is-danger @enderror" type="email"
                                   name="email" value="{{ old('email') }}" required autocomplete="email">
                        </div>

                        @error('email')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        {!! no_captcha()->display(null, ['data-theme' => 'dark']) !!}

                        @error('g-recaptcha-response')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <button type="submit" class="button is-info">
                            {{ __('Send password reset link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {!! no_captcha()->script() !!}
@endsection
