@extends('admin.layouts.main')
@section('title', 'View Subcategory')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Subcategorys /</span> All Subcategorys /</span> View Subcategory</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Subcategorys Setting</h5>
                    <!-- Account -->
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ $Subcategory['image'] ? asset($Subcategory['image']) : asset('assets/admin/img/avatars/dummy-image-square.jpg') }}"
                                    alt="Subcategory Image" class="d-block rounded" height="100" width="100"
                                    id="uploadedAvatar" />
                                <div id="dvPreview">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input class="form-control" type="text" disabled id="name" name="name"
                                    value="{{ $Subcategory['name'] }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <div class="form-control">
                                    {!! html_entity_decode($Subcategory['description']) !!}
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('admin.subcategorys.edit', $Subcategory->id) }}" class="btn btn-warning">Edit</a>
                                <a href="{{ route('admin.subcategorys.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>
                    <!-- /Account -->
                </div>
            </div>
        </div>
    </div>
@stop
