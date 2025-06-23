@extends('front.layouts.main')
@section('title', 'Order Details')
@php
    use App\Models\Size;
    use App\Models\Flavor;
@endphp
@section('css')
    <style>
        .card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-bottom: 2px solid #f0f0f0;
        }

        .card-body {
            font-size: 1rem;
        }

        .img-fluid {
            height: 200px;
            object-fit: cover;
            border-bottom: 2px solid #f0f0f0;
        }

        /* Floating Action Button */
        .position-fixed {
            z-index: 1050;
        }

        .list-group-item {
            background-color: #f8f9fa;
            font-size: 1.1rem;
        }

        .badge-warning {
            background-color: #ffcc00;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-info {
            background-color: #17a2b8;
        }


        /* Custom timeline styles */
        .timeline {
            position: relative;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
        }

        .timeline-icon {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .icon-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .timeline-line {
            width: 2px;
            background-color: #dee2e6;
            flex-grow: 1;
            margin-top: 5px;
        }

        td {
            white-space: nowrap;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

@stop

@section('content')
    <!--? Hero Start -->
    <div class="slider-area2">
        <div class="slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap hero-cap2 pt-70">
                            <h2 class="text-white">Order Details</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->
    <!--? Team -->

    <div class="container pt-5 pb-5">
        <h2 class="mb-5 text-center text-warning font-weight-bold">Order Details</h2>

        <!-- Order Info Section -->
        <div class="card shadow-lg mb-4">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">Order Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                        <p><strong>User:</strong> {{ $order->user->name }}</p>
                        <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <p>
                            <strong>Status:</strong>
                            <span class="">
                                @php
                                    if ($latestStatus) {
                                        $statusName = $latestStatus->name;
                                        echo $statusName; // Output the latest status name
                                    } else {
                                        echo 'No status available';
                                    }
                                @endphp
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address Section -->
        <div class="card shadow-lg mb-4">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">Shipping Address</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $order->address->name }}</p>
                <p><strong>Phone:</strong> {{ $order->address->phone }}</p>
                <p><strong>Email:</strong> {{ $order->address->email ?? 'N/A' }}</p>
                <p><strong>Address:</strong></p>
                <p>
                    {{ $order->address->address_line_1 }} <br>
                    {!! $order->address->address_line_2 ? $order->address->address_line_2 . '<br>' : '' !!}
                    {{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->postal_code }}<br>
                    {{ $order->address->country }}
                </p>
            </div>
        </div>


        <!-- Status History Timeline Section -->
        <div class="card shadow-lg mb-4">
             <div class="card-header bg-warning text-white">
                <h5 class="mb-0">Order Status Timeline</h5>
            </div>
            <div class="timeline m-3">
                @foreach ($order->statuses as $status)
                    <div class="timeline-item d-flex flex-column flex-md-row">
                        <div class="timeline-icon flex-shrink-0 me-md-4 mb-2 mb-md-0">
                            <div class="icon-circle {{ $loop->last ? 'bg-success' : 'bg-secondary' }}">
                                <i class="bi {{ $loop->last ? 'bi-check-circle-fill' : 'bi-circle' }}"></i>
                            </div>
                            <div class="timeline-line d-none d-md-block"></div>
                        </div>
                        <div class="card flex-grow-1 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ ucfirst($status->name) }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    {{ $status->pivot->created_at->format('d M Y, h:i A') }}
                                </h6>
                                <p class="card-text">{!! $status->pivot->description ?? '-' !!}</p>
                                <small class="text-muted">({{ $status->description }})</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>



        <!-- Product List Section -->
        <div class="card shadow-lg mb-4">
            <div class="card-header bg-warning">
                <h5 class="mb-0">Products in Order</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($order->products as $product)
                        <div class="col-12 col-md-4 mb-4">
                            <a target="_blank" href="{{ route('front.products-details', $product->id) }}">
                                <div class="card shadow-sm">
                                    <img src="{{ asset($product->cover_image) }}" alt="{{ $product->name }}"
                                        class="card-img-top">
                                    <div class="card-body">
                                        <h6 class="card-title font-weight-bold">{{ $product->name }}</h6>
                                        <p class="text-muted mb-2">Quantity:
                                            <strong>{{ $product->pivot->quantity }}</strong>
                                        </p>
                                        <p class="text-muted mb-2">Price: ${{ number_format($product->pivot->price, 2) }}
                                        </p>
                                        <p class="text-muted mb-2">Size:
                                            {{ Size::get_size_by_id($product->pivot->size_id)->name ? Size::get_size_by_id($product->pivot->size_id)->name : 'N/A' }}
                                        </p>
                                        <p class="text-muted mb-2">Flavor:
                                            {{ Flavor::get_flavor_by_id($product->pivot->flavor_id)->name ? Flavor::get_flavor_by_id($product->pivot->flavor_id)->name : 'N/A' }}
                                        </p>
                                        <p class="font-weight-bold">
                                            <span>Total:</span>
                                            ${{ number_format($product->pivot->quantity * $product->pivot->price, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Summary Section -->
        <div class="card shadow-lg mb-4">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">Order Summary</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Subtotal:</strong> ${{ number_format($order->sub_total, 2) }}
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Shipping Charges:</strong> ${{ number_format($order->shipping_charge, 2) }}
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Total:</strong>
                        <span class="text-success font-weight-bold">${{ number_format($order->total_order, 2) }}</span>
                    </li>
                </ul>
            </div>
        </div>


        <!-- Payment Details Table (Bootstrap 5) -->

        @if (!$order->paymentUploads->isEmpty())
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Payment Details</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Reference ID</th>
                                    <th>Payment Date &amp; Time</th>
                                    <th>Attachment</th>
                                    <th>Payment Method</th>
                                    <th>Verification Status</th>
                                    <th>Request Status</th>
                                    <th>Total Order</th>
                                    <th>Uploaded At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->paymentUploads ?? [] as $payment)
                                    <tr>
                                        <td>{{ $payment->reference_id ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($payment->payment_date_time)->format('d M Y h:i A') ?? 'N/A' }}
                                        </td>
                                        <td>
                                            @if ($payment->attachment_path)
                                                <a href="{{ asset($payment->attachment_path) }}" target="_blank"
                                                    class="link-warning text-warning">
                                                    <i class="bi bi-paperclip"></i> View
                                                </a>
                                            @else
                                                <span class="text-muted">No Attachment</span>
                                            @endif
                                        </td>
                                        <td><span
                                                class="badge bg-info text-dark">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            @if ($payment->is_verified)
                                                <span class="badge bg-success">Verified</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-secondary text-white text-capitalize">{{ $payment->request_status }}</span>
                                        </td>
                                        <td><strong>${{ number_format($payment->total_order, 2) }}</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y, h:i A') }}</td>
                                    </tr>
                                @endforeach
                                <!-- More rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if (!$order->returnRequests->isEmpty())
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Return Request Details</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Reference ID</th>
                                    <th>Return Date & Time</th>
                                    <th>Proof Attachment</th>
                                    <th>Bank Details</th>
                                    <th>Verification Status</th>
                                    <th>Request Status</th>
                                    <th>Total Amount</th>
                                    <th>Submitted At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->returnRequests as $return)
                                    <tr>
                                        <td>{{ $return->reference_id ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($return->return_date_time)->format('d M Y, h:i A') ?? 'N/A' }}
                                        </td>
                                        <td>
                                            @if ($return->photo_proof)
                                                <a href="{{ asset($return->photo_proof) }}" target="_blank"
                                                    class="link-danger text-danger">
                                                    <i class="bi bi-paperclip"></i> View
                                                </a>
                                            @else
                                                <span class="text-muted">No Proof</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>
                                                <strong>Bank:</strong> {{ $return->bank_account_name }}<br>
                                                <strong>A/C No:</strong> {{ $return->account_no }}<br>
                                                <strong>BSB:</strong> {{ $return->bsb_number }}<br>
                                                <strong>Holder:</strong> {{ $return->account_holder_name }}<br>
                                            </small>
                                        </td>
                                        <td>
                                            @if ($return->is_verified)
                                                <span class="badge bg-success">Verified</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary text-white text-capitalize">
                                                {{ $return->request_status }}
                                            </span>
                                        </td>
                                        <td><strong>${{ number_format($return->total_order, 2) }}</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($return->created_at)->format('d M Y, h:i A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif


        @if ($order->order_status == 'pending')
            <div class="d-flex justify-content-center mb-4">
                <a href="{{ route('front.orders.cancel', $order->id) }}" class="btn btn-warning mx-2 btn-lg">Cancel
                    Order</a>
                @if ($order->payment_status == 'pending' || $order->payment_status == 'failed')
                    <a target="_blank" href="{{ route('front.orders.payment-upload.get', $order->id) }}"
                        class="btn btn-warning mx-2 btn-lg">Process Payment</a>
                @endif
            </div>
        @endif

        @if (
            $order->order_status == 'delivered' &&
                $order->payment_status == 'completed' &&
                ($order->return_status == 'none' || $order->return_status == 'rejected'))
            <div class="d-flex justify-content-center mb-4">
                <button type="button" class="btn btn-warning mx-2 btn-lg" id="showReturnFormBtn">Request Return</button>
            </div>
            <div id="returnFormContainer" style="display:none;">
                @include('front.return.request')
            </div>
        @endif
    </div>



@stop

@section('js')
    <script>
        $('#showReturnFormBtn').on('click', function() {
            $('#returnFormContainer').slideToggle();
        });
        $('#cancelButton').on('click', function() {
            $('#returnFormContainer').slideToggle();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#returnRequestForm').validate({
                rules: {
                    reference_id: {
                        required: true,
                        minlength: 4
                    },
                    'product_ids[]': {
                        required: true
                    },
                    photo_proof: {
                        required: true,
                    },
                    return_date_time: {
                        required: true
                    },
                    bank_account_name: {
                        required: true
                    },
                    bsb_number: {
                        required: true
                    },
                    account_no: {
                        required: true
                    },
                    account_holder_name: {
                        required: true
                    },
                    account_no_confirmation: {
                        required: true,
                        equalTo: "[name='account_no']"
                    },
                },
                // messages: {
                //     reference_id: {
                //         required: "Please enter reference ID.",
                //         minlength: "Reference ID must be at least 4 characters."
                //     },
                //     'product_ids[]': {
                //         required: "Please select at least one product."
                //     },
                //     photo_proof: {
                //         required: "Please upload photo proof.",
                //     },
                //     return_date_time: {
                //         required: "Please select return date and time."
                //     },
                //     bank_name: {
                //         required: "Please enter bank name."
                //     },
                //     branch_name: {
                //         required: "Please enter branch name."
                //     },
                //     account_type: {
                //         required: "Please enter account type."
                //     },
                //     ifsc_code: {
                //         required: "Please enter IFSC code."
                //     },
                //     bank_account_no: {
                //         required: "Please enter bank account number."
                //     },
                //     bank_account_no_confirmation: {
                //         required: "Please confirm your account number.",
                //         equalTo: "Account number does not match."
                //     },
                //     bank_account_holder_name: {
                //         required: "Please enter account holder name."
                //     }
                // },
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    $('#' + element.attr('name').replace('[]', '') + '_error').html(error);
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
        });
    </script>

@stop
