@extends('layouts.app')

@section('content')
<div class="container-fluid px-5">
    <div class="events-wrapper">
        <h1>{{$event->nama}}</h1>
        <div class="row justify-content-between">
            <div class="col">
                <p class="nama">{{$event->tanggal}}</p>
            </div>
            <div class="mr-3">
                @if ($event->absen_user_id == null)
                <a href="{{ url('create-token/'.$event->event_id) }}" class="btn btn-primary">Register</a>
                @else
                <a href="{{ url('resend-token/'.$event->event_id) }}" class="btn btn-success">Resend</a>
                @endif
            </div>
        </div>

        <hr>

        <div class="event-deskripsi mt-3">
            {!! $event->deskripsi !!}
        </div>

    </div>
</div>
@stop