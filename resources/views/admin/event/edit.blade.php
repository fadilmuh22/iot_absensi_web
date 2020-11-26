@extends('adminlte::page')

@section('title', 'Create Event')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Event</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ url('/admin/event') }}">
                        Event
                    </a>
                </li>
                <li class="breadcrumb-item active">Edit Event</li>
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
    <form action="{{ url('admin/event/update/'.$event->event_id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <input required type="text" name="nama" class="form-control" value="{{ $event->nama }}">
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <textarea name="deskripsi" class="form-control my-editor mx-auto" style="min-height: 512px">
                        {{ $event->deskripsi }}
                    </textarea>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <input required type="text" name="tempat" class="form-control" value="{{ $event->tempat }}">
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <div class='input-group date'>
                        <input required id='tanggalDateTime' type='text' name="tanggal" class="form-control"
                            value="{{ $event->tanggal }}" />
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <span class="fa fa-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <input required type="number" name="durasi" class="form-control" value="{{ $event->durasi }}">
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

@section('js')
<script>
    $(function () {
        $.datetimepicker.setLocale('id');
        $('#tanggalDateTime').datetimepicker({
            format: 'Y-m-d H:i:s',
        });

        const editor_config = {
            path_absolute: "/",
            selector: "textarea.my-editor",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar:
                "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls : false,
            remove_script_host : false,
        };
        tinymce.init(editor_config);
    });
</script>
@stop