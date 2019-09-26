@extends('layouts.app', ['title' => __('Latest bans')])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>{{ __('Latest bans') }}</h2>

            @if ($accounts->isEmpty())
                <b>{{ __('Sowwy, it looks like no one got banned recently.') }}</b>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
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
                                    <th scope="row">{{ $loop->iteration + (($accounts->currentPage() - 1) * $accounts->perPage()) }}</th>
                                    <td><img src="{{ $account->avatar }}" /></td>
                                    <td><a href="https://steamcommunity.com/profiles/{{ $account->steamid }}">{{ $account->name }}</a></td>
                                    <td class="{{$account->number_of_game_bans > 0 ? ' text-danger' : ''}}">{{ $account->number_of_game_bans }}</td>
                                    <td class="{{$account->number_of_vac_bans > 0 ? ' text-danger' : ''}}">{{ $account->number_of_vac_bans }}</td>
                                    @if ($account->number_of_vac_bans > 0 || $account->number_of_game_bans > 0)
                                        <td><span class="underline-dotted" title="{{ $account->getLastBanTime() }}" data-toggle="tooltip" data-placement="bottom">{{ $account->getLastBanTime()->format('Y-m-d') }}</span></td>
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
    </div>
</div>
@endsection