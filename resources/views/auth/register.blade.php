@extends('layouts.app', ['title' => __('Register')])

@section('content')
    <div class="container">
        <h1 class="title">{{ __('API key') }}</h1>

        <div class="columns is-mobile is-centered">
            <div class="column is-one-third">
                <form method="POST">
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
                        <label class="label">{{ __('Password') }}</label>
                        <div class="control">
                            <input class="input @error('password') is-danger @enderror" type="password"
                                   name="password" required autocomplete="password">
                        </div>

                        @error('password')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label class="label">{{ __('Confirm password') }}</label>
                        <div class="control">
                            <input class="input @error('password') is-danger @enderror" type="password"
                                   name="password_confirmation" required autocomplete="password">
                        </div>

                        @error('password_confirmation')
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
                            {{ __('Register') }}
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
