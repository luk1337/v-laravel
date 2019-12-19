@extends('layouts.app', ['title' => __('Latest bans')])

@section('content')
    <div class="container">
        <h1 class="title">{{ __('Latest bans') }}</h1>

        @if ($accounts->isEmpty())
            <b>{{ __('Sowwy, it looks like no one got banned recently.') }}</b>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $accounts->links() }}
        @endif
    </div>
@endsection
