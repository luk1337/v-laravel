@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 style="margin-top: 0">Add accounts to list 〜 {{ $list->name }}</h2>

                <form class="form-horizontal" method="post">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('steamids') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-4 control-label">Steam IDs</label>
                        <div class="col-sm-4">
                            <textarea rows="12" id="steamids" class="form-control" name="steamids" placeholder="http://steamcommunity.com/id/luk_1337&#10;76561198058211132" required autofocus>
                                {{ (old('steamids') ?: $list->steamids) }}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-6">
                            <button type="submit" class="btn btn-default">Add to list</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection