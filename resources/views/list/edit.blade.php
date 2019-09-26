@extends('layouts.app', ['title' => __('Editing list 〜 :name', ['name' => $list->name])])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>{{ __('Editing list 〜 :name', ['name' => $list->name]) }}</h2>

            <div class="row justify-content-center align-items-center">
                <div class="col col-md-6 col-xl-4">
                    <form class="form-horizontal" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="name" class="col-form-label">{{ __('Name') }}</label>
                            <input id="name" type="text" maxlength="64" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="{{ __('Name') }}" value="{{ old('name') ?: $list->name }}" required autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="privacy" class="col-form-label">{{ __('Privacy') }}</label>
                            <select id="privacy" class="form-control @error('privacy') is-invalid @enderror" name="privacy" required>
                                @foreach (App\UserList::$listPrivacyTypes as $key => $value)
                                    <option value="{{ $key }}"{{ (old('privacy') ?: $list->privacy) == $key ? ' selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>

                            @error('privacy')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">{{ __('Save list') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
