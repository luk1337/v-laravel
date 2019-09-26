@extends('layouts.app', ['title' => __('Public lists')])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>{{ __('Public lists') }}</h2>

            @if ($lists->isEmpty())
                <b>{{ __('Sowwy, it looks like there are no public lists.') }}</b>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
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
                                    <td><a href="{{ route('list/show', ['uuid' => $list->uuid]) }}">{{ $list->name }}</a></td>
                                    <td>{{ App\UserList::$listPrivacyTypes[$list->privacy] }}</td>
                                    @if (!$list->getBannedAccounts()->isEmpty())
                                        <td>{{ $list->accounts->count() }}（{{ (int)(($list->getBannedAccounts()->count() / $list->accounts()->count()) * 100) }}%）</td>
                                    @else
                                        <td>{{ $list->accounts->count() }}</td>
                                    @endif
                                    <td>{{ Carbon\Carbon::parse($list->created_at)->format('Y-m-d') }}</td>
                                    <td>
                                        @if (Auth::Check() && $list->user_id != Auth::User()->id)
                                            <div class="btn-group btn-group-sm" role="group">
                                                @if (!Auth::User()->subscriptions()->get()->contains('user_list_id', $list->id))
                                                    <a href="{{ route('list/subscribe', ['uuid' => $list->uuid]) }}" class="btn btn-xs btn-success">{{ __('Subscribe') }}</a>
                                                @else
                                                    <a href="{{ route('list/unsubscribe', ['uuid' => $list->uuid]) }}" class="btn btn-xs btn-danger">{{ __('Unsubscribe') }}</a>
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
    </div>
</div>
@endsection