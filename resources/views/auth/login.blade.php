@extends('layouts.app', ['title' => __('Login')])

@section('content')
    <div class="container">
        <h1 class="title">{{ __('Login') }}</h1>

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
                        <div class="control">
                            <input class="is-checkradio is-info" type="checkbox" id="remember"
                                   name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">{{ __('Remember Me') }}</label>
                        </div>
                    </div>

                    <div class="field">
                        {!! no_captcha()->display(null, ['data-theme' => 'dark']) !!}

                        @error('g-recaptcha-response')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <button type="submit" class="button is-info">
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="button is-text" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {!! no_captcha()->script() !!}
@endsection
