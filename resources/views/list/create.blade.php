@extends('layouts.app', ['title' => __('Create list')])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>{{ __('Create list') }}</h2>

            <div class="row justify-content-center align-items-center">
                <div class="col col-md-6 col-xl-4">
                    <form class="form-horizontal" method="post">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name" class="control-label">{{ __('Name') }}</label>
                            <input id="name" type="text" maxlength="64" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('privacy') ? ' has-error' : '' }}">
                            <label for="privacy" class="control-label">Privacy</label>
                            <select id="privacy" class="form-control{{ $errors->has('privacy') ? ' is-invalid' : '' }}" name="privacy" required>
                                @foreach (App\UserList::$listPrivacyTypes as $key => $value)
                                    <option value="{{ $key }}"{{old('privacy') == $key ? ' selected' : ''}}>{{ $value }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('privacy'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ __('Create list') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection