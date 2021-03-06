@extends('layouts.app', ['title' => __('Editing list 〜 :name', ['name' => $list->name])])

@section('content')
    <div class="container">
        <h1 class="title">{{ __('Editing list') }}</h1>
        <h2 class="subtitle">{{ $list->name }}</h2>

        <div class="columns is-mobile is-centered">
            <div class="column is-one-third">
                <form method="POST">
                    @csrf

                    <div class="field">
                        <label class="label">{{ __('Name') }}</label>
                        <div class="control">
                            <input class="input @error('name') is-danger @enderror" type="text"
                                   name="name" value="{{ old('name') ?: $list->name }}" maxlength="64" required
                                   autofocus>
                        </div>

                        @error('name')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label class="label">{{ __('Privacy') }}</label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select class="@error('privacy') is-danger @enderror" name="privacy">
                                    @foreach (App\Models\UserList::$listPrivacyTypes as $key => $value)
                                        <option value="{{ $key }}" {{ (old('privacy') ?: $list->privacy) === $key ? ' selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @error('privacy')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <button type="submit" class="button is-info">
                            {{ __('Save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
