@extends('layouts.app', ['title' => __('Change password')])

@section('content')
    <div class="container">
        <h1 class="title">{{ __('Change password') }}</h1>

        <div class="columns is-mobile is-centered">
            <div class="column is-one-third">
                <form method="POST">
                    @csrf

                    <div class="field">
                        <label class="label">{{ __('Current password') }}</label>
                        <div class="control">
                            <input class="input @error('current_password') is-danger @enderror" type="password"
                                   name="current_password" required autocomplete="current-password">
                        </div>

                        @error('current_password')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label class="label">{{ __('New password') }}</label>
                        <div class="control">
                            <input class="input @error('password') is-danger @enderror" type="password"
                                   name="password" required autocomplete="new-password">
                        </div>

                        @error('password')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label class="label">{{ __('Confirm new password') }}</label>
                        <div class="control">
                            <input class="input @error('password_confirmation') is-danger @enderror" type="password"
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>

                        @error('password_confirmation')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <button type="submit" class="button is-primary">
                            {{ __('Change password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
