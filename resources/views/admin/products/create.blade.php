@extends('admin.layouts.main')
@section('title', 'Create Product')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Products /</span> All Products /</span> Create Product</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Create Product </h5>
                <!-- Account -->
                <hr class="my-0" />
                <div class="card-body">
                    <form id="form" method="POST" action="{{ route('admin.products.save') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="cover_image" class="form-label">Cover Image</label>
                                <input class="form-control" type="file" id="cover_image" name="cover_image">
                                <div id="cover_image_error" class="text-danger"> @error('cover_image')
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
                                <label for="brand" class="form-label">Brand</label>
                                <select class="form-select select2 @error('brand') is-invalid @enderror" id="brand"
                                    name="brand">
                                    <option selected disabled>Select Brand</option>
                                    @foreach ($Brands as $Brand)
                                    <option value="{{ $Brand->id }}">{{ $Brand->name }}</option>
                                    @endforeach
                                </select>
                                <div id="brand_error" class="text-danger"> @error('brand')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select select2 @error('category') is-invalid @enderror" id="category"
                                    name="category">
                                </select>
                                <div id="category_error" class="text-danger"> @error('category')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="subcategory" class="form-label">Sub Category</label>
                                <select class="form-select select2 @error('subcategory') is-invalid @enderror" id="subcategory"
                                    name="subcategory">
                                </select>
                                <div id="subcategory_error" class="text-danger"> @error('subcategory')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="flavors" class="form-label">Flavor</label>
                                <select multiple class="form-select select2 @error('flavors') is-invalid @enderror" id="flavors"
                                    name="flavors[]">
                                    @foreach ($Flavors as $Flavor)
                                    <option value="{{ $Flavor->id }}">{{ $Flavor->name }}</option>
                                    @endforeach
                                </select>
                                <div id="flavors_error" class="text-danger"> @error('flavors')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="images" class="form-label">Images</label>
                                <input class="form-control" type="file" id="images" name="images[]" multiple>
                                <div id="images_error" class="text-danger">
                                    @error('images')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="sizes" class="form-label">Size</label>
                                <select multiple class="form-select select2 @error('sizes') is-invalid @enderror" id="sizes"
                                    name="sizes[]">
                                    @foreach ($Sizes as $Size)
                                    <option value="{{ $Size->id }}">{{ $Size->name }}</option>
                                    @endforeach
                                </select>
                                <div id="sizes_error" class="text-danger"> @error('sizes')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div id="priceInputsContainer" class="mb-3 col-md-12"></div>


                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" rows="10" type="text"
                                    id="description" name="description" value="">{{ old('description') }}</textarea>
                                <div id="description_error" class="text-danger"> @error('description')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save</button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back</a>
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
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
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
    CKEDITOR.replace('description');
</script>
<script>
    $(document).ready(function() {
        $('#form').validate({
            ignore: [],
            rules: {
                cover_image: {
                    required: true,
                },
                name: {
                    required: true,
                },
                brand: {
                    required: true,
                },
                category: {
                    required: true,
                },
                // subcategory: {
                //     required: true,
                // },
                'sizes[]': "required",
                'flavors[]': "required",
                'prices[]': "required",
                // 'images[]': "required",
                description: {
                    required: function() {
                        var editor = CKEDITOR.instances.description;
                        if (editor) {
                            var text = editor.getData().replace(/<[^>]*>/g, '');
                            return text.length === 0;
                        }
                        return true;
                    },
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

<script>
    $(document).ready(function() {
        $('#category').on('change', function() {
            const categoryId = $(this).val();
            const brandId = $('#brand').val();
            $('#subcategory').html('<option selected disabled >Select Subcategory</option>');
            $.ajax({
                url: '{{ route("admin.products.subcategories") }}',
                type: 'POST',
                data: {
                    categoryId: categoryId,
                    brandId: brandId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response && response.subcategories && response.subcategories.length > 0) {
                        response.subcategories.forEach(function(subcategory) {
                            $('#subcategory').append(
                                `<option value="${subcategory.id}">${subcategory.name}</option>`
                            );
                        });
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseText);
                    console.error('Failed to fetch subcategories:', xhr.responseText);
                }
            });
        });

        $('#brand').on('change', function() {
            const brandId = $('#brand').val();
            $('#category').html('<option  selected disabled >Select Category</option>');
            $('#subcategory').html('<option selected disabled >Select Subcategory</option>');
            $.ajax({
                url: '{{ route("admin.products.categories") }}',
                type: 'POST',
                data: {
                    brandId: brandId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Populate subcategories dropdown
                    if (response && response.categories && response.categories.length > 0) {
                        response.categories.forEach(function(category) {
                            $('#category').append(
                                `<option value="${category.id}">${category.name}</option>`
                            );
                        });
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseText);
                    console.error('Failed to fetch category:', xhr.responseText);
                }
            });
        });

        $('#sizes').change(function() {
            const selectedSizes = $(this).val();
            $('#priceInputsContainer .price-input').each(function() {
                const sizeId = $(this).data('size-id');
                if (!selectedSizes.includes(sizeId.toString())) {
                    $(this).remove();
                }
            });

            selectedSizes.forEach(function(sizeId) {
                if ($(`#price_${sizeId}`).length === 0) {
                    const sizeName = $(`#sizes option[value="${sizeId}"]`).text();
                    const priceInput = `
                        <div class="mb-3 price-input" data-size-id="${sizeId}">
                            <label for="price_${sizeId}" class="form-label">Price for ${sizeName}</label>
                            <input type="number" step="0.01" class="form-control" id="price_${sizeId}" name="prices[${sizeId}]" placeholder="Enter price for ${sizeName}">
                        </div>
                    `;
                    $('#priceInputsContainer').append(priceInput);

                    $(`#price_${sizeId}`).rules("add", {
                        required: true,
                        number: true,
                        min: 0.01,
                        messages: {
                            required: "Please enter a price for " + sizeName,
                            number: "Please enter a valid number for " + sizeName,
                            min: "Price must be greater than 0 for " + sizeName
                        }
                    });
                }
            });
        });
    });
</script>
@stop
