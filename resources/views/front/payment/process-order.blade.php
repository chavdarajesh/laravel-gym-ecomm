@extends('front.layouts.main')
@section('title', 'Upload Payment Details')
@section('css')

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;700&amp;display=swap">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">


    <style>
        #products-completed .nav {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
        }

        #products-completed .nav-link {
            display: block;
            padding: 0.5rem 1rem;
            text-decoration: none;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
        }

        @media (prefers-reduced-motion: reduce) {
            #products-completed .nav-link {
                transition: none;
            }
        }

        #products-completed .nav-link.disabled {
            color: #adb5bd;
            pointer-events: none;
            cursor: default;
        }

        #products-completed .nav-tabs {
            border-bottom: 1px solid transparent;
        }

        #products-completed .nav-tabs .nav-link {
            margin-bottom: -1px;
            background: none;
            border: 1px solid transparent;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
        }

        #products-completed .nav-tabs .nav-link:hover,
        .nav-tabs .nav-link:focus {
            border-color: #e9ecef #e9ecef transparent;
            isolation: isolate;
        }

        #products-completed .nav-tabs .nav-link.disabled {
            color: #adb5bd;
            background-color: transparent;
            border-color: transparent;
        }

        #products-completed .nav-tabs .nav-link.active,
        #products-completed .nav-tabs .nav-item.show .nav-link {
            color: #000;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
        }

        #products-completed .nav-tabs .dropdown-menu {
            margin-top: -1px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        #products-completed #products-completed .nav-pills .nav-link {
            background: none;
            border: 0;
            border-radius: 0.25rem;
        }

        #products-completed .nav-pills .nav-link.active,
        #products-completed .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #000;
        }

        #products-completed .nav-fill>.nav-link,
        #products-completed .nav-fill .nav-item {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            text-align: center;
        }

        #products-completed .nav-justified>.nav-link,
        #products-completed .nav-justified .nav-item {
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -ms-flex-positive: 1;
            flex-grow: 1;
            text-align: center;
        }

        .custom-card {
            min-height: 100%;
            border-radius: 1rem;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
            transition: box-shadow 0.3s, transform 0.3s;
        }

        .custom-card:hover {
            box-shadow: 0 6px 32px rgba(0, 0, 0, 0.16), 0 1.5px 6px rgba(0, 0, 0, 0.07);
            transform: translateY(-4px) scale(1.02);
            z-index: 1;
        }

        .custom-card .card-header {
            border-radius: 1rem 1rem 0 0 !important;
            letter-spacing: 1px;
        }

        .custom-card .btn-outline-info:hover,
        .custom-card .btn-outline-info:focus {
            background: #17a2b8;
            color: #fff;
            border-color: #17a2b8;
            box-shadow: 0 2px 8px rgba(23, 162, 184, 0.2);
        }

        @media (min-width: 768px) {
            .equal-height-row {
                display: flex;
            }

            .equal-height-col {
                display: flex;
                flex-direction: column;
            }
        }
    </style>
@stop

