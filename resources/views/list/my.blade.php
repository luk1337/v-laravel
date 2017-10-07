@extends('layouts.app', ['title' => 'My lists'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-title">My lists</h2>

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
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td><a href="{{ route('list/show', ['uuid' => $list->uuid]) }}">{{ $list->name }}</a></td>
                                <td>{{ App\UserList::$listPrivacyTypes[$list->privacy] }}</td>
                                <td>{{ $list->accounts->count() }}</td>
                                <td>{{ Carbon\Carbon::parse($list->created_at)->format('Y-m-d') }}</td>
                                <td>
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