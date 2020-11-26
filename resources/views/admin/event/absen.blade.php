@extends('adminlte::page')

@section('title', 'Events')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{$event->nama}}</h1>
            <p class="nama">{{$event->tanggal}}</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ url('/admin/event') }}">
                        Event
                    </a>
                </li>
                <li class="breadcrumb-item active">Absen Event</li>
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
<table class="table table-bordered table-striped" id="blogs-table" style="width: 100%;">
    <thead>
        <tr>
            <th style="width: 5%;">Id</th>
            <th style="width: 45%">Nama User</th>
            <th style="width: 20%;">Email User</th>
            <th style="width: 5%;">Hadir</th>
            <th style="width: 20%;">Waktu Hadir</th>
            <th style="width: 20%;">Action</th>
        </tr>
    </thead>
</table>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Hapus Absen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Hapus Absen
                <span style="font-weight: bolder !important; color: red;" id="wording-modal-delete"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger delete-modal-btn" data-dismiss="modal">Delete</button>
            </div>
        </div>
    </div>
</div>
@stop


@section('js')
<script>
    function stripHtml(html) {
        const tmp = document.createElement("DIV");
        tmp.innerHTML = html;
        return tmp.textContent || tmp.innerText || "";
    }
    $(function() {
        $('#blogs-table').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            responsive: true,
            ajax: "{{ url('admin/event/absen-json/'.$event->event_id) }}",
            columns: [
                { data: 'absen_id', name: 'absen_id' },
                {
                    data: 'name',
                    name: 'name',
                    render: function(data, type, row) {
                        return type === 'display' && data.length > 30 ? data.substr(0, 30) + '...' : data;
                    }
                },
                {
                    data: 'email',
                    name: 'email',
                    render: function(data, type, row) {
                        return type === 'display' && data.length > 60 ? stripHtml(data.substr(0, 60)) + '...' : stripHtml(data);
                    }
                },
                {
                    data: 'hadir',
                    name: 'hadir',
                },
                {
                    data: 'waktu_hadir',
                    name: 'waktu_hadir',
                },
                {
                    data: null,
                    name: 'action',
                    render: function(data) {
                        var deleteBtn = '<button class="btn btn-delete btn-danger mb-1" data-absen-id="'+data.absen_id+'" data-absen-nama="'+data.name+'" data-remote="'+ data.delete_url +'" data-toggle="modal" data-target="#deleteModal">Delete</button>';
                        return '<div class="form-inline">' + deleteBtn + '</div>';
                    },
                    orderable: false,
                    searchable: false
                }
            ],
            "language": {
                "emptyTable": "Blog tidak tersedia"
            }
        });

        $('#deleteModal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            const wording = " " + $(e.relatedTarget).data('absen-nama') + " dengan id: " +$(e.relatedTarget).data('absen-id');
            console.log(" " + $(e.relatedTarget).data('absen-nama') + "dengan id: " +$(e.relatedTarget).data('absen-id'));

            //populate the textbox
            $(e.currentTarget).find('#wording-modal-delete').html(wording);
        });

        $('#blogs-table').DataTable().on('click', '.btn-delete[data-remote]' ,function (e) {
            e.preventDefault();
            var url = $(this).data('remote');
            console.log(url);
            $('.delete-modal-btn').on('click',function (e) {
                e.preventDefault();
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {
                        method: '_DELETE'
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).always(function (data) {
                    $('#blogs-table').DataTable().draw(false);
                });
            });
        });
    });
</script>
@stop