@section('content')
    <!--? Hero Start -->
    <div class="slider-area2">
        <div class="slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="">
                            <h2 class="text-white">Order Completed</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->
    <!--? Team -->



    <section class="py-5" id="products-completed">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <ul class="nav nav-tabs nav-fill border-bottom mb-5 flex-column flex-md-row">
                        <li class="nav-item"><a class="nav-link disabled" href="javascript:void(0);">Shopping cart</a></li>
                        <li class="nav-item"><a class="nav-link disabled" href="javascript:void(0);">Billing Information</a>
                        </li>
                        <li class="nav-item"><a class="nav-link active" href="javascript:void(0);">Payment</a></li>
                        <li class="nav-item"><a class="nav-link disabled" aria-current="page"
                                href="javascript:void(0);">Completed</a></li>
                    </ul>

                    <div class="container py-4">
                        {{-- BANK DETAILS --}}
                        <div class="row mb-4 equal-height-row">
                            <div class="col-md-6 equal-height-col mb-3 mb-md-0">
                                <div class="card border-warning custom-card flex-grow-1 h-100">
                                    <div class="card-header bg-warning text-dark text-uppercase fw-bold">
                                        <i class="fas fa-university me-2"></i>Bank Details
                                    </div>
                                    <div class="card-body">
                                        <span class="text-muted mb-3 d-block">
                                            Thank you for placing your order!

                                            To complete your payment, please transfer the order amount to the following bank
                                            account:
                                        </span>
                                        <ul class="list-unstyled mb-0 fs-6">
                                            <li class="mb-2"><strong>Account Holder Name:</strong>
                                                {{ $bankDetails['account_name'] ?? 'ABC Pvt Ltd' }}
                                            </li>
                                            <li class="mb-2"><strong>Account Number:</strong>
                                                {{ $bankDetails['account_number'] ?? '123456789012' }}
                                            </li>
                                            <li class="mb-2"><strong>IFSC Code:</strong>
                                                {{ $bankDetails['ifsc_code'] ?? 'HDFC0001234' }}
                                            </li>
                                            <li class="mb-2"><strong>Bank Name:</strong>
                                                {{ $bankDetails['bank_name'] ?? 'HDFC Bank' }}
                                            </li>
                                            <li class="mb-2"><strong>Branch Name:</strong>
                                                {{ $bankDetails['branch_name'] ?? 'Mumbai Main Branch' }}
                                            </li>
                                            <li class="mb-2"><strong>Account Type:</strong>
                                                {{ $bankDetails['account_type'] ?? 'Current' }}
                                            </li>
                                            {{-- Add any extra details here --}}
                                            <li class="mt-3 text-muted" style="font-size:0.92em;">
                                                <i class="fas fa-info-circle"></i> Please ensure you transfer to the correct
                                                details.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 equal-height-col">
                                <div class="card border-info custom-card flex-grow-1 h-100">
                                    <div class="card-header bg-info text-white text-uppercase fw-bold">
                                        <i class="fas fa-receipt me-2"></i>Order Details
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled mb-3 fs-6">
                                            <li class="mb-2"><strong>Order ID:</strong> #{{ $order->id }}</li>
                                            <li class="mb-2"><strong>Order Date:</strong>
                                                {{ $order->created_at->format('d M Y, h:i A') }}</li>
                                            <li class="mb-2"><strong>Status:</strong>
                                                {{ optional($order->latestStatus->first())->name ?? 'N/A' }}</li>
                                        </ul>
                                        <ul class="list-unstyled mb-3 fs-6">
                                            <li class="mb-2"><strong>Subtotal:</strong>
                                                ${{ number_format($order->sub_total, 2) }}</li>
                                            <li class="mb-2"><strong>Shipping Charge:</strong>
                                                ${{ number_format($order->shipping_charge, 2) }}</li>
                                            <li class="mb-2"><strong>Order Amount:</strong>
                                                ${{ number_format($order->total_order, 2) }}</li>
                                            <li class="mb-2"><strong>Total Items:</strong>
                                                {{ $order->products->sum('pivot.quantity') }}</li>
                                        </ul>
                                        <a target="_blank" href="{{ route('front.orders.details', ['id' => $order->id]) }}"
                                            class="btn btn-sm btn-outline-warning mt-2 w-100">
                                            <i class="fas fa-info-circle me-1"></i>Order Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PAYMENT UPLOAD FORM --}}
                        <h3 class="text-center mb-4">Upload Payment Details</h3>
                        <form action="{{ route('front.orders.payment-upload.post', ['id' => $order->id]) }}" method="post"
                            id="paymentUploadForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mx-auto">
                                    <div class="row">

                                        <div class="form-group col-md-12 mb-3">
                                            <label for="reference_id" class="form-label small text-uppercase">Reference
                                                ID</label>
                                            <input id="reference_id" type="text" name="reference_id"
                                                class="form-control @error('reference_id') border border-danger @enderror"
                                                placeholder="Enter transaction/reference ID"
                                                value="{{ old('reference_id') }}">
                                            <div id="reference_id_error" class="text-danger">
                                                @error('reference_id')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 mb-3">
                                            <label for="payment_date_time" class="form-label small text-uppercase">Payment
                                                Date</label>
                                            <input id="payment_date_time" type="datetime-local" name="payment_date_time"
                                                class="form-control @error('payment_date_time') border border-danger @enderror"
                                                value="{{ old('payment_date_time') }}">
                                            <div id="payment_date_time_error" class="text-danger">
                                                @error('payment_date_time')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 mb-3">
                                            <label for="payment_method" class="form-label small text-uppercase">Payment
                                                Method</label>
                                            <select id="payment_method" name="payment_method"
                                                class="form-select @error('payment_method') border border-danger @enderror">
                                                <option value="">Select Method</option>
                                                <option value="bank_transfer"
                                                    {{ old('payment_method', 'bank_transfer') == 'bank_transfer' ? 'selected' : '' }}>
                                                    Bank Transfer</option>
                                                {{-- Add more options if needed --}}
                                            </select>
                                            <div id="payment_method_error" class="text-danger">
                                                @error('payment_method')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 mb-3">
                                            <label for="attachment" class="form-label small text-uppercase">Upload
                                                Screenshot / Receipt</label>
                                            <input accept=".jpg,.jpeg,.png,.pdf" id="attachment" type="file"
                                                name="attachment"
                                                class="form-control @error('attachment') border border-danger @enderror">
                                            <div id="attachment_error" class="text-danger">
                                                @error('attachment')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-between">
                                            <a class="btn btn-warning product-list-btn"
                                                href="{{ route('front.products') }}"> <i
                                                    class="fas fa-shopping-bag mr-2"></i>Continue shopping</a>
                                            <button type="submit" class="btn btn-outline-warning">
                                                Upload Payment
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        </div>
    </section>



@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#paymentUploadForm').validate({
                rules: {
                    reference_id: {
                        required: true,
                        minlength: 4
                    },
                    payment_date_time: {
                        required: true,
                        date: true
                    },
                    payment_method: {
                        required: true
                    },
                    attachment: {
                        required: true,
                    }
                },
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    $('#' + element.attr('name') + '_error').html(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('border border-danger');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('border border-danger');
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@stop
