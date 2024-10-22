@extends('front.layouts.main')
@section('title', 'Services')
@section('css')

@stop

@php
use App\Models\SiteSetting;
$services_membership_plans_price = SiteSetting::getSiteSettings('services_membership_plans_price');
$services_personal_training_price = SiteSetting::getSiteSettings('services_personal_training_price');
$services_zumba_classes_price = SiteSetting::getSiteSettings('services_zumba_classes_price');
@endphp

@section('content')

<!--? Hero Start -->
<div class="slider-area2">
    <div class="slider-height2 d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap hero-cap2 pt-70">
                        <h2>Our Services</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->
@if (
(isset($services_membership_plans_price) && isset($services_membership_plans_price->value)) ||
(isset($services_personal_training_price) && isset($services_personal_training_price->value)) ||
(isset($services_zumba_classes_price) && isset($services_zumba_classes_price->value)))
<!-- Courses area start -->
<section class="pricing-area section-padding30 fix">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section-tittle text-center mb-55">
                    <h2>Our Services</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @if (isset($services_membership_plans_price) &&
            isset($services_membership_plans_price->value) &&
            $services_membership_plans_price != null &&
            $services_membership_plans_price->value != '')
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="properties mb-30">
                    <div class="properties__card">
                        <div class="about-icon">
                            <img src="{{ asset('assets/front/img/icon/price.svg') }}" alt="">
                        </div>
                        <div class="properties__caption">
                            <span class="month">Membership Plans</span>
                            <p class="mb-25">{{ $services_membership_plans_price->value }} <br> <span>(Yearly and Weekly)</span></p>
                            <a target="_blank" href="https://oc.debitsuccess.com/DirectEntry/DirectDebitRequest/Form?brandtemplateid=57205586-c7b6-43e7-8f0f-ba3e74d3b1bd#collapse%5Bobject%2520Object%5D" class="border-btn border-btn2">Join Now</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if (isset($services_personal_training_price) &&
            isset($services_personal_training_price->value) &&
            $services_personal_training_price != null &&
            $services_personal_training_price->value != '')
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="properties mb-30">
                    <div class="properties__card">
                        <div class="about-icon">
                            <img src="{{ asset('assets/front/img/icon/price.svg') }}" alt="">
                        </div>
                        <div class="properties__caption">
                            <span class="month">Personal Training</span>
                            <p class="mb-25">{{ $services_personal_training_price->value }}<br> <span>(Per Session)</span></p>
                            <a target="_blank" href="https://oc.debitsuccess.com/DirectEntry/DirectDebitRequest/Form?brandtemplateid=57205586-c7b6-43e7-8f0f-ba3e74d3b1bd#collapse%5Bobject%2520Object%5D" class="border-btn border-btn2">Join Now</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if (isset($services_zumba_classes_price) &&
            isset($services_zumba_classes_price->value) &&
            $services_zumba_classes_price != null &&
            $services_zumba_classes_price->value != '')
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="properties mb-30">
                    <div class="properties__card">
                        <div class="about-icon">
                            <img src="{{ asset('assets/front/img/icon/price.svg') }}" alt="">
                        </div>
                        <div class="properties__caption">
                            <span class="month">Zumba Classes</span>
                            <p class="mb-25">{{ $services_zumba_classes_price->value }}<br> <span>(Per Class)</span></p>
                            <a target="_blank" href="https://oc.debitsuccess.com/DirectEntry/DirectDebitRequest/Form?brandtemplateid=57205586-c7b6-43e7-8f0f-ba3e74d3b1bd#collapse%5Bobject%2520Object%5D" class="border-btn border-btn2">Join Now</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@else
<section class="pricing-area section-padding30 fix">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section-tittle text-center mb-55">
                    <h2>No Services Available!</h2>
                </div>
            </div>
        </div>

    </div>
</section>
@endif
@stop
