@extends('layouts.app', ['title' => __('Change password')])

@section('content')
    <div class="container">
        <h1 class="title">{{ __('API key') }}</h1>

        <div class="columns is-mobile is-centered">
            <div class="column is-one-third">
                <div class="field">
                    <label class="label">{{ __('Your API key') }}</label>
                    <div class="control">
                        <input class="input" type="text" value="{{ $api_key ?: 'n/a' }}" readonly disabled>
                    </div>
                </div>

                @if ($api_key !== null)
                    <form class="is-inline-block" method="POST" action="{{ route('api-key/reset') }}">
                        @csrf

                        <button type="submit" class="button is-danger">
                            {{ __('Reset') }}
                        </button>
                    </form>
                @endif

                <form class="is-inline-block" method="POST" action="{{ route('api-key/regen') }}">
                    @csrf

                    <button type="submit" class="button is-info">
                        @if ($api_key !== null)
                            {{ __('Regenerate') }}
                        @else
                            {{ __('Generate') }}
                        @endif
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
