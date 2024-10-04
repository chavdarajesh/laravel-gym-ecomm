@extends('admin.layouts.main')
@section('title', 'Edit Blog')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Blogs /</span> All Blogs /</span> Edit Blog</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Blogs Setting</h5>
                <!-- Account -->
                <hr class="my-0" />
                <div class="card-body">
                    <form id="form" method="POST" action="{{ route('admin.blogs.update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $Blog['id'] }}">
                        <input type="hidden" name="old_image" value="{{ $Blog['image'] }}" id="old_image">
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
                                <img src="{{ $Blog['image'] ? asset($Blog['image']) : asset('assets/admin/img/avatars/dummy-image-square.jpg') }}"
                                    alt="Blog Image" class="d-block rounded" height="100" width="100"
                                    id="uploadedAvatar" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="title" class="form-label">Title</label>
                                <input class="form-control @error('title') is-invalid @enderror" type="text"
                                    id="title" name="title" value="{{ $Blog['title'] }}" autofocus />
                                <div id="title_error" class="text-danger"> @error('title')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="author" class="form-label">Author</label>
                                <select class="form-select @error('author') is-invalid @enderror" id="author"
                                    name="author">
                                    @foreach ($users as $user)
                                    <option {{ $user->id == $Blog->user->id ? 'selected' : '' }}
                                        value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <div id="author_error" class="text-danger"> @error('author')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="publish-date" class="form-label">Publish Date</label>
                                <input class="form-control @error('published_date') is-invalid @enderror" type="date"
                                    id="publish-date" name="published_date"
                                    value="{{ $Blog['published_date'] ? $Blog['published_date'] : date('Y-m-d') }}" />
                                <div id="published_date_error" class="text-danger"> @error('published_date')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="quality" class="form-label">Tags</label>
                                <div id="quality-fields">
                                    @foreach ($Blog->tags as $tag)
                                    <div>
                                        <input type="hidden" name="tags[{{ $loop->index }}][id]" value="{{ $tag->id }}">
                                        <div class="field-group d-flex my-1 dynamic-field-inputs-div" id="field-{{ $loop->index }}">
                                            <input type="text" name="tags[{{ $loop->index }}][name]" class="form-control" value="{{$tag->name}}" required>
                                            <button database-id="{{$tag->id}}" type="button" class="remove-quality-field btn btn-outline-danger mx-1"
                                                data-id="{{ $loop->index }}">-</button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-outline-primary my-2" id="add-quality-field">+ Add New Tag</button>
                                <div id="sub_sub_categories_error" class="text-danger"> @error('tags')
                                    {{ $message }}
                                    @enderror
                                    @error('quality')
                                    {{ $message }}
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" rows="5" type="text" id="description"
                                    name="description" value="">{!! $Blog['description'] !!}</textarea>
                                <div id="description_error" class="text-danger"> @error('description')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
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
<div class="modal fade" id="item-delete-model"
    tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Delete Item
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3>Do You Want To Really Delete This Item?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Close</button>
                <button type="button" id="delete-item-modal-button" class="btn btn-danger">Delete</button>
            </div>
            </form>
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
            //     author: {
            //         required: 'This field is required',
            //     },
            //     category: {
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
    let fieldIndex = $('.dynamic-field-inputs-div').length;
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
        dataId = $(this).attr('database-id');
        if (dataId) {
            $('#item-delete-model').modal('show');
        } else {
            const id = $(this).data('id');
            $(`#field-${id}`).remove();
            const divlenght = $('.dynamic-field-inputs-div').length;
            if (divlenght <= 1) {
                $('.remove-quality-field').prop('disabled', true);
            } else {
                $('.remove-quality-field').prop('disabled', false);
            }
        }
    });

    $(document).on('click', '#delete-item-modal-button', function() {
        if (dataId) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.blogs.delete.tag') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': dataId
                },
                success: function(data) {
                    if (data.success) {
                        $($("[database-id=" + dataId + "]")).parent().parent().remove();
                        $('#item-delete-model').modal('hide');
                        dataId = null;
                        toastr.success(data.success);
                    }
                    if (data.error) {
                        toastr.error(data.error);
                    }
                }
            });
        } else {
            $('#item-delete-model').modal('hide');
        }
    });
</script>
@stop
