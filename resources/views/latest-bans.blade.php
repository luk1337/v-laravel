@extends('layouts.app', ['title' => 'Latest bans'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-title">Latest bans</h2>

            @if ($accounts->isEmpty())
                <b>Sowwy, it looks like no one got banned recently.</b>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>Game bans</th>
                            <th>VAC bans</th>
                            <th>Last ban date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($accounts as $account)
                            <tr>
                                <th class="valign-middle" scope="row">{{ $loop->iteration + (($accounts->currentPage() - 1) * $accounts->perPage()) }}</th>
                                <td class="valign-middle"><img src="{{ $account->avatar }}" /></td>
                                <td class="valign-middle"><a href="https://steamcommunity.com/profiles/{{ $account->steamid }}">{{ $account->name }}</a></td>
                                <td class="valign-middle{{$account->number_of_game_bans > 0 ? ' text-danger' : ''}}">{{ $account->number_of_game_bans }}</td>
                                <td class="valign-middle{{$account->number_of_vac_bans > 0 ? ' text-danger' : ''}}">{{ $account->number_of_vac_bans }}</td>
                                @if ($account->number_of_vac_bans > 0 || $account->number_of_game_bans > 0)
                                    <td class="valign-middle"><span title="{{ $account->getLastBanTime() }}" data-toggle="tooltip" data-placement="bottom">{{ $account->getLastBanTime()->format('Y-m-d') }}</span></td>
                                @else
                                    <td class="valign-middle">—</td>
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