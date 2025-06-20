@extends('admin.layouts.main')
@section('title', 'View Payment Upload')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Payment Upload /</span> View Payment Upload</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Payment Upload Details</h5>
                    <hr class="my-0" />
                    <div class="card-body">
                        <input type="hidden" name="id" value="{{ $payment->id }}">

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">User</label>
                                <a target="_blank" class="form-control"
                                    href="{{ route('admin.users.view', ['id' => $payment->user->id]) }}">{{ $payment->user->name ?? '-' }}</a>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Order ID</label>
                                <a target="_blank" class="form-control"
                                    href="{{ route('admin.orders.view', ['id' => $payment->order_id]) }}">{{ $payment->order_id ?? '-' }}</a>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Reference ID</label>
                                <input class="form-control" type="text" value="{{ $payment->reference_id }}" disabled />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Payment Date & Time</label>
                                <input class="form-control" type="text" value="{{ $payment->payment_date_time }}"
                                    disabled />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Payment Method</label>
                                <input class="form-control" type="text" value="{{ ucfirst($payment->payment_method) }}"
                                    disabled />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Is Verified</label>
                                <input class="form-control" type="text"
                                    value="{{ $payment->is_verified ? 'Yes' : 'No' }}" disabled />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Request Status</label>
                                <input class="form-control" type="text" value="{{ ucfirst($payment->request_status) }}"
                                    disabled />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Subtotal</label>
                                <input class="form-control" type="text"
                                    value="${{ number_format($payment->sub_total, 2) }}" disabled />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Shipping Charge</label>
                                <input class="form-control" type="text"
                                    value="${{ number_format($payment->shipping_charge, 2) }}" disabled />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Total Order</label>
                                <input class="form-control" type="text"
                                    value="${{ number_format($payment->total_order, 2) }}" disabled />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Attachment</label><br>
                                @if ($payment->attachment_path)
                                    <a href="{{ asset($payment->attachment_path) }}" target="_blank"
                                        class="btn btn-primary btn-sm">View Attachment</a>
                                @else
                                    <span class="text-muted">No attachment uploaded.</span>
                                @endif
                            </div>
                            <div class="mb-3 col-md-6">
                                @if (
                                    $payment->request_status == 'pending' &&
                                        ($payment->order->payment_status != 'completed' && $payment->order->payment_status != 'cancelled') &&
                                        ($payment->order->order_status != 'delivered' && $payment->order->order_status != 'cancelled'))
                                    <button type="button" class="btn btn-sm btn-outline-primary open-payment-status-modal"
                                        data-order-id="{{ $payment->order->id }}" data-payment-id="{{ $payment->id }}"
                                        data-current-status="{{ $payment->request_status }}">
                                        Update Status
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('admin.payment_uploads.index') }}">
                                <button type="button" class="btn btn-secondary me-2">Back</button>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="payment-status-modal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="statusForm" method="POST" action="{{ route('admin.orders.payment.update.status') }}">
                @csrf
                <input type="hidden" name="order_id" id="modal_order_id">
                <input type="hidden" name="payment_upload_id" id="modal_payment_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Payment Request Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="payment_status" class="form-label">Payment Status <span
                                    class="text-danger">*</span></label>
                            <select name="payment_status" id="payment_status" class="form-select">
                                <option value="">Select Status</option>
                                <option value="approved">Approve</option>
                                <option value="rejected">Reject</option>
                            </select>
                            <div id="payment_status_error" class="text-danger"></div>
                        </div>
                        <div class="form-group mb-3 d-none" id="reject_reason_group">
                            <label for="reject_reason" class="form-label">Rejection Reason </label>
                            <textarea name="reject_reason" id="reject_reason" rows="3" class="form-control"></textarea>
                            <div id="reject_reason_error" class="text-danger"></div>
                        </div>

                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop


@section('js')
    <script src="{{ asset('assets/admin/js/jquery.validate.min.js') }}"></script>

    <script>
        $('.open-payment-status-modal').click(function() {
            let orderId = $(this).data('order-id');
            let paymentId = $(this).data('payment-id');
            let currentStatus = $(this).data('current-status');

            $('#modal_order_id').val(orderId);
            $('#modal_payment_id').val(paymentId);
            $('#payment_status').val(currentStatus);

            $('#payment-status-modal').modal('show');
            $('#payment-status-modal').on('shown.bs.modal', function() {
                $('#payment_status').trigger('change');
            });

        });

        // Show/hide rejection reason
        $('#payment_status').on('change', function() {
            if ($(this).val() === 'rejected') {
                $('#reject_reason_group').removeClass('d-none');
            } else {
                $('#reject_reason_group').addClass('d-none');
                $('#reject_reason').val('');
            }
        });

        // jQuery Validate
        $('#statusForm').validate({
            rules: {
                payment_status: {
                    required: true
                }
            },
            errorPlacement: function(error, element) {
                error.addClass('text-danger');
                $('#' + element.attr('name') + '_error').html(error);
            },
            highlight: function(element) {
                $(element).addClass('border border-danger');
            },
            unhighlight: function(element) {
                $(element).removeClass('border border-danger');
            },
            submitHandler: function(form) {
                form.submit(); // or use AJAX
            }
        });
    </script>


    @error('payment_status')
        <script>
            $(document).ready(function() {
                $('#payment-status-modal').modal('show');
            });
        </script>
    @enderror
    @error('reject_reason')
        <script>
            $(document).ready(function() {
                $('#payment-status-modal').modal('show');
            });
        </script>
    @enderror
@stop
