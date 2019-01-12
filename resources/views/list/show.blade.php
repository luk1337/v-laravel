@extends('layouts.app', ['title' => 'Showing list 〜 ' . $list->name])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="float-left">
                <h2 class="mt-3">Showing list 〜 {{ $list->name }}</h2>
            </div>
            @auth
                <div class="float-right">
                    @if ($list->user_id == Auth::user()->id)
                        <a href="{{ route('list/add', ['uuid' => $list->uuid]) }}" class="btn btn-dark btn-page mt-3">Add account</a>
                    @else
                        @if (!Auth::User()->subscriptions()->get()->contains('user_list_id', $list->id))
                            <a href="{{ route('list/subscribe', ['uuid' => $list->uuid]) }}" class="btn btn-success btn-page mt-3">Subscribe</a>
                        @else
                            <a href="{{ route('list/unsubscribe', ['uuid' => $list->uuid]) }}" class="btn btn-danger btn-page mt-3">Unsubscribe</a>
                        @endif
                    @endif
                </div>
            @endauth
            <div class="clearfix"></div>

            @if ($accounts->isEmpty())
                <b>Sowwy, it looks like this list is empty.</b>
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
                            <th>Added at</th>
                            @if (Auth::check() && $list->user_id == Auth::user()->id)
                                <th>Actions</th>
                            @endif
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
                                    <td class="valign-middle"><span class="underline-dotted" title="{{ $account->getLastBanTime() }}" data-toggle="tooltip" data-placement="bottom">{{ $account->getLastBanTime()->format('Y-m-d') }}</span></td>
                                @else
                                    <td class="valign-middle">—</td>
                                @endif
                                @if ($account->pivot->created_at)
                                    <td class="valign-middle"><span class="underline-dotted" title="{{ $account->pivot->created_at }}" data-toggle="tooltip" data-placement="bottom">{{ $account->pivot->created_at->format('Y-m-d') }}</span></td>
                                @else
                                    <td class="valign-middle">—</td>
                                @endif
                                @if (Auth::check() && $list->user_id == Auth::user()->id)
                                    <td class="valign-middle">
                                        <a href="{{ route('list/delete/account', ['uuid' => $list->uuid, 'steamid' => $account->steamid]) }}" class="btn btn-danger btn-xs">Delete</a>
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
    </div>
</div>
@endsection