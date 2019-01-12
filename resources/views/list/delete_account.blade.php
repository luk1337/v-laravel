@extends('layouts.app', ['title' => 'Deleting account from the list 〜 ' . $list->name])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-3">Deleting account from list 〜 {{ $list->name }}</h2>

            <form class="form-horizontal" method="post">
                {{ csrf_field() }}

                <div class="form-group">
                    <div class="col-sm-12">
                        Are you sure you want to delete {{ $account->name }} from the list?
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-danger">Yes</button>
                        <a href="{{ url()->previous() }}" class="btn btn-dark">No</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection