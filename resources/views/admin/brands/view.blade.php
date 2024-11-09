@extends('admin.layouts.main')
@section('title', 'View Brand')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Brands /</span> All Brands /</span> View Brand</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Brands Setting</h5>
                    <!-- Account -->
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ $Brand['image'] ? asset($Brand['image']) : asset('assets/admin/img/avatars/dummy-image-square.jpg') }}"
                                    alt="Brand Image" class="d-block rounded" height="100" width="100"
                                    id="uploadedAvatar" />
                                <div id="dvPreview">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input class="form-control" type="text" disabled id="name" name="name"
                                    value="{{ $Brand['name'] }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="categories" class="form-label">Category</label>
                                <select disabled multiple class="form-select select2 @error('categories') is-invalid @enderror" id="categories"
                                    name="categories[]">
                                    @foreach ($Brand->categories as $categories)
                                    <option selected value="{{ $categories->id }}">{{ $categories->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="subcategories" class="form-label">Sub Category</label>
                                <select disabled multiple class="form-select select2 @error('subcategories') is-invalid @enderror" id="subcategories"
                                    name="subcategories[]">
                                    @foreach ($Brand->subcategories as $Subcategory)
                                    <option selected value="{{ $Subcategory->id }}">{{ $Subcategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <div class="form-control">
                                    {!! html_entity_decode($Brand['description']) !!}
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('admin.brands.edit', $Brand->id) }}" class="btn btn-warning">Edit</a>
                                <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>
                    <!-- /Account -->
                </div>
            </div>
        </div>
    </div>
@stop
