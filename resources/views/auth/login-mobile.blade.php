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
                                            <input type="text" name="_expotoken" id="expotoken" value="ExponentPushToken[EmVt8LLhAhk2QRyZq1Qno0]" />
                                            <input type="text" name="extend" id="extend" value="<?php echo isset($_GET['extend']) ? $_GET['extend'] : env('APP_DOMAIN'); ?>" />
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
                                    {{-- <p class="text-center mt-2" v-if="hide"><span>Versi Mobile Silahkan Download & Install Disini</span></p>
                   <div class="divider my-2" v-if="hide">
                     <div class="divider-text">Mobile</div>
                   </div>
                   <div class="auth-footer-btn d-flex justify-content-center" v-if="hide">
                       <a class="btn btn-success" href="#"><i data-feather="smartphone"></i> Android</a>
                       <a class="btn btn-twitter white" href="#"><i data-feather="smartphone"></i> IOS</a>
                   </div> --}}
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
        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }
        $('form').on('submit', function(e) {
            $("#loading-login").show();
            $("#submit").hide('fadeOut');
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Access-Control-Allow-Origin': '*',
                    'Access-Control-Allow-Methods': 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
                    'Access-Control-Allow-Headers': 'Origin, Content-Type, X-Auth-Token',
                    'Access-Control-Allow-Credentials': 'true',
                    'Access-Control-Max-Age': '86400',
                    'Access-Control-Allow-Headers': 'Content-Type, Authorization, X-Requested-With'
                }
            });
            $.ajax({
                type: "POST",
                url: 'login',
                dataType: 'json',
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                // },
                data: $("#userLogin").serialize(),
                success: function(msg) {
                    //success
                    if (typeof msg.name == 'undefined') {
                        $("#loading-login").hide();
                        $("#submit").show('fadeIn');
                        $("#error").show();
                        $("#message-error").html('Periksa Kembali Akun Anda!');
                        return;
                    }
                    toastr['success'](
                        'Akun berhasil login!',
                        '👋 Selamat Datang ' + msg.name, {
                            closeButton: true,
                            tapToDismiss: false
                        }
                    );
                    if(msg.data.status == "success"){
                        var extendUrl = $("#extend").val();
                        if(extendUrl !== ""){
                            if(extendUrl.indexOf("extend") > -1){
                                var url = extendUrl.split("extend=")[1];
                                //remove %2F, %3A, %3F, %3D, %26
                                url = url.replace(/%2F/g, "/");
                                url = url.replace(/%3A/g, ":");
                                url = url.replace(/%3F/g, "?");
                                url = url.replace(/%3D/g, "=");
                                url = url.replace(/%26/g, "&");
                                window.location.href = url;
                            }else{
                                window.location.href = extendUrl;
                            }
                        }else{
                            window.location.href = '/dashboard'
                        }
                    }
                },
                error: function(msg) {
                    //errror csrf then reload page
                    if (msg.status == 419 || msg.responseJSON.message == 'CSRF token mismatch.') {
                        toastr['error'](
                            'Session sudah habis, reload page!',
                            'Silahkan coba lagi', {
                                closeButton: true,
                                tapToDismiss: false
                            }
                        );
                        setTimeout(function() {
                            window.location.href = '/login'
                        }, 400);
                    }
                    $("#error").show()
                    var notifError = msg.responseJSON.message;
                    if (notifError == 'Undefined variable: person_array') {
                        notifError = 'Akun tidak terdaftar di Active Directory!';
                    }
                    $("#message-error").html(notifError);
                    $("#loading-login").hide();
                    $("#submit").show('fadeOut');
                }
            });

        });

        //check if user already login
        $(document).ready(function() {
            setInterval(function() {
                checkLogin();
            }, 1000);
        });
        function checkLogin(){
            var token = $("#expotoken").val();
                console.log(token)
                if(token !== null){
                    $.ajax({
                        type: "GET",
                        url: 'login-mobile/check-user-loggedin?token='+token,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Access-Control-Allow-Origin': '*',
                            'Access-Control-Allow-Methods': 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
                            'Access-Control-Allow-Headers': 'Origin, Content-Type, X-Auth-Token',
                            'Access-Control-Allow-Credentials': 'true',
                            'Access-Control-Max-Age': '86400',
                            'Access-Control-Allow-Headers': 'Content-Type, Authorization, X-Requested-With'
                        },
                        success: function(msg) {
                            //success
                            if (msg.status == 'success') {
                                var extendUrl = $("#extend").val();
                                if(extendUrl !== ""){
                                    if(extendUrl.indexOf("extend") > -1){
                                        var url = extendUrl.split("extend=")[1];
                                        //remove %2F, %3A, %3F, %3D, %26
                                        url = url.replace(/%2F/g, "/");
                                        url = url.replace(/%3A/g, ":");
                                        url = url.replace(/%3F/g, "?");
                                        url = url.replace(/%3D/g, "=");
                                        url = url.replace(/%26/g, "&");
                                        window.location.href = url;
                                    }else{
                                        window.location.href = extendUrl;
                                    }
                                }else{
                                    window.location.href = '/dashboard'
                                }
                            }else{
                                window.location.href = '/login-mobile?extend='+extendUrl;
                            }
                        },
                        error: function(msg) {
                            //errror csrf then reload page
                            if (msg.status == 419 || msg.responseJSON.message == 'CSRF token mismatch.') {
                                toastr['error'](
                                    'Session sudah habis, reload page!',
                                    'Silahkan coba lagi', {
                                        closeButton: true,
                                        tapToDismiss: false
                                    }
                                );
                                setTimeout(function() {
                                    window.location.href = '/login'
                                }, 400);
                            }
                        }
                    });
                }
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
    </script>
</body>

</html>
