@extends('admin.layouts.main')
@section('title', 'Edit TopSellingProduct')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">TopSellingProducts /</span> Edit TopSellingProduct</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">TopSellingProducts Setting</h5>
                <!-- Account -->
                <hr class="my-0" />
                <div class="card-body">
                    <form id="form" method="POST" action="{{ route('admin.topsellingproducts.update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">

                            <div class="mb-3 col-md-12">
                                <label for="topsellingproducts" class="form-label">Top Selling Product</label>
                                <select multiple class="form-select select2 @error('topsellingproducts') is-invalid @enderror" id="topsellingproducts"
                                    name="topsellingproducts[]">
                                    @foreach ($Products as $Product)
                                    <option  {{ in_array($Product->id, $TopSellingProducts) ? 'selected' : '' }} value="{{ $Product->id }}">{{ $Product->name }}</option>
                                    @endforeach
                                </select>
                                <div id="subcategories_error" class="text-danger"> @error('subcategories')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <a href="{{ route('admin.topsellingproducts.index') }}" class="btn btn-secondary">Back</a>
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
    $(document).ready(function() {
        $('#form').validate({
            rules: {
                'topsellingproducts[]': {
                    required: true,
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
