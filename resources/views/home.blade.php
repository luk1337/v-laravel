@extends('layouts.app', ['title' => 'Home'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-3">Home</h2>

            <p>Welcome to V.</p>

            <p>By creating an account here you'll be able to:</p>
            <ul>
                <li>Add suspicious players to your list(s).</li>
                <li>Subscribe to public / unlisted list(s).</li>
                <li>Get notified whenever somebody gets banned.</li>
            </ul>

            <p>As an unregistered user you'll be able to:</p>
            <ul>
                <li>View public / unlisted lists.</li>
                <li>View list of latest bans.</li>
            </ul>
        </div>
    </div>
</div>
@endsection