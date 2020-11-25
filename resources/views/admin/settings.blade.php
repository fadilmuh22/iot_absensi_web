@extends('adminlte::page')

@section('title', 'Create Event')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Reset Password</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ url('/admin') }}">
                        Manage
                    </a>
                </li>
                <li class="breadcrumb-item active">Reset Password</li>
            </ol>
        </div>
    </div>
</div>
@stop

@section('content')
@if (count($errors) > 0)
<div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="container-fluid">
    <form action="{{ url('admin/reset-password') }}" method="post">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <input required type="text" name="password" class="form-control" placeholder="Reset Password"
                        value="{{ old('password') }}">
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-info" value="Simpan">
        </div>
    </form>
</div>
@stop