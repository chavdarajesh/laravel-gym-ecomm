@extends('admin.layouts.main')
@section('title', 'Edit NewsletterMail')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">NewsletterMails /</span> All NewsletterMails /</span>
            Edit NewsletterMail</h4>

        <div class="row">
            <div class="col-md-12">
               
                <div class="card mb-4">
                    <h5 class="card-header">NewsletterMails Setting</h5>
                    <!-- Account -->
                    <hr class="my-0" />
                    <div class="card-body">
                        <form id="form" method="POST" action="{{ route('admin.newslettermails.update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $NewsletterContent['id'] }}">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label for="content" class="form-label">Content</label>
                                    <textarea class="form-control @error('content') is-invalid @enderror" rows="5" type="text" id="content"
                                        name="content" value="">{!! $NewsletterContent['content'] !!}</textarea>
                                    <div id="content_error" class="text-danger"> @error('content')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                    <a href="{{ route('admin.newslettermails.index') }}" class="btn btn-secondary">Back</a>
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
        CKEDITOR.replace('content');
    </script>
    <script>
        $(document).ready(function() {
            $('#form').validate({
                rules: {
                    content: {
                        required: true,
                    }
                },
                messages: {
                    content: {
                        required: 'This field is required',
                    }
                },
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    $('#' + element.attr('name') + '_error').html(error)
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
