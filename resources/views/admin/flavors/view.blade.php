@extends('admin.layouts.main')
@section('title', 'View Flavor')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Flavors /</span> All Flavors /</span> View Flavor</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Flavors Setting</h5>
                    <!-- Account -->
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input class="form-control" type="text" disabled id="name" name="name"
                                    value="{{ $Flavor['name'] }}" />
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('admin.flavors.edit', $Flavor->id) }}" class="btn btn-warning">Edit</a>
                                <a href="{{ route('admin.flavors.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>
                    <!-- /Account -->
                </div>
            </div>
        </div>
    </div>
@stop
