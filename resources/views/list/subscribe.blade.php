@extends('layouts.app', ['title' => __('Subscribe list 〜 :name', ['name' => $list->name])])

@section('content')
    <div class="container">
        <h1 class="title">{{ __('Subscribe list') }}</h1>
        <h2 class="subtitle">{{ $list->name }}</h2>

        <div class="columns is-mobile is-centered">
            <div class="column is-one-third">
                <form method="POST">
                    @csrf

                    <div class="field">
                        <p>{{ __('Are you sure you want to subscribe this list?') }}</p>
                    </div>

                    <hr/>

                    <div class="field">
                        <button type="submit" class="button is-info">{{ __('Yes') }}</button>
                        <a href="{{ url()->previous() }}" class="button is-dark">{{ __('No') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
