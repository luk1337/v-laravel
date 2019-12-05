@extends('layouts.app', ['title' => __('Public lists')])

@section('content')
    <div class="container">
        <h1 class="title">{{ __('Public lists') }}</h1>

        @if ($lists->isEmpty())
            <b>{{ __('Sowwy, it looks like there are no public lists.') }}</b>
        @else
            <div class="table-container">
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
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td><a href="{{ route('list/show', ['uuid' => $list->uuid]) }}">{{ $list->name }}</a>
                                </td>
                                <td>{{ App\UserList::$listPrivacyTypes[$list->privacy] }}</td>
                                @if (!$list->getBannedAccounts()->isEmpty())
                                    <td>{{ $list->accounts->count() }}（{{ (int)(($list->getBannedAccounts()->count() / $list->accounts()->count()) * 100) }}%）</td>
                                @else
                                    <td>{{ $list->accounts->count() }}</td>
                                @endif
                                <td>{{ Carbon\Carbon::parse($list->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    @if (Auth::Check() && $list->user_id != Auth::User()->id)
                                        <div class="buttons has-addons">
                                            @if (!Auth::User()->subscriptions()->get()->contains('user_list_id', $list->id))
                                                <a href="{{ route('list/subscribe', ['uuid' => $list->uuid]) }}" class="button is-info is-small">{{ __('Subscribe') }}</a>
                                            @else
                                                <a href="{{ route('list/unsubscribe', ['uuid' => $list->uuid]) }}" class="button is-danger is-small">{{ __('Unsubscribe') }}</a>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
