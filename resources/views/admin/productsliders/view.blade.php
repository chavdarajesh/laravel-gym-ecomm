@extends('admin.layouts.main')
@section('title', 'View ProductSlider')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">ProductSliders /</span> All ProductSliders /</span> View ProductSlider</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">ProductSliders Setting</h5>
                <!-- Account -->
                <hr class="my-0" />
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ $ProductSlider['image'] ? asset($ProductSlider['image']) : asset('assets/admin/img/avatars/dummy-image-square.jpg') }}"
                                alt="ProductSlider Image" class="d-block rounded" height="100" width="100"
                                id="uploadedAvatar" />
                            <div id="dvPreview">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Name</label>
                            <input class="form-control" type="text" disabled id="name" name="name"
                                value="{{ $ProductSlider['name'] }}" />
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="product" class="form-label">Product</label>
                            <select disabled class="form-select select2" id="product"
                                name="product">
                                @if(!$ProductSlider->product_id)
                                <option selected disabled>Select Product</option>
                                @else
                                <option selected value="{{ $ProductSlider->product_id }}">{{ $ProductSlider->product->name }}</option>
                                @endif
                            </select>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="order" class="form-label">Order</label>
                            <input disabled class="form-control " type="number"
                                id="order" name="order" value="{{ $ProductSlider['order'] }}" autofocus />
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('admin.productsliders.edit', $ProductSlider->id) }}" class="btn btn-warning">Edit</a>
                            <a href="{{ route('admin.productsliders.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>
</div>
@stop
