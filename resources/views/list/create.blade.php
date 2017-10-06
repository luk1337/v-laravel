@extends('layouts.app', ['title' => 'Create list'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 style="margin-top: 0">Create list</h2>

            <form class="form-horizontal" method="post">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-sm-4 control-label">Name</label>
                    <div class="col-sm-4">
                        <input id="name" type="text" maxlength="32" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}" required autofocus>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('privacy') ? ' has-error' : '' }}">
                    <label for="privacy" class="col-sm-4 control-label">Privacy</label>
                    <div class="col-sm-4">
                        <select id="privacy" class="form-control" name="privacy" required>
                            @foreach (App\UserList::$listPrivacyTypes as $key => $value)
                                <option value="{{ $key }}"{{old('privacy') == $key ? ' selected' : ''}}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-6">
                        <button type="submit" class="btn btn-default">Create list</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection