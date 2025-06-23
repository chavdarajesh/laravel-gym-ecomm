@extends('admin.layouts.main')
@section('title', 'View Return Request')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Return Request Details</h4>

        <div class="card mb-4">
            <h5 class="card-header">General Details</h5>
            <div class="card-body">
                <input type="hidden" name="id" value="{{ $return->id }}">

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">User</label>
                        <a target="_blank" class="form-control" href="{{ route('admin.users.view', ['id' => $return->user_id]) }}">
                            {{ $return->user->name ?? '-' }}
                        </a>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Order ID</label>
                        <a target="_blank" class="form-control" href="{{ route('admin.orders.view', ['id' => $return->order_id]) }}">
                            {{ $return->order_id ?? '-' }}
                        </a>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Reference ID</label>
                        <input class="form-control" type="text" value="{{ $return->reference_id }}" disabled />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Return Date & Time</label>
                        <input class="form-control" type="text" value="{{ $return->return_date_time }}" disabled />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Verified</label>
                        <input class="form-control" type="text" value="{{ $return->is_verified ? 'Yes' : 'No' }}"
                            disabled />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Request Status</label>
                        <input class="form-control" type="text" value="{{ ucfirst($return->request_status) }}"
                            disabled />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Subtotal</label>
                        <input class="form-control" type="text" value="${{ number_format($return->sub_total, 2) }}"
                            disabled />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Shipping Charge</label>
                        <input class="form-control" type="text"
                            value="${{ number_format($return->shipping_charge, 2) }}" disabled />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Total Order</label>
                        <input class="form-control" type="text" value="${{ number_format($return->total_order, 2) }}"
                            disabled />
                    </div>

                    <div class="mb-3 col-md-12">
                        <label class="form-label">Return Reason</label>
                        <textarea class="form-control" rows="3" disabled>{{ $return->return_reason }}</textarea>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label class="form-label">Return Address</label>
                        <textarea class="form-control" rows="3" disabled>{{ $return->return_address }}</textarea>
                    </div>

                    @if ($return->photo_proof)
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Photo Proof</label><br>
                            <a href="{{ asset($return->photo_proof) }}" target="_blank" class="btn btn-primary btn-sm">View
                                Photo</a>
                        </div>
                    @endif
                    <div class="mb-3 col-md-6">
                        @if (
                            !$return->is_verified &&
                                $return->request_status == 'pending' &&
                                $return->order->payment_status == 'completed' &&
                                $return->order->payment_status != 'cancelled' &&
                                $return->order->order_status == 'delivered' &&
                                $return->order->order_status != 'cancelled' &&
                                $return->order->return_status == 'requested')
                            <button class="btn btn-primary btn-sm" onclick="openReturnStatusModal('{{ $return->id }}')">
                                Change Status
                            </button>
                            @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">Bank Details</h5>
            <div class="card-body">
                <div class="row">
                    @php
                        $bankFields = [
                            'Bank Account Name' => $return->bank_account_name,
                            'BSB Number' => $return->bsb_number,
                            'Account No' => $return->account_no,
                            'Account Holder Name' => $return->account_holder_name,
                        ];
                    @endphp

                    @foreach ($bankFields as $label => $value)
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $label }}</label>
                            <input class="form-control" type="text" value="{{ $value }}" disabled />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">Returned Products</h5>
            <div class="card-body">
                @if ($return->products->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Size</th>
                                    <th>Flavor</th>
                                    <th>Total</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($return->products as $rp)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($rp->product)
                                                <a href="{{ route('admin.products.view', $rp->product_id) }}"
                                                    target="_blank">
                                                    {{ $rp->product->name }}
                                                </a>
                                                @if ($rp->product->sku)
                                                    <br><small class="text-muted">SKU:
                                                        {{ $rp->product->sku }}</small>
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $rp->quantity }}</td>
                                        <td>
                                            ${{ $rp->price ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $rp->size->name ?? ($rp->size_id ? 'ID: ' . $rp->size_id : 'N/A') }}
                                        </td>
                                        <td>
                                            {{ $rp->flavor->name ?? ($rp->flavor_id ? 'ID: ' . $rp->flavor_id : 'N/A') }}
                                        </td>
                                        <td>
                                            ${{ $rp->total_price ?? 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No returned products.</p>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('admin.return_requests.index') }}">
                <button type="button" class="btn btn-secondary me-2">Back</button>
            </a>
        </div>
    </div>

   <!-- Return Request Status Modal -->
        <div class="modal fade" id="returnStatusModal" tabindex="-1" aria-labelledby="returnStatusModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="returnStatusForm" method="POST"
                    action="{{ route('admin.orders.return-requests.update.status') }}">
                    @csrf
                    <input type="hidden" name="return_request_id" id="modal_return_request_id">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Return Request Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="return_status" class="form-label">Return Status <span
                                        class="text-danger">*</span></label>
                                <select name="return_status" id="return_status" class="form-select" required>
                                    <option value="">Select Status</option>
                                    <option value="approved">Approve</option>
                                    <option value="rejected">Reject</option>
                                </select>
                                <div id="return_status_error" class="text-danger"></div>
                            </div>
                            <div class="form-group mb-3 d-none" id="return_reject_reason_group">
                                <label for="return_reject_reason" class="form-label">Rejection Reason</label>
                                <textarea name="return_reject_reason" id="return_reject_reason" rows="3" class="form-control"></textarea>
                                <div id="return_reject_reason_error" class="text-danger"></div>
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
        $('#return_status').on('change', function() {
            if ($(this).val() === 'rejected') {
                $('#return_reject_reason_group').removeClass('d-none');
            } else {
                $('#return_reject_reason_group').addClass('d-none');
                $('#return_reject_reason').val('');
            }
        });


        // To open modal and set request id
        function openReturnStatusModal(returnRequestId) {
            $('#modal_return_request_id').val(returnRequestId);
            $('#return_status').val('');
            $('#return_reject_reason').val('');
            $('#return_reject_reason_group').addClass('d-none');
            $('#returnStatusModal').modal('show');
        }

        // jQuery Validate
        $('#returnStatusForm').validate({
            rules: {
                return_status: {
                    required: true
                },
                return_reject_reason: {
                    required: function(element) {
                        return $('#return_status').val() === 'rejected';
                    },
                    maxlength: 255
                }
            },
            messages: {
                return_status: {
                    required: "Please select a status."
                },
                return_reject_reason: {
                    required: "Please enter a rejection reason.",
                    maxlength: "Rejection reason cannot be more than 255 characters."
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
                form.submit();
            }
        });

    </script>
    @error('return_status')
        <script>
            $(document).ready(function() {
                $('#returnStatusModal').modal('show');
            });
        </script>
    @enderror
    @error('return_reject_reason')
        <script>
            $(document).ready(function() {
                $('#returnStatusModal').modal('show');
            });
        </script>
    @enderror
@stop
