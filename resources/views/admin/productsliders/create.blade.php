@extends('admin.layouts.main')
@section('title', 'Create ProductSlider')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">ProductSliders /</span> All ProductSliders /</span> Create ProductSlider</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Create ProductSlider </h5>
                <!-- Account -->
                <hr class="my-0" />
                <div class="card-body">
                    <form id="form" method="POST" action="{{ route('admin.productsliders.save') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="image" class="form-label">Image</label>
                                <input class="form-control" type="file" id="image" name="image">
                                <div id="image_error" class="text-danger"> @error('image')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text"
                                    id="name" name="name" value="{{ old('name') }}" autofocus />
                                <div id="name_error" class="text-danger"> @error('name')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="product" class="form-label">Product</label>
                                <select class="form-select select2 @error('product') is-invalid @enderror" id="product"
                                    name="product">
                                    <option selected disabled>Select Product</option>
                                    @foreach ($Products as $Product)
                                    <option value="{{ $Product->id }}">{{ $Product->name }}</option>
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
                                    id="order" name="order" value="{{ old('order') }}" autofocus />
                                <div id="order_error" class="text-danger"> @error('order')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save</button>
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
    $(document).ready(function() {
        $('#form').validate({
            ignore: [],
            rules: {
                image: {
                    required: true,
                },
                order: {
                    number:true
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
