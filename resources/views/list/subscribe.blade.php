@extends('layouts.app', ['title' => __('Subscribing list 〜 :name', ['name' => $list->name])])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>{{ __('Subscribing list 〜 :name', ['name' => $list->name]) }}</h2>

            <form class="form-horizontal" method="post">
                {{ csrf_field() }}

                <div class="form-group">
                    <div class="col-sm-12">
                        {{ __('Are you sure you want to subscribe this list?') }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                        <a href="{{ url()->previous() }}" class="btn btn-dark">{{ __('No') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection