@extends('layouts.app', ['title' => __('Add accounts to list 〜 :name', ['name' => $list->name])])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>{{ __('Add accounts to list 〜 :name', ['name' => $list->name]) }}</h2>

            <div class="row justify-content-center align-items-center">
                <div class="col col-md-6 col-xl-4">
                    <form class="form-horizontal" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="name" class="col-form-label">Steam IDs</label>
                            <textarea rows="12" cols="205" id="steamids" class="form-control @error('steamids') is-invalid @enderror" name="steamids" placeholder="http://steamcommunity.com/id/luk_1337&#10;http://steamcommunity.com/profiles/76561198058211132&#10;http://steamcommunity.com/profiles/[U:1:97945404]&#10;luk_1337&#10;76561198058211132&#10;STEAM_0:0:48972702&#10;[U:1:97945404]" required autofocus>{{ old('steamids') ?: $list->steamids }}</textarea>

                            @error('steamids')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">{{ __('Add to list') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
