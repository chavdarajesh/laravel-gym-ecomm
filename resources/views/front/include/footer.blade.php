 <!-- ======= Footer ======= -->
 @php $current_route_name=Route::currentRouteName() @endphp
 @php
 use App\Models\ContactUsSetting;
 $ContactUsSetting = ContactUsSetting::get_contact_us_details();
 use App\Models\SiteSetting;
 $social_facebook_url = SiteSetting::getSiteSettings('social_facebook_url');
 $social_linkedin_url = SiteSetting::getSiteSettings('social_linkedin_url');
 $social_instagram_url = SiteSetting::getSiteSettings('social_instagram_url');
 $social_youtube_url = SiteSetting::getSiteSettings('social_youtube_url');
 $social_twitter_url = SiteSetting::getSiteSettings('social_twitter_url');
 $footerLogo = SiteSetting::getSiteSettings('footer_logo');
 @endphp

 @if ($ContactUsSetting)
 <section class="services-area">
     <div class="container">
         <div class="row justify-content-between">
             @if($ContactUsSetting ['address_1'])
             <div class="col-xl-4 col-lg-4 col-md-6 col-sm-8">
                 <div class="single-services mb-40">
                     <div class="features-icon text-white  d-flex justify-content-center  fa-4x">
                     <i class="fa fa-map"></i>
                         <!-- <img src="{{ asset('assets/front/img/icon/icon1.svg') }}" alt=""> -->
                     </div>
                     <div class="features-caption">
                         <h3>Location</h3>
                         <p>{{$ContactUsSetting ['address_1']}} , {{$ContactUsSetting ['address_2']}} </p>
                     </div>
                 </div>
             </div>
             @endif
             @if($ContactUsSetting ['phone'])
             <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                 <div class="single-services mb-40">
                 <div class="features-icon text-white  d-flex justify-content-center  fa-4x">
                     <i class="fa fa-phone"></i>
                         <!-- <img src="{{ asset('assets/front/img/icon/icon1.svg') }}" alt=""> -->
                     </div>
                     <div class="features-caption">
                         <h3>Phone</h3>
                         <p>{{$ContactUsSetting ['phone']}}</p>
                     </div>
                 </div>
             </div>
             @endif
             @if($ContactUsSetting ['email'])
             <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                 <div class="single-services mb-40">
                 <div class="features-icon text-white  d-flex justify-content-center  fa-4x">
                 <i class="fas fa-envelope"></i>
                         <!-- <img src="{{ asset('assets/front/img/icon/icon1.svg') }}" alt=""> -->
                     </div>
                     <div class="features-caption">
                         <h3>Email</h3>
                         <p>{{$ContactUsSetting ['email']}}</p>
                     </div>
                 </div>
             </div>
             @endif
         </div>
     </div>
 </section>
 @endif
 <footer>
     <!--? Footer Start-->
     <div class="footer-area black-bg">
         <div class="container">
             <div class="footer-top footer-padding">
                 <!-- Footer Menu -->
                 <div class="row">
                     <div class="col-xl-12">
                         <div class="single-footer-caption mb-50 text-center">
                             <!-- logo -->
                             <div class="footer-logo wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                                 <a href="{{route('front.home')}}"><img width="80px" src="{{ isset($headerLogo) && isset($headerLogo->value) && $headerLogo != null ? asset($headerLogo->value) : asset('custom-assets/default/admin/images/siteimages/logo/footer-logo.png') }}" alt="Logo"></a>
                             </div>
                             <!-- Menu -->
                             <!-- Header Start -->
                             <div class="header-area main-header2 wow fadeInUp" data-wow-duration="2s"
                                 data-wow-delay=".4s">
                                 <div class="main-header main-header2">
                                     <div class="menu-wrapper menu-wrapper2">
                                         <!-- Main-menu -->
                                         <div class="main-menu main-menu2 text-center">
                                             <nav>
                                                 <ul>
                                                     <li class="{{ Route::currentRouteName() == 'front.home' ? 'active' : '' }}"><a href="{{route('front.home')}}">Home</a></li>
                                                     <li class="{{ Route::currentRouteName() == 'front.about' ? 'active' : '' }}"><a href="{{ route('front.about') }}">About</a></li>
                                                     <li class="{{ Route::currentRouteName() == 'front.privacy_policy' ? 'active' : '' }}"><a href="{{ route('front.privacy_policy') }}">Privacy Policy</a></li>
                                                     <li class="{{ Route::currentRouteName() == 'front.term_and_condition' ? 'active' : '' }}"><a href="{{ route('front.term_and_condition') }}">Terms and Conditions</a></li>
                                                     <li class="{{ Route::currentRouteName() == 'front.return_and_refund' ? 'active' : '' }}"><a href="{{ route('front.return_and_refund') }}">Return and Refund</a></li>
                                                     <li class="{{ Route::currentRouteName() == 'front.contact' ? 'active' : '' }}"><a href="{{ route('front.contact') }}">Contact</a></li>
                                                 </ul>
                                             </nav>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <!-- Header End -->
                             <!-- social -->
                             @if (
                             (isset($social_facebook_url) && isset($social_facebook_url->value)) ||
                             (isset($social_youtube_url) && isset($social_youtube_url->value)) ||
                             (isset($social_linkedin_url) && isset($social_linkedin_url->value)) ||
                             (isset($social_twitter_url) && isset($social_twitter_url->value)) ||
                             (isset($social_instagram_url) && isset($social_instagram_url->value)))
                             <div class="footer-social mt-30 wow fadeInUp" data-wow-duration="3s"
                                 data-wow-delay=".8s">
                                 @if (isset($social_twitter_url) &&
                                 isset($social_twitter_url->value) &&
                                 $social_twitter_url != null &&
                                 $social_twitter_url->value != '')
                                 <a href="{{ $social_twitter_url->value }}" target="_blank"><i class="fab fa-twitter"></i></a>
                                 @endif
                                 @if (isset($social_facebook_url) &&
                                 isset($social_facebook_url->value) &&
                                 $social_facebook_url != null &&
                                 $social_facebook_url->value != '')
                                 <a href="{{ $social_facebook_url->value }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                 @endif
                                 @if (isset($social_instagram_url) &&
                                 isset($social_instagram_url->value) &&
                                 $social_instagram_url != null &&
                                 $social_instagram_url->value != '')
                                 <a href="{{ $social_instagram_url->value }}" target="_blank"><i class="fab fa-instagram"></i></a>
                                 @endif
                                 @if (isset($social_youtube_url) &&
                                 isset($social_youtube_url->value) &&
                                 $social_youtube_url != null &&
                                 $social_youtube_url->value != '')
                                 <a href="{{ $social_youtube_url->value }}" target="_blank"><i class="fab fa-youtube"></i></a>
                                 @endif
                             </div>
                             @endif
                         </div>
                     </div>
                 </div>
             </div>
             <!-- Footer Bottom -->
             <div class="footer-bottom">
                 <div class="row d-flex align-items-center">
                     <div class="col-lg-12">
                         <div class="footer-copy-right text-center">
                             <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                 Copyright &copy;
                                 <?php echo date('Y'); ?> All rights reserved |
                                 <a href="{{ route('front.home') }}"> {{ env('APP_NAME', 'Laravel App') }}</a>
                                 <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                             </p>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- Footer End-->
 </footer>

 <div id="back-top">
     <a title="Go to Top" href="javascript:void(0);"> <i class="fas fa-level-up-alt"></i></a>
 </div>
