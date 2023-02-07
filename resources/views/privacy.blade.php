<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN HEAD -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Intranet Energy Mega Persada, PT.EMP Intranet, Internal Aplikasi EMP, EMP SIAP">
    <meta name="keywords" content="Internal aplikasi PT.EMP, Energy Mega Persada, EMP SIAP">
    <meta name="author" content="EMP SIAP">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EMP - SIAP</title>
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('app-assets/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/calendars/fullcalendar.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css') }}">
    <!-- END: Vendor CSS-->
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/semi-dark-layout.css') }}">
    <!-- BEGIN: Page CSS-->
    <!-- END: Page CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    @yield('custom_css')
    <!-- END: Custom CSS-->
    <style>
        .gold {
            color: #fdc053 !important;
        }

        .emp-color {
            color: #57bc50 !important;
        }

        .shadow-siap {
            color: #333333 !important;
        }

        /* version mobile */
        @media (max-width: 767px) {
            .brand-logo {
                /* background-color:rgb(40, 35, 35) !important; */
                padding: 2%;
                margin-top: -5% !important;
                display: flex !important;
                justify-content: center !important;
                align-items: center !important;
                border-radius: 7px;
                padding-left: 0 !important;
            }

            .card-title {
                display: flex !important;
                justify-content: center !important;
                align-items: center !important;
                text-align: center !important;
            }
        }
    </style>
</head>
<!-- END: Head-->
<!-- BEGIN BODY -->

<body class="horizontal-layout horizontal-menu blank-page navbar-floating footer-static  " data-open="hover"
    data-menu="horizontal-menu" data-col="blank-page">
    <!-- BEGIN: Content-->
    <div class="blank-page" data-open="hover" data-menu="horizontal-menu" data-col="blank-page">
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content">
                <div class="content-body">
                    <div class="auth" style="overflow:hidden !important;">
                        <div class="auth row m-0" style="overflow:hidden !important;">
                            <div class="col-lg-8 align-items-center p-1">
                                <a class="brand-logo center mb-2" href="#">
                                    <img src="{{ asset('app-assets/images/logo/logo.png') }}" style="max-width:150px;" />
                                </a>
                                <div class="w-100">
                                    <div class="card">
                                        <div class="card-body shadow-siap">
                                            @if(!empty($policy))
                                                <p style="text-align: justify !important;">
                                                    {!! $policy->content !!}
                                                </p>
                                            @else
                                                <div class="alert alert-danger" role="alert">
                                                    <h4 class="alert-heading">Terjadi Kesalahan!</h4>
                                                    <p>Halaman yang anda cari tidak ditemukan.</p>
                                                    <hr>
                                                    <p class="mb-0">Silahkan kembali ke halaman sebelumnya.</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Left Text-->
                            <!-- Login-->
                            <div class="col-lg-4 align-items-center px-2 p-lg-5">
                                <div class="col-12 col-sm-8 col-md-6 col-lg-12 bg-white p-2">
                                    <h4 class="card-title mb-1 text-warning">
                                        <a href="/login?extend={{ $_GET['extend'] }}">
                                            Back To Sign In Page <i data-feather="lock"></i>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                            <!-- /Login-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Content-->
    </div>
    <!-- end content -->
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.js') }}"></script>
    <!-- END: Theme JS-->
    @yield('page-js')

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</body>

</html>
