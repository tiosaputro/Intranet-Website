<!-- BEGIN: Content-->
@extends('layout_web.template')
@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">My Profile</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active"> Profile
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-pills mb-2">
                            <!-- account -->
                            <li class="nav-item">
                                <a class="nav-link active" href="#">
                                    <i data-feather="user-check" class="font-medium-3 me-50"></i>
                                    <span class="fw-bold">Account</span>
                                </a>
                            </li>
                        </ul>

                        <!-- profile -->
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Profile Details</h4>
                            </div>
                            <div class="card-body py-2 my-25">
                                <!-- header section -->
                                @include('layout_web.notif-alert')
                            <form class="form" action="{{ url('profile-upload') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="d-flex">
                                    <a href="#" class="me-25">
                                        @if (empty($photo))
                                            <img src="{{ asset('app-assets/image_not_found.gif') }}"
                                                id="account-upload-img" class="uploadedAvatar rounded me-50"
                                                alt="profile image" height="100" width="100" />
                                        @else
                                            <img src="{{ asset($photo) }}" id="account-upload-img"
                                                class="uploadedAvatar rounded me-50" alt="" height="100" width="100" />
                                        @endif
                                    </a>
                                    <!-- upload and reset button -->
                                    <div class="d-flex align-items-end mt-75 ms-1">
                                        <p class="mt-2">Allowed file types: png, jpg, jpeg.</p>
                                            <label for="account-upload" class="btn btn-sm btn-primary mb-75 me-75">Upload</label>
                                            <input type="file" name="file" id="account-upload" hidden accept="image/*" />
                                            <button type="button" id="account-reset"
                                                class="btn btn-sm btn-outline-secondary mb-75">Reset</button>
                                            <button type="submit" class="btn btn-sm btn-success mb-75 m1-2">Save</button>
                                    </div>
                                    <!--/ upload and reset button -->
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mt-2">
                                            <label for="wa" class="fw-bold">Whatsapp Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text">+62</span>
                                                <input type="number" name="no_wa" value="{{ $nomor_wa }}" class="form-control phone-number-mask" onkeypress="filterNolFirst()" maxlength="12" placeholder="" id="phone-number" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mt-2">
                                            <label for="email" class="fw-bold">Email Confirmation</label>
                                            <input type="email" name="email" class="form-control" id="email-user" name="email_user"
                                                placeholder="Masukan Email" value="{{ $email }}">
                                        </div>
                                    </div>
                                </div>
                            </form>

                                <!--/ header section -->

                                <!-- form -->
                                <form class="validate-form mt-2 pt-50">
                                    <div class="row">
                                        @foreach ($label as $row => $value)
                                            @php
                                                $var = isset($profileDetail[$value]) ? $profileDetail[$value] : '';
                                            @endphp
                                            @if ($value == 'extensionattribute12')
                                                <div class="col-12 col-sm-4 mb-1">
                                                    <label class="form-label"
                                                        for="accountFirstName">{{ $row }}</label>
                                                    <textarea readonly class="form-control" id="{{ $value }}"
                                                        name="{{ $var }}">{{ str_replace('"','',$var) }}</textarea>
                                                </div>
                                            @else
                                                <div class="col-12 col-sm-4 mb-1">
                                                    <label class="form-label"
                                                        for="accountFirstName">{{ $row }}</label>
                                                    <input type="text" class="form-control" id="{{ $value }}"
                                                        name="{{ $var }}" value="{{ str_replace('"','',$var) }}" readonly />
                                                </div>
                                            @endif
                                        @endforeach
                                        <div class="col-12">

                                        </div>
                                    </div>
                                </form>
                                <!--/ form -->
                            </div>
                        </div>
                        <div class="card" style="display: none;">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Delete Account</h4>
                            </div>
                            <div class="card-body py-2 my-25">
                                <div class="alert alert-warning">
                                    <h4 class="alert-heading">Are you sure you want to delete your account?</h4>
                                    <div class="alert-body fw-normal">
                                        Once you delete your account, there is no going back. Please be certain.
                                    </div>
                                </div>

                                <form id="formAccountDeactivation" class="validate-form" onsubmit="return false">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="accountActivation"
                                            id="accountActivation" data-msg="Please confirm you want to delete account" />
                                        <label class="form-check-label font-small-3" for="accountActivation">
                                            I confirm my account deactivation
                                        </label>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-danger deactivate-account mt-1">Deactivate
                                            Account</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--/ profile -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
@push('page-js')
    <script>
        function filterNolFirst(){
            var value = $("#phone-number").val();
            if(value.length == 1){
                if(value == 0){
                    $("#phone-number").val("");
                }
            }
        }
    </script>
    <script src="{{ asset('app-assets/vendors/js/forms/cleave/cleave.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/pages/page-account-settings-account.js') }}"></script>
@endpush
