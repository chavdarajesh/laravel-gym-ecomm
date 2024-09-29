<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('assets/user/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/user/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/user/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/user/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

<script src="{{ asset('assets/user/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('assets/user/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/user/js/main.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('assets/user/js/dashboards-analytics.js') }}"></script>

<!-- Place this tag in your head or just before your close body tag. -->

<script src="{{ asset('custom-assets/default/user/js/toastr.min.js') }}"></script>
<script src="{{ asset('custom-assets/default/user/js/select2.min.js') }}"></script>

<script>
    @if (Session::has('message'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "preventDuplicates": true
        }
        toastr.success("{{ session('message') }}");
    @endif

    @if (Session::has('error'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "preventDuplicates": true
        }
        toastr.error("{{ session('error') }}");
    @endif

    @if (Session::has('info'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "preventDuplicates": true
        }
        toastr.info("{{ session('info') }}");
    @endif

    @if (Session::has('warning'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "preventDuplicates": true
        }
        toastr.warning("{{ session('warning') }}");
    @endif
</script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<script>
    $(window).on('load', function () {
      $('#preloader-active').delay(450).fadeOut('slow');
      $('body').delay(450).css({
        'overflow': 'visible'
      });
    });
</script>
@yield('js')
