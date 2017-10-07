@extends('layouts.app', ['title' => 'Change password'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-title">Change password</h2>

            <form class="form-horizontal" method="POST" action="{{ route('change-password') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                    <label for="current_password" class="col-md-4 control-label">Current password</label>

                    <div class="col-md-4">
                        <input id="current_password" type="password" class="form-control" name="current_password" required>

                        @if ($errors->has('current_password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('current_password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">New password</label>

                    <div class="col-md-4">
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="col-md-4 control-label">Confirm new password</label>

                    <div class="col-md-4">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-4 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Change password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection