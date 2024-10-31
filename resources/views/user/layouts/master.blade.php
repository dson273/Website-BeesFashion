<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BeesFashion">
    <meta name="keywords" content="BeesFashion">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <title>BeesFashion - Online Fashion Store </title>
    <!-- Favicon icon-->
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <!-- Google Font Outfit-->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/fontawesome.css') }}">
    <!-- Iconsax icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/iconsax.css') }}">
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" id="rtl-link" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/swiper-slider/swiper-bundle.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/toastify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <script defer src="{{ asset('assets/css/landing_page.js') }}"></script>
    <script defer src="{{ asset('assets/css/style.js') }}"></script>
    <link href="{{ asset('assets/css/landing_page.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Notification library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @yield('css-libs')
</head>

<body>
    <!-- Header -->
    @include('user.layouts.header')
    <!-- End header -->

    <!-- content -->
    @yield('content')
    <!-- End content -->

    <!-- Footer -->
    @include('user.layouts.footer')
    <!-- End footer -->

    <!-- Bootstrap js-->
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script><!-- iconsax js -->
    <script src="{{ asset('assets/js/iconsax.js') }}"></script><!-- cursor js-->
    <script src="{{ asset('assets/js/stats.min.js') }}"></script>
    <script src="{{ asset('assets/js/cursor.js') }}"></script>
    <script src="{{ asset('assets/js/swiper-slider/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper-slider/swiper-custom.js') }}"></script>
    <script src="{{ asset('assets/js/countdown.js') }}"></script>
    <script src="{{ asset('assets/js/newsletter.js') }}"></script>
    <script src="{{ asset('assets/js/skeleton-loader.js') }}"></script><!-- touchspin-->
    <script src="{{ asset('assets/js/touchspin.js') }}"></script><!-- cookie js-->
    <script src="{{ asset('assets/js/cookie.js') }}"></script><!-- tost js -->
    <script src="{{ asset('assets/js/toastify.js') }}"></script>
    <script src="{{ asset('assets/js/theme-setting.js') }}"></script><!-- Theme js-->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000", // Thời gian hiển thị
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    </script>
    @yield('script-libs')
</body>

</html>
