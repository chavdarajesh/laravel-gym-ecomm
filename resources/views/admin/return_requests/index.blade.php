@extends('admin.layouts.main')
@section('title', 'Return Requests')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/dataTables.bootstrap5.min.css') }}">
@stop

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"> Return Requests </h4>
    <div class="card">
        <h5 class="card-header">All Return Requests</h5>
        <div class="table-responsive p-3">
            <table class="table table-hover" id="datatable">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">User</th>
                        <th class="text-center">Order</th>
                        <th class="text-center">Reference ID</th>
                        <th class="text-center">Return Date</th>
                        <th class="text-center">Verified</th>
                        <th class="text-center">Request Status</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/dataTables.bootstrap5.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            order: [0, 'desc'],
            ajax: "{{ route('admin.return_requests.index') }}",
            columns: [
                { data: 'id', className: 'text-center' },
                { data: 'user_id', className: 'text-center' },
                { data: 'order_id', className: 'text-center' },
                { data: 'reference_id', className: 'text-center' },
                { data: 'return_date_time', className: 'text-center' },
                { data: 'is_verified', className: 'text-center' },
                { data: 'request_status', className: 'text-center' },
                { data: 'total_order', className: 'text-center' },
                { data: 'actions', className: 'text-center', orderable: false, searchable: false }
            ]
        });
    });
</script>
@stop
