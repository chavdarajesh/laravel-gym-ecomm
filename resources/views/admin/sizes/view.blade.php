@extends('admin.layouts.main')
@section('title', 'View Size')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sizes /</span> All Sizes /</span> View Size</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Sizes Setting</h5>
                    <!-- Account -->
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input class="form-control" type="text" disabled id="name" name="name"
                                    value="{{ $Size['name'] }}" />
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('admin.sizes.edit', $Size->id) }}" class="btn btn-warning">Edit</a>
                                <a href="{{ route('admin.sizes.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>
                    <!-- /Account -->
                </div>
            </div>
        </div>
    </div>
@stop
