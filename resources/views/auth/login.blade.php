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
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/authentication.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/css/plugins/extensions/ext-component-toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">
    <!-- END: Page CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style_slider.css') }}">
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
            color: #333333;
            background: #FFFFFF;
            text-shadow: 2px 2px 0px #FFFFFF, 5px 4px 0px rgba(0, 0, 0, 0.15);
            color: #333333;
            background: #FFFFFF;
        }
        .box-otp{
            text-align: center;
            width: 20%;
            font-size: 15pt;
            display: flex !important;
            justify-content: center !important;
            align-items: center;
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
            .box-otp{
                color:#333333;
                font-size: 9pt;
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
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="auth-wrapper auth-cover" style="overflow:hidden !important;">
                        <div class="auth-inner row m-0" style="overflow:hidden !important;">
                            <!-- Brand logo-->
                            <a class="brand-logo" href="#">
                                <img src="{{ asset('app-assets/images/logo/logo.png') }}" style="max-width:180px;" />
                            </a>
                            <!-- /Brand logo-->
                            <!-- Left Text-->
                            <!-- background-repeat:no-repeat; background-size:cover; background-image: url('app-assets/images/pages/login/emp.jpg'); -->
                            <div class="d-none d-lg-flex col-lg-8 align-items-center p-5" style="">
                                <div class="w-100 d-lg-flex align-items-center justify-content-center">
                                    <div id="slideshow">
                                        @if (empty($banner))
                                            <img src="{{ asset('app-assets/images/pages/login/emp.jpg') }}"
                                                style="object-fit:cover; background-repeat:no-repeat; background-size:cover; width:80%;"
                                                class="active" />
                                            <img src="{{ asset('file-manager/vision-emp.jpg') }}"
                                                style="object-fit:cover; background-repeat:no-repeat; background-size:cover; width:80%;" />
                                        @else
                                            @foreach ($banner as $banners)
                                                @if (!empty($banners->file_path))
                                                    @foreach (json_decode($banners->file_path) as $b)
                                                        <img src="{{ asset(str_replace('public', 'storage', $b)) }}"
                                                            style="object-fit:cover; background-repeat:no-repeat; background-size:cover; width:80%;" />
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- /Left Text-->
                            <!-- Login-->
                            <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                                <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                    <h2 class="card-title fw-bold mb-1">Selamat Datang di Intranet! 👋</h2>
                                    <p class="card-text mb-2">Silahkan Sign-in menggunakan akun anda</p>
                                    <div class="alert alert-danger p-2" id="error"
                                        style="display:none; background:#ed3839 !important;">
                                        <p id="message-error"></p>
                                    </div>
                                    <form class="auth-login-form mt-2" action="#" method="POST"
                                        autocomplete="off" id="userLogin">
                                        <div class="mb-1">
                                            <label class="form-label" for="login-email">Username atau Email</label>
                                            <input class="form-control" id="login-email" type="text"
                                                name="email" placeholder="my.name / my.name@emp-one.com"
                                                aria-describedby="email" tabindex="1" autocomplete="off"
                                                required />
                                            <input type="hidden" name="_expotoken" id="expotoken" />
                                            <input type="hidden" name="extend" id="extend" value="<?php echo $_GET['extend']; ?>" />
                                            <!-- <span class="text-danger"><strong>error email</strong></span> -->
                                        </div>
                                        <div class="mb-1">
                                            <div class="d-flex justify-content-between">
                                                <!-- <label class="form-label" for="password">Password</label><a href="#"><small>Lupa Password ?</small></a> -->
                                            </div>
                                            <div class="input-group input-group-merge form-password-toggle">
                                                <input class="form-control form-control-merge" id="login-password"
                                                    type="password" name="password" placeholder="············"
                                                    aria-describedby="login-password" tabindex="2"
                                                    autocomplete="off" value="" required />
                                                <span class="input-group-text cursor-pointer"><i
                                                        data-feather="eye"></i></span>
                                            </div>
                                            <!-- <span class="text-danger mt-2"><b>error password </b></span> -->
                                        </div>
                                        <div class="mb-1">
                                            <div class="form-check">
                                                <input class="form-check-input" id="remember-me" type="checkbox"
                                                    tabindex="3" checked />
                                                <label class="form-check-label" for="remember-me">Remember Me</label>
                                            </div>
                                        </div>
                                        <div id="tes"></div>
                                        <img src="{{ asset('app-assets/loading.gif') }}" width="80"
                                            id="loading-login" style="display:none;">
                                        <button class="btn btn-primary w-100" type="submit" name="submit"
                                            id="submit" tabindex="4">Sign in</button>
                                    </form>
                                    <p class="text-center mt-2"><span>Versi Mobile Silahkan Download & Install Disini</span></p>
                                    <div class="divider my-2">
                                        <div class="divider-text">
                                            <h5><a href="/privacy?extend={{ $_GET['extend'] }}">Privacy & Policy</a></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Login-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Content-->
        <!-- Popup Modal Pilih Platform -->
        <div class="modal fade text-left" id="modal-pilih" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
            aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-lg modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel1">Send OTP Via</h3>
                        <!-- link back right -->
                        <a href="{{ url('/login?extend='.$_GET['extend']) }}" onclick="resetTimer()" class="close" data-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i> Close
                        </a>
                    </div>
                    <div class="modal-body p-2">
                        <div class="d-flex justify-content-center">
                            <div class="shadow p-2">
                            <div class="text-primary fw-bold">Mengirimkan Kode OTP melalui : </div>
                            <hr/>
                            <div class="btn btn-sm btn-danger platform" data-value="email" id="otp-email" style="cursor: pointer;">
                                <i data-feather="inbox"></i> Email
                            </div>
                            <div class="btn btn-sm btn-success platform" data-value="whatsapp" id="otp-wa" style="cursor: pointer;">
                                <i data-feather="inbox"></i> Whatsapp
                            </div>
                            </div>
                        </div>

                        <div id="show-email" class="mt-2" style="display: none;">
                            <div class="form-group">
                                <label for="email" class="fw-bold">Email</label>
                                <input type="email" class="form-control" id="email-user" name="email-user"
                                    placeholder="Masukan Email">
                            </div>
                            <div class="form-group mt-2">
                                <div class="btn btn-sm btn-primary" id="send-otp-email" style="cursor: pointer;">
                                    <i data-feather="send"></i> Kirim OTP
                                </div>
                            </div>
                        </div>
                        <div id="show-wa" class="mt-2" style="display: none;">
                            <div class="form-group">
                                <label for="wa" class="fw-bold">Nomor Whatsapp</label>
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input type="number" class="form-control phone-number-mask" onkeypress="filterNolFirst()" maxlength="12" placeholder="" id="phone-number" />
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <div class="btn btn-sm btn-primary" id="send-otp-wa" style="cursor: pointer;">
                                    <i data-feather="send"></i> Kirim OTP
                                </div>
                            </div>
                        </div>
                        <div class="text-center loading-modal" style="display: none;">
                            <img src="{{ asset('app-assets/loading.gif') }}" width="80">
                        </div>
                    </div> <!-- end modal body -->
                </div>
            </div>
        </div>
        <!-- Popup Modal OTP -->
        <div class="modal fade text-left" id="modal-otp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2"
            aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-lg modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="header-whatsapp" style="display: none;">Masukan Kode OTP yang dikirim ke Nomor : <span id="nomor-whatsapp" class="fw-bold text-primary"></span> </h4>
                        <h4 class="modal-title" id="header-email" style="display: none;">Masukan Kode OTP yang dikirim ke Email : <span id="email-view" class="fw-bold text-primary"></span> </h4>
                        <a href="{{ url('/login?extend='.$_GET['extend']) }}" class="close" onclick="resetTimer()" data-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i> Close
                        </a>
                    </div>
                    <div class="modal-body p-1">
                        <div id="loading-otp" class="text-center" style="display: none;">
                            <img src="{{ asset('app-assets/loading.gif') }}" width="80">
                        </div>
                        <!-- Template OTP 6 number -->
                        <div id="input_otp" class="mt-2">
                            <form action="{{ url('/otp-verification') }}">
                                <div class="otp">
                                    <div class="form-group ">
                                        <div class="input-container d-flex flex-row justify-content-center mt-2">
                                        @for($i = 1; $i <= 6; $i++)
                                            <input type="number" max="9" min="0" maxlength="1" class="form-control box-otp cursor_otp shadow rounded {{ $i == 6 ? 'last' : ''}} {{ $i == 1 ? 'first' : ''}}" id="otp_{{ $i }}" name="otp[]" required /> &nbsp; &nbsp;
                                        @endfor
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="text-center mt-2">
                                <div id="countdown-otp" style="font-size:4vh; font-weight:bold; text-shadow: -1px 2px 2px rgba(0,0,0,0.6);"></div>
                            </div>
                            <div class="text-center mt-2">
                                <div class="alert alert-danger p-1" id="timeover" style="display: none;">
                                    <p class="mb-0 fw-bold text-black" style="font-size: 2vh;"><i data-feather="clock"></i> Waktu Kode OTP anda sudah habis, silahkan <b>Resend OTP</b> untuk mendapatkan kode baru.</p>
                                </div>
                                <div class="btn btn-danger btn-sm" id="reset_otp" style="cursor: pointer;">Reset OTP</div>
                                <div class="btn btn-primary btn-sm" onclick="resendOtp()" id="resend_otp" style="display: none; cursor:pointer;">Resend OTP</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end content -->
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->
    <script src="{{ asset('app-assets/js/scripts/extensions/ext-component-sweet-alerts.js') }}"></script>
    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.js') }}"></script>
    <!-- END: Theme JS-->
    @yield('page-js')

    <script>
        var tokenCsrf = `{{ csrf_token() }}`;
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })

        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }
    </script>

    <script type="text/javascript">
        function slideSwitch() {
            var $active = $('#slideshow IMG.active');

            if ($active.length == 0) $active = $('#slideshow IMG:last');

            // use this to pull the images in the order they appear in the markup
            var $next = $active.next().length ? $active.next() :
                $('#slideshow IMG:first');

            // uncomment the 3 lines below to pull the images in random order

            // var $sibs  = $active.siblings();
            // var rndNum = Math.floor(Math.random() * $sibs.length );
            // var $next  = $( $sibs[ rndNum ] );


            $active.addClass('last-active');

            $next.css({
                    opacity: 0.0
                })
                .addClass('active')
                .animate({
                    opacity: 1.0
                }, 1000, function() {
                    $active.removeClass('active last-active');
                });
        }

        $(function() {
            setInterval("slideSwitch()", 5000);
        });
        var timeOtpExpired = `{{ $otp == null ? 3 : $otp['expired_time'] }}`
    </script>

    <script src="{{ asset('js/pages/signin.js?v='.date('Ymdhis')) }}"></script>

</body>

</html>
