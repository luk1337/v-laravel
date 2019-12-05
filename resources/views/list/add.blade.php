@extends('layouts.app', ['title' => __('Add account(s) to list 〜 :name', ['name' => $list->name])])

@section('content')
    <div class="container">
        <h1 class="title">{{ __('Add account(s) to list') }}</h1>
        <h2 class="subtitle">{{ $list->name }}</h2>

        <div class="columns is-mobile is-centered">
            <div class="column is-one-third">
                <form method="POST">
                    @csrf

                    <div class="field">
                        <label class="label">{{ __('Steam IDs') }}</label>
                        <div class="control">
                            <textarea rows="10" class="textarea @error('steamids') is-invalid @enderror"
                                      placeholder="http://steamcommunity.com/id/luk1337&#10;http://steamcommunity.com/profiles/76561198058211132&#10;http://steamcommunity.com/profiles/[U:1:97945404]&#10;luk1337&#10;76561198058211132&#10;STEAM_0:0:48972702&#10;[U:1:97945404]"
                                      name="steamids" required autofocus>{{ old('steamids') ?: $list->steamids }}</textarea>

                            @error('steamids')
                            <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="field">
                        <button type="submit" class="button is-primary">
                            {{ __('Save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
