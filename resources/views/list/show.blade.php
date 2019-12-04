@extends('layouts.app', ['title' => __('Showing list 〜 :name', ['name' => $list->name])])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="float-left">
                <h2>{{ __('Showing list 〜 :name', ['name' => $list->name]) }}</h2>
            </div>
            @auth
                <div class="float-right">
                    @if ($list->user_id == Auth::id())
                        <a href="{{ route('list/add', ['uuid' => $list->uuid]) }}" class="btn btn-dark btn-page">{{ __('Add account') }}</a>
                    @else
                        @if (!Auth::User()->subscriptions()->get()->contains('user_list_id', $list->id))
                            <a href="{{ route('list/subscribe', ['uuid' => $list->uuid]) }}" class="btn btn-success btn-page">{{ __('Subscribe') }}</a>
                        @else
                            <a href="{{ route('list/unsubscribe', ['uuid' => $list->uuid]) }}" class="btn btn-danger btn-page">{{ __('Unsubscribe') }}</a>
                        @endif
                    @endif
                </div>
            @endauth
            <div class="clearfix"></div>

            @if ($accounts->isEmpty())
                <b>{{ __('Sowwy, it looks like this list is empty.') }}</b>
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
                                <th>{{ __('Added at') }}</th>
                                @if (Auth::check() && $list->user_id == Auth::id())
                                    <th>{{ __('Actions') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accounts as $account)
                                <tr class="valign-middle">
                                    <th scope="row">{{ $loop->iteration + (($accounts->currentPage() - 1) * $accounts->perPage()) }}</th>
                                    <td><a href="https://steamcommunity.com/profiles/{{ $account->steamid }}"><img src="{{ $account->avatar }}" /></a></td>
                                    <td><a href="https://steamcommunity.com/profiles/{{ $account->steamid }}">{{ $account->name }}</a></td>
                                    <td class="{{$account->number_of_game_bans > 0 ? ' text-danger' : ''}}">{{ $account->number_of_game_bans }}</td>
                                    <td class="{{$account->number_of_vac_bans > 0 ? ' text-danger' : ''}}">{{ $account->number_of_vac_bans }}</td>
                                    @if ($account->number_of_vac_bans > 0 || $account->number_of_game_bans > 0)
                                        <td><span class="underline-dotted" title="{{ $account->getLastBanTime() }}" data-toggle="tooltip" data-placement="bottom">{{ $account->getLastBanTime()->format('Y-m-d') }}</span></td>
                                    @else
                                        <td>—</td>
                                    @endif
                                    @if ($account->pivot->created_at)
                                        <td><span class="underline-dotted" title="{{ $account->pivot->created_at }}" data-toggle="tooltip" data-placement="bottom">{{ $account->pivot->created_at->format('Y-m-d') }}</span></td>
                                    @else
                                        <td>—</td>
                                    @endif
                                    @if (Auth::check() && $list->user_id == Auth::id())
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('list/delete/account', ['uuid' => $list->uuid, 'steamid' => $account->steamid]) }}" class="btn btn-danger btn-xs">{{ __('Delete') }}</a>
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
    </div>
</div>
@endsection
