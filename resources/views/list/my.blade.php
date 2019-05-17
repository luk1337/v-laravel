@extends('layouts.app', ['title' => __('My lists')])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>{{ __('My lists') }}</h2>

            @if ($lists->isEmpty())
                <b>{{ __('Sowwy, it looks like you don\'t have any lists') }}</b>
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
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('list/edit', ['uuid' => $list->uuid]) }}" class="btn btn-info btn-xs">{{ __('Edit') }}</a>
                                            <a href="{{ route('list/delete', ['uuid' => $list->uuid]) }}" class="btn btn-danger btn-xs">{{ __('Delete') }}</a>
                                        </div>
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