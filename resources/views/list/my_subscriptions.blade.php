@extends('layouts.app', ['title' => __('My subscribed lists')])

@section('content')
    <div class="container">
        <h1 class="title">{{ __('My subscribed lists') }}</h1>

        @if ($lists->isEmpty())
            <b>{{ __('Sowwy, it looks like you don\'t have any lists') }}</b>
        @else
            <div class="table-container" data-simplebar>
                <table class="table is-stripped is-fullwidth">
                    <thead>
                        <tr>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Privacy') }}</th>
                            <th>{{ __('Users') }}</th>
                            <th>{{ __('Creation date') }}</th>
                            @auth
                                <th>{{ __('Actions') }}</th>
                            @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lists as $list)
                            <tr class="valign-middle">
                                <th>{{ $loop->iteration }}</th>
                                <td><a href="{{ route('list/show', ['uuid' => $list->uuid]) }}">{{ $list->name }}</a>
                                </td>
                                <td>{{ App\Models\UserList::$listPrivacyTypes[$list->privacy] }}</td>
                                @if (!$list->getBannedAccounts()->isEmpty())
                                    <td>{{ $list->accounts->count() }}（{{ (int)(($list->getBannedAccounts()->count() / $list->accounts()->count()) * 100) }} %）</td>
                                @else
                                    <td>{{ $list->accounts->count() }}</td>
                                @endif
                                <td>{{ Carbon\Carbon::parse($list->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <div class="buttons has-addons">
                                        <a href="{{ route('list/unsubscribe', ['uuid' => $list->uuid]) }}" class="button is-danger is-small">{{ __('Unsubscribe') }}</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
