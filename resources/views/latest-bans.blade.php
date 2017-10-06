@extends('layouts.app', ['title' => 'Latest bans'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                <h2 style="margin-top: 0">Latest bans</h2>
            </div>

            @if ($accounts->isEmpty())
                <b>Sowwy, it looks like no one got banned recently.</b>
            @else
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
                            <th style="vertical-align: middle" scope="row">{{ $loop->iteration + (($accounts->currentPage() - 1) * $accounts->perPage()) }}</th>
                            <td style="vertical-align: middle"><img src="{{ $account->avatar }}" /></td>
                            <td style="vertical-align: middle"><a href="https://steamcommunity.com/profiles/{{ $account->steamid }}">{{ $account->name }}</a></td>
                            <td style="vertical-align: middle{{$account->number_of_game_bans > 0 ? '; color: red' : ''}}">{{ $account->number_of_game_bans }}</td>
                            <td style="vertical-align: middle{{$account->number_of_vac_bans > 0 ? '; color: red' : ''}}">{{ $account->number_of_vac_bans }}</td>
                            <td style="vertical-align: middle">{{ $account->number_of_vac_bans > 0 || $account->number_of_game_bans > 0 ? $account->last_ban_date : '—' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $accounts->links() }}
            @endif
        </div>
    </div>
</div>
@endsection