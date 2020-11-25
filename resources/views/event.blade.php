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
                <div class="form-inline">
                    <a href="{{ url('resend-token/'.$event->event_id) }}" class="btn btn-success mr-1">Resend</a>

                    <form action="{{ url('/event/delete/'.$event->absen_id) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <input type="hidden" name="user_id" value="{{$event->absen_user_id }}">
                        <div class="form-group">
                            <input type="submit" class="btn btn-info" value="Unregister">
                        </div>
                    </form>
                </div>
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