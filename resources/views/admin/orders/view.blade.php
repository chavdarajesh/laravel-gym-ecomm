@extends('admin.layouts.main')
@section('title', 'View Order')
@php
    use App\Models\Size;
    use App\Models\Flavor;
@endphp
@section('css')
    <style>
        .timeline {
            position: relative;
        }

        .timeline .list-group-item {
            position: relative;
            border: none;
            padding-left: 40px;
            background: transparent;
        }

        .timeline .list-group-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 28px;
            top: 30px;
            width: 2px;
            height: calc(100% - 30px);
            background: #0d6efd;
            z-index: 0;
        }

        .timeline .badge {
            z-index: 1;
        }
    </style>
@stop
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Orders /</span> View Order / {{ $Order->id }}
        </h4>

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-header">Order View</h5>
                        </div>
                        <div class="mx-2">
                            Current : @php
                                $latestStatus = $Order->latestStatus()->first();
                                if ($latestStatus) {
                                    $statusName = $latestStatus->name;
                                    echo $statusName; // Output the latest status name
                                } else {
                                    echo 'No status available';
                                }
                            @endphp
                            @if ($Order->order_status != 'delivered' && $Order->order_status != 'cancelled')
                                <button type="button" class="btn  btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#update-order-status-modal-{{ $Order->id }}">
                                    Update Status
                                </button>
                            @endif
                            @if ($Order->order_status == 'delivered' && $Order->payment_status == 'completed' && $Order->return_status == 'approved')
                                <button type="button" class="btn  btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#refund-status-modal-{{ $Order->id }}">
                                    Mark as Refunded
                                </button>
                            @endif

                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <input type="hidden" name="id" value="{{ $Order->id }}">

                        <div class="row">
                            <!-- Order Details -->
                            <div class="mb-3 col-md-12">
                                <label for="user-details" class="form-label">User Details</label>
                                <a href="{{ route('admin.users.view', $Order->user_id) }}" class="form-control"
                                    id="user-details">{{ $Order->user->name ?? 'N/A' }}</a>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="order-id" class="form-label">Order ID</label>
                                <input class="form-control" type="text" id="order-id" name="order_id"
                                    value="{{ $Order->id ?? '' }}" disabled />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="total-order" class="form-label">Total Order</label>
                                <input class="form-control" type="text" id="total-order" name="total_order"
                                    value="${{ $Order->total_order ?? '' }}" disabled />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="sub-total" class="form-label">Sub Total</label>
                                <input class="form-control" type="text" id="sub-total" name="sub_total"
                                    value="${{ $Order->sub_total ?? '' }}" disabled />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="shipping-charge" class="form-label">Shipping Charge</label>
                                <input class="form-control" type="text" id="shipping-charge" name="shipping_charge"
                                    value="${{ $Order->shipping_charge ?? '' }}" disabled />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="payment-type" class="form-label">Payment Type</label>
                                <input class="form-control" type="text" id="payment-type" name="payment_type"
                                    value="{{ $Order->payment_type ?? '' }}" disabled />
                            </div>

                            <!-- Order Address -->
                            <div class="mb-3 col-md-12">
                                <label for="address-line-1" class="form-label">Address Line 1</label>
                                <input class="form-control" type="text" id="address-line-1" name="address_line_1"
                                    value="{{ $Order->address->address_line_1 ?? '' }}" disabled />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="address-line-2" class="form-label">Address Line 2</label>
                                <input class="form-control" type="text" id="address-line-2" name="address_line_2"
                                    value="{{ $Order->address->address_line_2 ?? '' }}" disabled />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="city" class="form-label">City</label>
                                <input class="form-control" type="text" id="city" name="city"
                                    value="{{ $Order->address->city ?? '' }}" disabled />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="state" class="form-label">State</label>
                                <input class="form-control" type="text" id="state" name="state"
                                    value="{{ $Order->address->state ?? '' }}" disabled />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="postal-code" class="form-label">Postal Code</label>
                                <input class="form-control" type="text" id="postal-code" name="postal_code"
                                    value="{{ $Order->address->postal_code ?? '' }}" disabled />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="country" class="form-label">Country</label>
                                <input class="form-control" type="text" id="country" name="country"
                                    value="{{ $Order->address->country ?? '' }}" disabled />
                            </div>
                            <hr>
                            <!-- Order Products -->
                            <div class="col-md-12 mb-4">
                                <label for="products" class="form-label">Products</label>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Size</th>
                                            <th>Flavor</th>
                                            <th>Price</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Order->products ?? [] as $product)
                                            <tr>
                                                <td> <a
                                                        href="{{ route('admin.products.view', $product->id) }}">{{ $product->name ?? 'N/A' }}</a>
                                                </td>
                                                <td>{{ $product->pivot->quantity ?? 'N/A' }}</td>
                                                <td>{{ Size::get_size_by_id($product->pivot->size_id)->name ? Size::get_size_by_id($product->pivot->size_id)->name : 'N/A' }}
                                                </td>
                                                <td>{{ Flavor::get_flavor_by_id($product->pivot->flavor_id)->name ? Flavor::get_flavor_by_id($product->pivot->flavor_id)->name : 'N/A' }}
                                                </td>
                                                <td>${{ $product->pivot->price ?? 'N/A' }}</td>
                                                <td>${{ $product->pivot->total_price ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr>

                            <div class="col-md-12 mb-4">
                                <label for="payment_details" class="form-label">Payment Details</label>
                                @if ($Order->paymentUploads->count())
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Reference ID</th>
                                                <th>Payment Date & Time</th>
                                                <th>Attachment</th>
                                                <th>Payment Method</th>
                                                <th>Verification Status</th>
                                                <th>Request Status</th>
                                                <th>Total Order</th>
                                                <th>Uploaded At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($Order->paymentUploads ?? [] as $payment)
                                                <tr>
                                                    <td>{{ $payment->reference_id ?? 'N/A' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date_time)->format('d M Y h:i A') ?? 'N/A' }}
                                                    </td>
                                                    <td>
                                                        @if ($payment->attachment_path)
                                                            <a href="{{ asset($payment->attachment_path) }}"
                                                                target="_blank">View</a>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) ?? 'N/A' }}
                                                    </td>
                                                    <td>
                                                        @if ($payment->is_verified)
                                                            <span class="badge bg-success">Verified</span>
                                                        @else
                                                            <span class="badge bg-warning text-dark">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span
                                                                class="badge bg-secondary text-capitalize">{{ $payment->request_status }}</span>
                                                            @if (
                                                                $payment->request_status == 'pending' &&
                                                                    ($payment->order->payment_status != 'completed' && $payment->order->payment_status != 'cancelled') &&
                                                                    ($payment->order->order_status != 'delivered' && $payment->order->order_status != 'cancelled'))
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-primary open-payment-status-modal"
                                                                    data-order-id="{{ $Order->id }}"
                                                                    data-payment-id="{{ $payment->id }}"
                                                                    data-current-status="{{ $payment->request_status }}">
                                                                    Update Status
                                                                </button>
                                                            @endif
                                                        </div>

                                                    </td>
                                                    <td>${{ number_format($payment->total_order, 2) }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y, h:i A') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-info">No payment details available for this order.</div>
                                @endif
                            </div>
                            <hr>
                            <div class="col-md-12 mb-4">
                                <label for="returnRequests" class="form-label">Return Requests</label>
                                @if ($Order->returnRequests->count())
                                    @foreach ($Order->returnRequests as $return)
                                        <div class="mb-3">
                                            <div class=" mb-3">
                                                <strong>Request #{{ $return->id }}</strong> | <a
                                                    class="btn btn-sm btn-outline-primary" href="#">View Details</a>
                                                |
                                                Status: <span
                                                    class="badge bg-{{ $return->request_status === 'approved' ? 'success' : ($return->request_status === 'rejected' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($return->request_status) }}
                                                </span>
                                                @if ($return->is_verified)
                                                    <span class="badge bg-info ml-2">Verified</span>
                                                @endif
                                            </div>

                                            <ul class="list-group mb-3">
                                                <li class="list-group-item"><strong>Reference ID:</strong>
                                                    {{ $return->reference_id }}</li>
                                                <li class="list-group-item"><strong>Return Date/Time:</strong>
                                                    {{ $return->return_date_time }}</li>
                                                <li class="list-group-item"><strong>Bank Name:</strong>
                                                    {{ $return->bank_name }}</li>
                                                <li class="list-group-item"><strong>Branch Name:</strong>
                                                    {{ $return->branch_name }}</li>
                                                <li class="list-group-item"><strong>Account Type:</strong>
                                                    {{ ucfirst($return->account_type) }}</li>
                                                <li class="list-group-item"><strong>IFSC Code:</strong>
                                                    {{ $return->ifsc_code }}</li>
                                                <li class="list-group-item"><strong>Bank Account No:</strong>
                                                    {{ $return->bank_account_no }}</li>
                                                <li class="list-group-item"><strong>Account Holder Name:</strong>
                                                    {{ $return->bank_account_holder_name }}</li>
                                                <li class="list-group-item"><strong>Return Reason:</strong>
                                                    {{ $return->return_reason }}</li>
                                                <li class="list-group-item"><strong>Return Address:</strong>
                                                    {{ $return->return_address }}</li>
                                                <li class="list-group-item">
                                                    <strong>Photo Proof:</strong>
                                                    @if ($return->photo_proof)
                                                        <img src="{{ asset($return->photo_proof) }}" alt="Photo Proof"
                                                            class="img-thumbnail" style="max-width: 200px;">
                                                    @else
                                                        <span class="text-danger">Not Provided</span>
                                                    @endif
                                                </li>
                                            </ul>
                                            <h5>Returned Products</h5>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
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
                                            <div><strong>Subtotal:</strong> ${{ $return->sub_total }}</div>
                                            <div><strong>Total:</strong> ${{ $return->total_order }}</div>

                                            <div class="mt-3">
                                                @if (
                                                    !$return->is_verified &&
                                                        $return->request_status === 'pending' &&
                                                        $return->order->payment_status == 'completed' &&
                                                        $return->order->payment_status != 'cancelled' &&
                                                        $return->order->order_status == 'delivered' &&
                                                        $return->order->order_status != 'cancelled' &&
                                                        $return->order->return_status == 'none')
                                                    <button class="btn btn-primary btn-sm"
                                                        onclick="openReturnStatusModal('{{ $return->id }}')">
                                                        Change Status
                                                    </button>
                                                @elseif($return->request_status === 'rejected')
                                                    <span class="text-danger">User can resubmit proof.</span>
                                                @elseif($return->request_status === 'approve')
                                                    <span class="text-success">Return request approved.</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-info">No return requests for this order.</div>
                                @endif
                            </div>
                            <hr>
                            <div class="col-md-12 mb-4">
                                <label for="payment_details" class="form-label">Order Status History</label>
                                <ul class="list-group list-group-flush timeline">
                                    @foreach ($Order->statuses as $status)
                                        <li class="list-group-item d-flex align-items-start">
                                            <!-- Timeline dot -->
                                            <span class="badge bg-primary rounded-pill me-3 mt-1"
                                                style="min-width: 18px; min-height: 18px;"></span>
                                            <div>
                                                <div class="fw-bold">{{ $status->name }} |
                                                    ({{ $status->description }})
                                                </div>
                                                <small class="text-muted">
                                                    {{ $status->pivot->created_at->format('d M Y, h:i A') }}
                                                </small>
                                                <div>{{ $status->pivot->description }}</div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <hr>

                            <div class="mt-2">
                                <a href="{{ route('admin.orders.index') }}"><button type="submit"
                                        class="btn btn-secondary me-2">Back</button></a>
                            </div>

                        </div>
                        <!-- /Account -->
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="update-order-status-modal-{{ $Order->id }}" tabindex="-1"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <form action="{{ route('admin.orders.updateStatus', ['id' => $Order->id]) }}" method="post"
                        id="status-form">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Update Order Status
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select  @error('status') is-invalid @enderror"
                                    aria-label="Default select example" id="status" name="status">
                                    <option selected disabled>Select Status</option>
                                    @foreach ($OrderStatus as $OrderStatu)
                                        <option value="{{ $OrderStatu->id }}">{{ $OrderStatu->name }}</option>
                                    @endforeach
                                </select>
                                <div id="status_error" class="text-danger"> @error('status')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <!-- <input type="hidden" name="mark_as_completed" value="off"> -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="on" id="mark_as_completed"
                                    name="mark_as_completed">
                                <label class="form-check-label" for="mark_as_completed">
                                    Mark as Delivered
                                    <span class="text-muted">(Check this if you want to mark the order as delivered)</span>
                                </label>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control  @error('description') is-invalid @enderror" id="description" name="description"
                                    id="description" rows="3"></textarea>
                                <div id="description_error" class="text-danger"> @error('description')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            @csrf
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="refund-status-modal-{{ $Order->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <form action="{{ route('admin.orders.update.refund.status', ['id' => $Order->id]) }}" method="POST"
                        id="refund-status-form-{{ $Order->id }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Update Refund Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="refund_status" class="form-label">Refund Status</label>
                                <select class="form-select @error('refund_status') is-invalid @enderror"
                                    name="refund_status" id="refund_status">
                                    <option selected disabled>Select Refund Status</option>
                                    @foreach ($ReturnStatus as $OrderStatu)
                                        <option value="{{ $OrderStatu->id }}">{{ $OrderStatu->name }}</option>
                                    @endforeach
                                </select>
                                <div id="refund_status_error" class="text-danger">
                                    @error('refund_status')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="refund_description" class="form-label">Refund Description (optional)</label>
                                <textarea class="form-control @error('refund_description') is-invalid @enderror" name="refund_description"
                                    id="refund_description" rows="3"></textarea>
                                <div class="text-danger">
                                    @error('refund_description')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Mark Refund</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="payment-status-modal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="statusForm" method="POST" action="{{ route('admin.orders.payment.update.status') }}">
                    @csrf
                    <input type="hidden" name="order_id" id="modal_order_id">
                    <input type="hidden" name="payment_upload_id" id="modal_payment_id">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Payment Request Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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
            $(document).ready(function() {
                $('#status-form').validate({
                    rules: {
                        status: {
                            required: true,
                        }
                    },
                    messages: {
                        status: {
                            required: "Please select a status.",
                        },
                    },
                    errorElement: 'div',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        if (element.prop('type') === 'select-one') {
                            element.closest('.form-select').after(error);
                        } else {
                            element.after(error);
                        }
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid').removeClass('is-valid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid').addClass('is-valid');
                    }
                });
            });
        </script>

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


            $('#refund-status-form-{{ $Order->id }}').validate({
                rules: {
                    refund_status: {
                        required: true
                    },
                    refund_description: {
                        maxlength: 1000
                    }
                },
                messages: {
                    refund_status: {
                        required: "Please select a refund status."
                    },
                    refund_description: {
                        maxlength: "Refund description cannot exceed 1000 characters."
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
        @error('status')
            <script>
                $(document).ready(function() {
                    $('#update-order-status-modal-{{ $Order->id }}').modal('show');
                });
            </script>
        @enderror
        @error('description')
            <script>
                $(document).ready(function() {
                    $('#update-order-status-modal-{{ $Order->id }}').modal('show');
                });
            </script>
        @enderror


        @error('refund_status')
            <script>
                $(document).ready(function() {
                    $('#refund-status-modal-{{ $Order->id }}').modal('show');
                });
            </script>
        @enderror
        @error('refund_description')
            <script>
                $(document).ready(function() {
                    $('#refund-status-modal-{{ $Order->id }}').modal('show');
                });
            </script>
        @enderror


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
