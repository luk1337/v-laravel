@extends('layouts.app', ['title' => 'Add accounts to list 〜 ' . $list->name])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Add accounts to list 〜 {{ $list->name }}</h2>

                <form class="form-horizontal" method="post">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('steamids') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-4 control-label">Steam IDs</label>
                        <div class="col-sm-4">
                            <textarea rows="12" cols="205" id="steamids" class="form-control" name="steamids" placeholder="http://steamcommunity.com/id/luk_1337&#10;http://steamcommunity.com/profiles/76561198058211132&#10;http://steamcommunity.com/profiles/[U:1:97945404]&#10;luk_1337&#10;76561198058211132&#10;STEAM_0:0:48972702&#10;[U:1:97945404]" required autofocus>
                                {{ (old('steamids') ?: $list->steamids) }}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-6">
                            <button type="submit" class="btn btn-primary">Add to list</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection