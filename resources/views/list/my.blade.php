@extends('layouts.app', ['title' => 'My lists'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-3">My lists</h2>

            @if ($lists->isEmpty())
                <b>Sowwy, it looks like you don't have any lists</b>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Privacy</th>
                            <th>Users</th>
                            <th>Creation date</th>
                            <th>Actions</th>
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
                                    <a href="{{ route('list/edit', ['uuid' => $list->uuid]) }}" class="btn btn-info btn-xs">Edit</a>
                                    <a href="{{ route('list/delete', ['uuid' => $list->uuid]) }}" class="btn btn-danger btn-xs">Delete</a>
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