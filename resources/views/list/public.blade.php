@extends('layouts.app', ['title' => 'Public lists'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Public lists</h2>

                @if ($lists->isEmpty())
                    <b>Sowwy, it looks like there are no public lists.</b>
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
                                @auth
                                    <th>Actions</th>
                                @endauth
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
                                        @if (Auth::Check() && $list->user_id != Auth::User()->id)
                                            @if (!Auth::User()->subscriptions()->get()->contains('user_list_id', $list->id))
                                                <a href="{{ route('list/subscribe', ['uuid' => $list->uuid]) }}" class="btn btn-xs btn-success">Subscribe</a>
                                            @else
                                                <a href="{{ route('list/unsubscribe', ['uuid' => $list->uuid]) }}" class="btn btn-xs btn-danger">Unsubscribe</a>
                                            @endif
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