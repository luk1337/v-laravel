@extends('layouts.app', ['title' => __('My subscribed lists')])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>{{ __('My subscribed lists') }}</h2>

            @if ($lists->isEmpty())
                <b>{{ __('Sowwy, it looks like you didn\'t subscribe to any list.') }}</b>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __(')#') }}</th>
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
                                <tr>
                                    <th class="valign-middle" scope="row">{{ $loop->iteration }}</th>
                                    <td class="valign-middle"><a href="{{ route('list/show', ['uuid' => $list->uuid]) }}">{{ $list->name }}</a></td>
                                    <td class="valign-middle">{{ App\UserList::$listPrivacyTypes[$list->privacy] }}</td>
                                    @if (!$list->getBannedAccounts()->isEmpty())
                                        <td class="valign-middle">{{ $list->accounts->count() }}（{{ (int)(($list->getBannedAccounts()->count() / $list->accounts()->count()) * 100) }}%）</td>
                                    @else
                                        <td class="valign-middle">{{ $list->accounts->count() }}</td>
                                    @endif
                                    <td class="valign-middle">{{ Carbon\Carbon::parse($list->created_at)->format('Y-m-d') }}</td>
                                    <td class="valign-middle">
                                        <a href="{{ route('list/unsubscribe', ['uuid' => $list->uuid]) }}" class="btn btn-xs btn-danger">{{ __('Unsubscribe') }}</a>
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