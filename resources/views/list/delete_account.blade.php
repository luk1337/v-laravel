@extends('layouts.app', ['title' => __('Delete account from list 〜 :name', ['name' => $list->name])])

@section('content')
    <div class="container">
        <h1 class="title">{{ __('Delete account from list') }}</h1>
        <h2 class="subtitle">{{ $list->name }}</h2>

        <div class="columns is-mobile is-centered">
            <div class="column is-one-third">
                <form method="POST">
                    @csrf

                    <div class="field">
                        <p>{{ __('Are you sure you want to delete :name from the list?', ['name' => $account->name]) }}</p>
                    </div>

                    <hr/>

                    <div class="field">
                        <button type="submit" class="button is-danger">{{ __('Yes') }}</button>
                        <a href="{{ url()->previous() }}" class="button is-dark">{{ __('No') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
