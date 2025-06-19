@extends('admin.layouts.main')
@section('title', 'View User')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Users /</span> All Users / View User</h4>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <h5 class="card-header">User View</h5>
                <hr class="my-0" />
                <div class="card-body">
                    <input type="hidden" name="id" value="{{ $User->id }}">
                    <!-- <div class="row mb-3">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ $User->image ? asset($User->image) : asset('assets/admin/img/avatars/1.png') }}"
                                alt="user-avatar" class="d-block rounded" height="100" width="100"
                                id="uploadedAvatar" />
                            <div id="dvPreview">
                            </div>

                        </div>
                    </div> -->

                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Name</label>
                            <input class="form-control" type="text" id="name" name="name"
                                value="{{ $User->name }}" disabled />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="email" class="form-label">E-mail</label>
                            <input class="form-control" type="text" id="email" name="email"
                                value="{{ $User->email }}" disabled />
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input class="form-control" type="text" id="phone" name="phone"
                                value="{{ $User->phone }}" disabled />
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" id="address" rows="3" class="form-control" disabled> {{ $User->address }}</textarea>
                        </div>
                        
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('admin.users.edit', $User->id) }}"><button type="submit"
                                class="btn btn-warning">Edit</button></a>
                        <a href="{{ route('admin.users.index') }}"><button type="submit"
                                class="btn btn-secondary me-2">Back</button></a>
                    </div>

                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>
</div>
@stop
