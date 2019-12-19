@extends('layouts.app', ['title' => __('List 〜 :name', ['name' => $list->name])])

@section('content')
    <div class="container">
        <div class="is-pulled-left">
            <h1 class="title">{{ __('List') }}</h1>
            <h2 class="subtitle">{{ $list->name }}</h2>
        </div>

        @auth
            <div class="is-pulled-right">
                @if ($list->user_id === Auth::id())
                    <a href="{{ route('list/add', ['uuid' => $list->uuid]) }}"
                       class="button is-info">{{ __('Add account') }}</a>
                @else
                    @if (!Auth::User()->subscriptions()->get()->contains('user_list_id', $list->id))
                        <a href="{{ route('list/subscribe', ['uuid' => $list->uuid]) }}"
                           class="button is-success">{{ __('Subscribe') }}</a>
                    @else
                        <a href="{{ route('list/unsubscribe', ['uuid' => $list->uuid]) }}"
                           class="button is-danger">{{ __('Unsubscribe') }}</a>
                    @endif
                @endif
            </div>
        @endauth

        <div class="is-clearfix" style="margin-bottom: 1.5rem"></div>

        @if ($accounts->isEmpty())
            <b>{{ __('Sowwy, it looks like this list is empty.') }}</b>
        @else
            <div class="table-container" data-simplebar>
                <table class="table is-stripped is-fullwidth">
                    <thead>
                        <tr>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Avatar') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Game bans') }}</th>
                            <th>{{ __('VAC bans') }}</th>
                            <th>{{ __('Last ban date') }}</th>
                            <th>{{ __('Added at') }}</th>
                            @if (Auth::check() && $list->user_id === Auth::id())
                                <th>{{ __('Actions') }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $account)
                            <tr class="valign-middle">
                                <th>{{ $loop->iteration + (($accounts->currentPage() - 1) * $accounts->perPage()) }}</th>
                                <td>
                                    <a href="https://steamcommunity.com/profiles/{{ $account->steamid }}" class="image is-32x32">
                                        <img class="is-block is-rounded" src="{{ $account->getAvatarFull() }}"/>
                                    </a>
                                </td>
                                <td>
                                    <a href="https://steamcommunity.com/profiles/{{ $account->steamid }}">{{ $account->name }}</a>
                                </td>
                                <td class="{{$account->number_of_game_bans > 0 ? ' text-danger' : ''}}">{{ $account->number_of_game_bans }}</td>
                                <td class="{{$account->number_of_vac_bans > 0 ? ' text-danger' : ''}}">{{ $account->number_of_vac_bans }}</td>
                                @if ($account->number_of_vac_bans > 0 || $account->number_of_game_bans > 0)
                                    <td>
                                        <span class="underline-dotted has-tooltip-top"
                                              data-tooltip="{{ $account->getLastBanTime() }}">
                                            {{ $account->getLastBanTime()->format('Y-m-d') }}
                                        </span>
                                    </td>
                                @else
                                    <td>—</td>
                                @endif
                                @if ($account->pivot->created_at)
                                    <td>
                                        <span class="underline-dotted has-tooltip-top"
                                              data-tooltip="{{ $account->pivot->created_at }}">
                                            {{ $account->pivot->created_at->format('Y-m-d') }}
                                        </span>
                                    </td>
                                @else
                                    <td>—</td>
                                @endif
                                @if (Auth::check() && $list->user_id === Auth::id())
                                    <td>
                                        <div class="buttons has-addons">
                                            <a href="{{ route('list/delete/account', ['uuid' => $list->uuid, 'steamid' => $account->steamid]) }}"
                                               class="button is-danger is-small">
                                                {{ __('Delete') }}
                                            </a>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $accounts->links() }}
        @endif
    </div>
@endsection
