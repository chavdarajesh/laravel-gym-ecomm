@extends('admin.layouts.main')
@section('title', 'Create Blog')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Blogs /</span> All Blogs /</span> Create Blog</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Create Blog </h5>
                <!-- Account -->
                <hr class="my-0" />
                <div class="card-body">
                    <form id="form" method="POST" action="{{ route('admin.blogs.save') }}"
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
                                <label for="title" class="form-label">Title</label>
                                <input class="form-control @error('title') is-invalid @enderror" type="text"
                                    id="title" name="title" value="{{ old('title') }}" autofocus />
                                <div id="title_error" class="text-danger"> @error('title')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="author" class="form-label">Author</label>
                                <input class="form-control @error('author') is-invalid @enderror" type="text"
                                    id="author" name="author" value="{{ Auth::user()->name }}" disabled />
                                <div id="author_error" class="text-danger"> @error('author')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="publish-date" class="form-label">Publish Date</label>
                                <input class="form-control @error('published_date') is-invalid @enderror" type="date"
                                    id="publish-date" name="published_date"
                                    value="{{ old('published_date') ? old('published_date') : date('Y-m-d') }}" />
                                <div id="published_date_error" class="text-danger"> @error('published_date')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="quality" class="form-label">Tags</label>
                                <div id="quality-fields">
                                </div>
                                <button type="button" class="btn btn-outline-primary my-2" id="add-quality-field">+ Add New Tag</button>
                                <div id="quality_error" class="text-danger"> @error('fields')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
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
                                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Back</a>
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
                image: {
                    required: true,
                },
                title: {
                    required: true,
                },
                author: {
                    required: true,
                },
                published_date: {
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
                'fields[]': {
                    required: true
                }
            },
            messages: {
                'fields[]': {
                    required: "This field is required.",
                }
            },
            // messages: {
            //     image: {
            //         required: 'This field is required',
            //     },
            //     title: {
            //         required: 'This field is required',
            //     },
            //     user: {
            //         required: 'This field is required',
            //     },
            //     author: {
            //         required: 'This field is required',
            //     },
            //     tags: {
            //         required: 'This field is required',
            //     },
            //     published_date: {
            //         required: 'This field is required',
            //     },
            //     description: {
            //         required: 'This field is required',
            //     }
            // },
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
    let fieldIndex = 0;

    // Function to add a new input field
    $('#add-quality-field').click(function() {
        fieldIndex++;
        $('#quality-fields').append(`
    <div class="field-group d-flex my-1 dynamic-field-inputs-div" id="field-${fieldIndex}">
    <input type="text" name="fields[]" class="field-input form-control mx-1" required />
    <button type="button" class="remove-quality-field btn btn-outline-danger mx-1" data-id="${fieldIndex}">-</button>
    </div>
    `);
        const lenght = $('.dynamic-field-inputs-div').length;
        if (lenght <= 1) {
            $('.remove-quality-field').prop('disabled', true);
        } else {
            $('.remove-quality-field').prop('disabled', false);
        }

    });

    // Function to remove an input field
    $(document).on('click', '.remove-quality-field', function() {
        const id = $(this).data('id');
        $(`#field-${id}`).remove();
        const divlenght = $('.dynamic-field-inputs-div').length;
        if (divlenght <= 1) {
            $('.remove-quality-field').prop('disabled', true);
        } else {
            $('.remove-quality-field').prop('disabled', false);
        }
    });
</script>
@stop
