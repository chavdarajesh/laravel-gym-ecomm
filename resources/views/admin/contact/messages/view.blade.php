@extends('admin.layouts.main')
@section('title', 'View Conatct Message')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Users /</span> Conatct Message / View Conatct Message
        </h4>

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">
                    <h5 class="card-header">Conatct Message View</h5>
                    <hr class="my-0" />
                    <div class="card-body">
                        <input type="hidden" name="id" value="{{ $ContactUsEnquiry->id }}">

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input class="form-control" type="text" id="name" name="name"
                                    value="{{ $ContactUsEnquiry->name }}" disabled />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="phone" class="form-label">Phone</label>
                                <input class="form-control" type="text" id="phone" name="phone"
                                    value="{{ $ContactUsEnquiry->phone }}" disabled />
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="email" class="form-label">E-mail</label>
                                <input class="form-control" type="text" id="email" name="email"
                                    value="{{ $ContactUsEnquiry->email }}" disabled />
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="goal" class="form-label">Goal</label>
                                <textarea name="goal" id="goal" rows="3" class="form-control" disabled> {{ $ContactUsEnquiry->goal }}</textarea>
                            </div>

                        </div>
                        <div class="mt-2">
                            <a href="{{ route('admin.contact.messages.index') }}"><button type="submit"
                                    class="btn btn-secondary me-2">Back</button></a>
                        </div>

                    </div>
                    <!-- /Account -->
                </div>
            </div>
        </div>
    </div>
@stop
