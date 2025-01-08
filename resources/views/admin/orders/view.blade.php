@extends('admin.layouts.main')
@section('title', 'View Order')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Orders /</span> View Order
    </h4>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-header">Order View</h5>
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
                        <button type="button" class="btn  btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#delete-modal-{{ $Order->id }}">
                            Update Status
                        </button>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                    <input type="hidden" name="id" value="{{ $Order->id }}">

                    <div class="row">
                        <!-- Order Details -->
                        <div class="mb-3 col-md-12">
                            <label for="order-id" class="form-label">Order ID</label>
                            <input class="form-control" type="text" id="order-id" name="order_id" value="{{ $Order->id ?? '' }}" disabled />
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="total-order" class="form-label">Total Order</label>
                            <input class="form-control" type="text" id="total-order" name="total_order" value="{{ $Order->total_order ?? '' }}" disabled />
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="sub-total" class="form-label">Sub Total</label>
                            <input class="form-control" type="text" id="sub-total" name="sub_total" value="{{ $Order->sub_total ?? '' }}" disabled />
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="shipping-charge" class="form-label">Shipping Charge</label>
                            <input class="form-control" type="text" id="shipping-charge" name="shipping_charge" value="{{ $Order->shipping_charge ?? '' }}" disabled />
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="payment-type" class="form-label">Payment Type</label>
                            <input class="form-control" type="text" id="payment-type" name="payment_type" value="{{ $Order->payment_type ?? '' }}" disabled />
                        </div>

                        <!-- Order Address -->
                        <div class="mb-3 col-md-12">
                            <label for="address-line-1" class="form-label">Address Line 1</label>
                            <input class="form-control" type="text" id="address-line-1" name="address_line_1" value="{{ $Order->address->address_line_1 ?? '' }}" disabled />
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="address-line-2" class="form-label">Address Line 2</label>
                            <input class="form-control" type="text" id="address-line-2" name="address_line_2" value="{{ $Order->address->address_line_2 ?? '' }}" disabled />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="city" class="form-label">City</label>
                            <input class="form-control" type="text" id="city" name="city" value="{{ $Order->address->city ?? '' }}" disabled />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="state" class="form-label">State</label>
                            <input class="form-control" type="text" id="state" name="state" value="{{ $Order->address->state ?? '' }}" disabled />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="postal-code" class="form-label">Postal Code</label>
                            <input class="form-control" type="text" id="postal-code" name="postal_code" value="{{ $Order->address->postal_code ?? '' }}" disabled />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="country" class="form-label">Country</label>
                            <input class="form-control" type="text" id="country" name="country" value="{{ $Order->address->country ?? '' }}" disabled />
                        </div>

                        <!-- Order Products -->
                        <div class="col-md-12">
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
                                    @foreach($Order->products ?? [] as $product)
                                    <tr>
                                        <td>{{ $product->name ?? 'N/A' }}</td>
                                        <td>{{ $product->pivot->quantity  ?? 'N/A' }}</td>
                                        <td>{{ $product->pivot->size->name ?? 'N/A' }}</td>
                                        <td>{{ $product->pivot->flavor->name ?? 'N/A' }}</td>
                                        <td>${{ $product->pivot->price ?? 'N/A' }}</td>
                                        <td>${{ $product->pivot->total_price ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <h3>Payment Details</h3>
                        @if($Order->payments->isNotEmpty())
                        @foreach($Order->payments as $payment)
                        <div class="mb-3 col-md-12">
                            <label for="user-id-{{ $payment->id }}" class="form-label">User ID</label>
                            <input class="form-control" type="text" id="user-id-{{ $payment->id }}" value="{{ $payment->user_id ?? 'N/A' }}" disabled />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="order-id-{{ $payment->id }}" class="form-label">Order ID</label>
                            <input class="form-control" type="text" id="order-id-{{ $payment->id }}" value="{{ $payment->order_id ?? 'N/A' }}" disabled />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="payment-status-{{ $payment->id }}" class="form-label">Payment Status</label>
                            <input class="form-control" type="text" id="payment-status-{{ $payment->id }}" value="{{ $payment->status ?? 'N/A' }}" disabled />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="payment-id-{{ $payment->id }}" class="form-label">Payment ID</label>
                            <input class="form-control" type="text" id="payment-id-{{ $payment->id }}" value="{{ $payment->payment_id ?? 'N/A' }}" disabled />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="payment-method-{{ $payment->id }}" class="form-label">Payment Method</label>
                            <input class="form-control" type="text" id="payment-method-{{ $payment->id }}" value="{{ $payment->payment_method ?? 'N/A' }}" disabled />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="payment-token-{{ $payment->id }}" class="form-label">Payment Token</label>
                            <textarea class="form-control" id="payment-token-{{ $payment->id }}" disabled>{{ $payment->payment_token ?? 'N/A' }}</textarea>
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="payer-email-{{ $payment->id }}" class="form-label">Payer Email</label>
                            <input class="form-control" type="text" id="payer-email-{{ $payment->id }}" value="{{ $payment->payer_email ?? 'N/A' }}" disabled />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="payer-name-{{ $payment->id }}" class="form-label">Payer Name</label>
                            <input class="form-control" type="text" id="payer-name-{{ $payment->id }}" value="{{ $payment->payer_name ?? 'N/A' }}" disabled />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="payer-id-{{ $payment->id }}" class="form-label">Payer ID</label>
                            <input class="form-control" type="text" id="payer-id-{{ $payment->id }}" value="{{ $payment->payer_id ?? 'N/A' }}" disabled />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="business-name-{{ $payment->id }}" class="form-label">Business Name</label>
                            <input class="form-control" type="text" id="business-name-{{ $payment->id }}" value="{{ $payment->business_name ?? 'N/A' }}" disabled />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="account-id-{{ $payment->id }}" class="form-label">Account ID</label>
                            <input class="form-control" type="text" id="account-id-{{ $payment->id }}" value="{{ $payment->account_id ?? 'N/A' }}" disabled />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="shipping-name-{{ $payment->id }}" class="form-label">Shipping Name</label>
                            <input class="form-control" type="text" id="shipping-name-{{ $payment->id }}" value="{{ $payment->shipping_name ?? 'N/A' }}" disabled />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="shipping-address-{{ $payment->id }}" class="form-label">Shipping Address</label>
                            <textarea class="form-control" id="shipping-address-{{ $payment->id }}" disabled>{{ $payment->shipping_address ?? 'N/A' }}</textarea>
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="currency-code-{{ $payment->id }}" class="form-label">Currency Code</label>
                            <input class="form-control" type="text" id="currency-code-{{ $payment->id }}" value="{{ $payment->currency_code ?? 'N/A' }}" disabled />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="total-order-{{ $payment->id }}" class="form-label">Total Order</label>
                            <input class="form-control" type="text" id="total-order-{{ $payment->id }}" value="{{ $payment->total_order ?? 'N/A' }}" disabled />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="sub-total-{{ $payment->id }}" class="form-label">Sub Total</label>
                            <input class="form-control" type="text" id="sub-total-{{ $payment->id }}" value="{{ $payment->sub_total ?? 'N/A' }}" disabled />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="shipping-charge-{{ $payment->id }}" class="form-label">Shipping Charge</label>
                            <input class="form-control" type="text" id="shipping-charge-{{ $payment->id }}" value="{{ $payment->shipping_charge ?? 'N/A' }}" disabled />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="paypal-fee-{{ $payment->id }}" class="form-label">PayPal Fee</label>
                            <input class="form-control" type="text" id="paypal-fee-{{ $payment->id }}" value="{{ $payment->paypal_fee ?? 'N/A' }}" disabled />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="net-amount-{{ $payment->id }}" class="form-label">Net Amount</label>
                            <input class="form-control" type="text" id="net-amount-{{ $payment->id }}" value="{{ $payment->net_amount ?? 'N/A' }}" disabled />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="exchange-rate-{{ $payment->id }}" class="form-label">Exchange Rate</label>
                            <input class="form-control" type="text" id="exchange-rate-{{ $payment->id }}" value="{{ $payment->exchange_rate ?? 'N/A' }}" disabled />
                        </div>

                        <hr />
                        @endforeach
                        @else
                        <p>No payment details available for this order.</p>
                        @endif

                    </div>

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

<div class="modal fade" id="delete-modal-{{ $Order->id }}" tabindex="-1" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.orders.updateStatus', ['id' => $Order->id]) }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Update Status
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select  @error('status') is-invalid @enderror" aria-label="Default select example" id="status" name="status">
                            <option selected disabled>Select Status</option>
                            @foreach($OrderStatus as $OrderStatu)
                            <option value="{{$OrderStatu->id}}">{{$OrderStatu->name}}</option>
                            @endforeach
                        </select>
                        <div id="status_error" class="text-danger"> @error('status')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <!-- <input type="hidden" name="mark_as_completed" value="off"> -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="on" id="mark_as_completed" name="mark_as_completed">
                        <label class="form-check-label" for="mark_as_completed">
                            Mark as Completed
                        </label>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control  @error('description') is-invalid @enderror" id="description" name="description" id="description" rows="3"></textarea>
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



@stop


@section('js')
<script src="{{ asset('assets/admin/js/jquery.validate.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Apply validation to forms inside modals dynamically
        $('.modal form').each(function() {
            $(this).validate({
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

        // Prevent form submission if invalid
        $('.modal form').on('submit', function(e) {
            if (!$(this).valid()) {
                e.preventDefault();
            }
        });
    });
</script>

@stop


@error('status')

<script>
    $(document).ready(function() {
        $('#delete-modal-{{ $Order->id }}').modal('show');
    });
</script>
@enderror
@error('description')

<script>
    $(document).ready(function() {
        $('#delete-modal-{{ $Order->id }}').modal('show');
    });
</script>
@enderror
