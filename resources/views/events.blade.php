@extends('layouts.app')

@section('content')
<div class="container-fluid px-5">
    <div class="events-wrapper">
        <h3>Events</h3>

        <div class="events-container">
            @foreach ($events as $event)
            <div class="row event-item" onclick="window.location.href = '/event/{{$event->event_id}}';">
                <div class="col-md-12">
                    <div class="column">
                        <div class="row justify-content-between">
                            <div class="col">
                                <p class="nama">{{$event->nama}}</p>
                            </div>
                            <div class="mr-3">
                                @if ($event->absen_user_id == null)
                                <a href="{{ url('create-token/'.$event->event_id) }}"
                                    class="btn btn-primary">Register</a>
                                @else
                                <a href="{{ url('resend-token/'.$event->event_id) }}" class="btn btn-success">Resend</a>
                                @endif
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <p class="tempat">{{$event->tempat}}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="tempat text-end">{{$event->tanggal}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{ $events->appends(request()->except('page'))->links("pagination::bootstrap-4") }}
</div>
@stop