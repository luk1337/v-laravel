@extends('layouts.app', ['title' => __('Add accounts to list 〜 :name', ['name' => $list->name])])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>{{ __('Add accounts to list 〜 :name', ['name' => $list->name]) }}</h2>

            <div class="row justify-content-center align-items-center">
                <div class="col col-md-6 col-xl-4">
                    <form class="form-horizontal" method="post">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name" class="control-label">Steam IDs</label>
                            <textarea rows="12" cols="205" id="steamids" class="form-control{{ $errors->has('steamids') ? ' is-invalid' : '' }}" name="steamids" placeholder="http://steamcommunity.com/id/luk_1337&#10;http://steamcommunity.com/profiles/76561198058211132&#10;http://steamcommunity.com/profiles/[U:1:97945404]&#10;luk_1337&#10;76561198058211132&#10;STEAM_0:0:48972702&#10;[U:1:97945404]" required autofocus>{{ old('steamids') ?: $list->steamids }}</textarea>

                            @if ($errors->has('steamids'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('steamids') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ __('Add to list') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection