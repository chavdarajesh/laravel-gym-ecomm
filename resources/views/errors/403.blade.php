@extends('admin.layouts.main')
@section('title', $status . ' - ' . $message)
@section('content')
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <h2 class="mb-2 mx-2 d-flex justify-content-center">{{ $message }} :(</h2>
            <p class="mb-4 mx-2 d-flex justify-content-center">Oops! 😖 the web server has recognized a user's request but cannot grant access.</p>
            <div class="mt-3 d-flex justify-content-center">
                <img src="{{ asset('assets/admin/img/illustrations/girl-doing-yoga-light.png') }}"
                    alt="girl-doing-yoga-light" width="500" class="img-fluid"
                    data-app-dark-img="illustrations/page-misc-error-dark.png"
                    data-app-light-img="illustrations/girl-doing-yoga-light.png" />
            </div>
        </div>
    </div>
@stop
