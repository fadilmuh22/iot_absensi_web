@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    @if (empty(Auth::user()->event_token))
                    <a href="/create-token/{{ rand(1, 5) }}" class="btn btn-primary">Create Event Token</a>
                    @else
                    <a href="/resend-token/{{ rand(1, 5) }}" class="btn btn-success">Resend Event Token</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection