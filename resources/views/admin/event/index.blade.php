@extends('adminlte::page')

@section('title', 'Events')

@section('content_header')
<div class="container-fluid">
    <div class="row justify-content-between">
        <h1>Events</h1>
        <a class="btn btn-primary" href="{{ url('admin/event/create')}}">Create</a>
    </div>
</div>
@stop

@section('content')
<table class="table table-bordered table-striped" id="blogs-table" style="width: 100%;">
    <thead>
        <tr>
            <th style="width: 5%;">Id</th>
            <th style="width: 30;">Nama</th>
            <th style="width: 45%">Deskripsi</th>
            <th style="width: 20%;">Tempat</th>
            <th style="width: 20%;">Tanggal</th>
            <th style="width: 5%;">Durasi</th>
            <th style="width: 20%;">Action</th>
        </tr>
    </thead>
</table>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Hapus Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Hapus Event
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
            ajax: "{{ url('admin/event/json') }}",
            columns: [
                { data: 'event_id', name: 'event_id' },
                {
                    data: 'nama',
                    name: 'nama',
                    render: function(data, type, row) {
                        return type === 'display' && data.length > 30 ? data.substr(0, 30) + '...' : data;
                    }
                },
                {
                    data: 'deskripsi',
                    name: 'deskripsi',
                    render: function(data, type, row) {
                        return type === 'display' && data.length > 60 ? stripHtml(data.substr(0, 60)) + '...' : stripHtml(data);
                    }
                },
                {
                    data: 'tempat',
                    name: 'tempat',
                },
                {
                    data: 'tanggal',
                    name: 'tanggal',
                },

                { data: 'durasi', name: 'durasi' },
                {
                    data: null,
                    name: 'action',
                    render: function(data) {
                        var edit_btn = '<a href="' + data.edit_url + '" class="btn btn-primary mr-2 mb-1" role="button" aria-pressed="true">Edit</a>';
                        var delete_btn = '<button class="btn btn-delete btn-danger mb-1" data-event-id="'+data.event_id+'" data-event-nama="'+data.nama+'" data-remote="'+ data.delete_url +'" data-toggle="modal" data-target="#deleteModal">Delete</button>';
                        return '<div class="form-inline">' + edit_btn + delete_btn + '</div>';
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
            const wording = " " + $(e.relatedTarget).data('event-nama') + " dengan id: " +$(e.relatedTarget).data('event-id');
            console.log(" " + $(e.relatedTarget).data('event-nama') + "dengan id: " +$(e.relatedTarget).data('event-id'));

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