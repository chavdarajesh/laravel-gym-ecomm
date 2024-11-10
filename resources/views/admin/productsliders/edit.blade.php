@extends('admin.layouts.main')
@section('title', 'Edit ProductSlider')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">ProductSliders /</span> All ProductSliders /</span> Edit ProductSlider</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">ProductSliders Setting</h5>
                <!-- Account -->
                <hr class="my-0" />
                <div class="card-body">
                    <form id="form" method="POST" action="{{ route('admin.productsliders.update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $ProductSlider['id'] }}">
                        <input type="hidden" name="old_image" value="{{ $ProductSlider['image'] }}" id="old_image">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="image" class="form-label">Image</label>
                                <input class="form-control" type="file" id="image" name="image" onchange="readURL(this)">
                                <div id="image_error" class="text-danger"> @error('image')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <img src="{{ $ProductSlider['image'] ? asset($ProductSlider['image']) : asset('assets/admin/img/avatars/dummy-image-square.jpg') }}"
                                    alt="ProductSlider Image" class="d-block rounded" height="100" width="100"
                                    id="uploadedAvatar" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text"
                                    id="name" name="name" value="{{ $ProductSlider['name'] }}" autofocus />
                                <div id="name_error" class="text-danger"> @error('name')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="product" class="form-label">Product</label>
                                <select class="form-select select2 @error('product') is-invalid @enderror" id="product"
                                    name="product">
                                    @if(!$ProductSlider->product_id)
                                    <option selected disabled>Select Product</option>
                                    @endif
                                    @foreach ($Products as $Product)
                                    <option {{$ProductSlider->product_id  == $Product->id ? 'selected' : '' }} value="{{ $Product->id }}">{{ $Product->name }}</option>
                                    @endforeach
                                </select>
                                <div id="product_error" class="text-danger"> @error('product')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="order" class="form-label">Order</label>
                                <input class="form-control @error('order') is-invalid @enderror" type="number"
                                    id="order" name="order" value="{{ $ProductSlider['order'] }}" autofocus />
                                <div id="order_error" class="text-danger"> @error('order')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>


                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <a href="{{ route('admin.productsliders.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="{{ asset('assets/admin/js/jquery.validate.min.js') }}"></script>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            if (input.files[0].type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector("#uploadedAvatar").setAttribute("src", e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                $('#image_error').html('Allowed JPG, GIF or PNG.')
                $('#upload').val('');
            }
        }
    }
</script>
<script>
    var imageRequired = $('#old_image').val() ? false : true;

    $(document).ready(function() {
        $('#form').validate({
            rules: {
                image: {
                    required: imageRequired,
                },
                order: {
                    number: true
                },
            },
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                $('#' + element.attr('id') + '_error').html(error)
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>
@stop
