@extends('layouts.app', ['title' => __('Change password')])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>{{ __('API key') }}</h2>

            <div class="row justify-content-center align-items-center">
                <div class="col col-md-6 col-xl-4">
                    <div class="form-group mb-2">
                        <label for="api-key" class="col-form-label">{{ __('Your API key') }}</label>
                        <input id="api-key" class="form-control" value="{{ $api_key }}" readonly>
                    </div>

                    @if ($api_key != null)
                        <form class="form float-left mr-2" method="POST" action="{{ route('api-key/reset') }}">
                            @csrf

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-danger">
                                    Reset
                                </button>
                            </div>
                        </form>
                    @endif

                    <form class="form-inline float-left" method="POST" action="{{ route('api-key/regen') }}">
                        @csrf
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                @if ($api_key != null)
                                    Regenerate
                                @else
                                    Generate
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
