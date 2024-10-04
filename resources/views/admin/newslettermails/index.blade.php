@extends('admin.layouts.main')
@section('title', 'NewsletterMails List')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/css/dataTables.bootstrap5.min.css') }}">
@stop
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">NewsletterMails /</span> All NewsletterMails</h4>

    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="d-flex justify-content-between">
                    <h5 class="card-header">All NewsletterMails</h5>
                    <div class="card-header d-flex align-items-center">
                        <a href="{{ route('admin.newslettermails.create') }}" class="btn btn-primary add-btn">Create
                            NewsletterMail</a>
                    </div>
                </div>
                <div class="table-responsive text-nowrap p-3">
                    <table class="table table-hover " id="datatable">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Content</th>
                                <th class="text-center">Created At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/dataTables.bootstrap5.min.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            order: [0, 'DESC'],
            pageLength: 10,
            searching: true,
            ajax: "{{ route('admin.newslettermails.index') }}",
            columns: [{
                    data: 'id',
                    className: "text-center",
                },
                {
                    data: 'content'
                },
                {
                    data: 'created_at',
                    className: "text-center",
                },
                {
                    data: 'actions',
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }
            ]
        });

    });
</script>
@stop
