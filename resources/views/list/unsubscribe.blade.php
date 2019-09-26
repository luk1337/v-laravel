@extends('layouts.app', ['title' => __('Unsubscribing list 〜 :name', ['name' => $list->name])])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>{{ __('Unsubscribing list 〜 :name', ['name' => $list->name]) }}</h2>

            <form class="form-horizontal" method="post">
                @csrf

                <div class="form-group">
                    <div class="col-sm-12">
                        {{ __('Are you sure you want to unsubscribe this list?') }}
                    </div>
                </div>

                <div class="form-group mb-0">
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
