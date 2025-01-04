@extends('admin.layouts.main')
@section('title', 'View Conatct Message')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Users /</span> Conatct Message / View Conatct Message
    </h4>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-header">Conatct Message View</h5>
                    <div class="mx-2">
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
