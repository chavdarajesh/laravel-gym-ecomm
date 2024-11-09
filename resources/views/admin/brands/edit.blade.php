@extends('admin.layouts.main')
@section('title', 'Edit Brand')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Brands /</span> All Brands /</span> Edit Brand</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Brands Setting</h5>
                <!-- Account -->
                <hr class="my-0" />
                <div class="card-body">
                    <form id="form" method="POST" action="{{ route('admin.brands.update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $Brand['id'] }}">
                        <input type="hidden" name="old_image" value="{{ $Brand['image'] }}" id="old_image">
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
                                <img src="{{ $Brand['image'] ? asset($Brand['image']) : asset('assets/admin/img/avatars/dummy-image-square.jpg') }}"
                                    alt="Brand Image" class="d-block rounded" height="100" width="100"
                                    id="uploadedAvatar" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text"
                                    id="name" name="name" value="{{ $Brand['name'] }}" autofocus />
                                <div id="name_error" class="text-danger"> @error('name')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="categories" class="form-label">Category</label>
                                <select  multiple class="form-select select2 @error('categories') is-invalid @enderror" id="categories"
                                    name="categories[]">
                                    @foreach ($Categorys as $Category)
                                    <option {{ in_array($Category->id, $Brand->categories->pluck('id')->toArray()) ? 'selected' : '' }} value="{{ $Category->id }}">{{ $Category->name }}</option>
                                    @endforeach
                                </select>
                                <div id="categories_error" class="text-danger"> @error('categories')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="subcategories" class="form-label">Sub Category</label>
                                <select multiple class="form-select select2 @error('subcategories') is-invalid @enderror" id="subcategories"
                                    name="subcategories[]">
                                    @foreach ($subcategories as $subcategorie)
                                    <option {{ in_array($subcategorie->id, $Brand->subcategories->pluck('id')->toArray()) ? 'selected' : '' }} value="{{ $subcategorie->id }}">{{ $subcategorie->name }}</option>
                                    @endforeach
                                </select>
                                <div id="subcategories_error" class="text-danger"> @error('subcategories')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" rows="5" type="text" id="description"
                                    name="description" value="">{!! $Brand['description'] !!}</textarea>
                                <div id="description_error" class="text-danger"> @error('description')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Back</a>
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
    var imageRequired = $('#old_image').val() ? false : true;

    $(document).ready(function() {
        $('#form').validate({
            rules: {
                image: {
                    required: imageRequired,
                },
                name: {
                    required: true,
                },
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
    $('#categories').on('change', function() {
        const categoryIds = $(this).val();
        $('#subcategories').empty();
        $.ajax({
            url: '{{ route("admin.brands.subcategories") }}',
            type: 'POST',
            data: {
                category_ids: categoryIds,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Populate subcategories dropdown
                console.log(response);

                if (response && response.subcategories && response.subcategories.length > 0) {
                    response.subcategories.forEach(function(subcategory) {
                        $('#subcategories').append(
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
</script>
@stop
