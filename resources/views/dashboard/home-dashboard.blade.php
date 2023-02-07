@extends('layout_web.template')
<!-- BEGIN: Content-->
@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Start -->
                <div class="row match-height">
                    @include('dashboard.slider')
                </div>
                <div class="row match-height">
                    @include('dashboard.media-highlight')
                    @include('dashboard.company-campaign')
                    @include('dashboard.info-emp')
                </div>
                <div class="row match-height">
                    @include('dashboard.event')
                    @include('dashboard.knowledge-sharing')
                    @include('dashboard.gallery')
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('page-js')
<script src="{{ asset('src/js/scripts/alpha-bootstrap.min.js') }}"></script>
@endpush
