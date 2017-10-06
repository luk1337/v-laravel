@extends('layouts.app', ['title' => 'Deleting list 〜 ' . $list->name])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 style="margin-top: 0">Deleting list 〜 {{ $list->name }}</h2>

            <form class="form-horizontal" method="post">
                {{ csrf_field() }}

                <div class="form-group">
                    <div class="col-sm-12">
                        Are you sure you want to delete this list?
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-warning">Yes</button>
                        <a href="{{ url()->previous() }}" class="btn btn-default">No</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection