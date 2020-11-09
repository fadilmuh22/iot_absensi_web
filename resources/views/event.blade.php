@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="events-wrapper">
        <p>Events</p>

        <div class="events-container">
            @foreach ($todayEvents as $event)
            <div class="row event-item" onclick="window.location.href = '/event/{{$event->event_id}}';">
                <div class="col-md-12">
                    <div class="column">
                        <div class="row justify-content-between">
                            <div class="col">
                                <p class="nama">{{$event->nama}}</p>
                            </div>
                            <div class="mr-3">
                                <a href="" class="btn btn-primary">Register</a>
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
</div>
@stop