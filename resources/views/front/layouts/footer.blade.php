<!-- JS here -->

<script src="{{ asset('assets/front/js/vendor/modernizr-3.5.0.min.js') }}"></script>
<!-- Jquery, Popper, Bootstrap -->
<script src="{{ asset('assets/front/js/vendor/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('assets/front/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>
<!-- Jquery Mobile Menu -->
<script src="{{ asset('assets/front/js/jquery.slicknav.min.js') }}"></script>

<!-- Jquery Slick , Owl-Carousel Plugins -->
<script src="{{ asset('assets/front/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/front/js/slick.min.js') }}"></script>
<!-- One Page, Animated-HeadLin -->
<script src="{{ asset('assets/front/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/front/js/animated.headline.js') }}"></script>
<script src="{{ asset('assets/front/js/jquery.magnific-popup.js') }}"></script>

<!-- Date Picker -->
<script src="{{ asset('assets/front/js/gijgo.min.js') }}"></script>
<!-- Nice-select, sticky -->
<script src="{{ asset('assets/front/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('assets/front/js/jquery.sticky.js') }}"></script>

<!-- counter , waypoint,Hover Direction -->
<script src="{{ asset('assets/front/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('assets/front/js/waypoints.min.js') }}"></script>
<script src="{{ asset('assets/front/js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('assets/front/js/hover-direction-snake.min.js') }}"></script>

<!-- contact js -->
<script src="{{ asset('assets/front/js/contact.js') }}"></script>
<script src="{{ asset('assets/front/js/jquery.form.js') }}"></script>
<script src="{{ asset('assets/front/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/front/js/mail-script.js') }}"></script>
<script src="{{ asset('assets/front/js/jquery.ajaxchimp.min.js') }}"></script>

<!-- Jquery Plugins, main Jquery -->
<script src="{{ asset('assets/front/js/plugins.js') }}"></script>
<script src="{{ asset('assets/front/js/main.js') }}"></script>

{{-- Custom --}}
<script src="{{ asset('custom-assets/default/front/js/toastr.min.js') }}"></script>

<script>
    @if(Session::has('message'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "preventDuplicates": true
    }
    toastr.success("{{ session('message') }}");
    @endif

    @if(Session::has('error'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "preventDuplicates": false
    }
    toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('info'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "preventDuplicates": false
    }
    toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "preventDuplicates": false
    }
    toastr.warning("{{ session('warning') }}");
    @endif
</script>


<script>
    $(document).ready(function() {
        $('#product-nav-menu .dropdown-submenu .dropdown-toggle .drop-down-arrow').on('click', function(e) {
            e.stopPropagation();
            $(this).parent().next('.dropdown-menu').toggle();
        });
        $(window).resize(function() {
            if ($(window).width() >= 980) {
                $("#product-nav-menu .navbar .dropdown-toggle").hover(function() {
                    $(this).parent().toggleClass("show");
                    $(this).parent().find(".dropdown-menu").toggleClass("show");
                });
                $("#product-nav-menu  .navbar .dropdown-menu").mouseleave(function() {
                    $(this).removeClass("show");
                });
            }
        });
        var scroll = $(window).scrollTop();
        if (scroll < 400) {
            $("#product-nav-menu").removeClass("sticky-product-menu");
        } else {
            $("#product-nav-menu").addClass("sticky-product-menu");
        }
        $(window).on('scroll', function() {
            var scroll = $(window).scrollTop();
            if (scroll < 400) {
                $("#product-nav-menu").removeClass("sticky-product-menu");
            } else {
                $("#product-nav-menu").addClass("sticky-product-menu");
            }
        });
    });
</script>


<script>
    // Sync guest cart to database after login
    document.addEventListener('DOMContentLoaded', function() {
        const guestCart = JSON.parse(localStorage.getItem('guestCart')) || [];

        if (guestCart.length > 0 && @json(auth()->check())) {
            $.ajax({
                url: '{{route("front.products-cart.sync")}}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    cartItems: guestCart
                },
                success: function(response) {
                    localStorage.removeItem('guestCart');
                    if (response.success) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "preventDuplicates": true
                        }
                        toastr.success(response.success);
                    }
                    if (response.error) {
                        toastr.error(response.error);
                    }
                },
                error: function() {
                    toastr.error('Somthing Went Wrong..!');
                }
            });
        }
    });
</script>

@yield('js')
