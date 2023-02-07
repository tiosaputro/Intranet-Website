@extends('layout_web.template')
<!-- BEGIN: Content-->
@section('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/page-profile.css') }}">
{{-- <link rel="stylesheet" type="text/css" href="https://unpkg.com/xzoom/dist/xzoom.css" media="all" />
<link rel="stylesheet" type="text/css" href="https://payalord.github.io/xZoom/examples/fancybox/source/jquery.fancybox.css" media="all" /> --}}
<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"
/>
@endsection
@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Organization Structure</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Organization Structure
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
                        <div class="card profile-header mb-2">
                            <!-- profile cover photo -->
                            <!--/ profile cover photo -->
                            {{-- <img class="xzoom4" id="xzoom-fancy" src="{{ asset('file-manager/structure-emp.png') }}" xoriginal="{{ asset('file-manager/structure-emp.png') }}" /> --}}
                            @if(empty($visimisi))
                            <a data-fancybox="gallery" data-src="{{ asset('file-manager/structure-emp.png') }}">
                                <img src="{{ asset('file-manager/structure-emp.png') }}" class="rounded card-img-top" data-caption="Structure Organization" style="object-fit: cover; max-width:80%;" />
                            </a>
                            @else
                            <a data-fancybox="gallery" data-src="{{ asset(str_replace('public','storage',$foto)) }}">
                                <img src="{{ asset(str_replace('public','storage',$foto)) }}" class="rounded card-img-top" data-caption="Structure Organization" style="object-fit: cover; max-width:100%;" />
                            </a>
                            @endif
                        </div>
                    </div>
                    @if(!empty($visimisi) && isset($visimisi->content))
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                {!! $visimisi->content !!}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
        </div> <!-- end content body -->
    </div> <!-- content wraper -->
</div> <!-- app content -->
@endsection
@push('page-js')

{{-- <script type="text/javascript" src="https://payalord.github.io/xZoom/examples/hammer.js/1.0.5/jquery.hammer.min.js"></script> --}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> --}}
{{-- <script type="text/javascript" src="https://unpkg.com/xzoom/dist/xzoom.min.js"></script>
<script type="text/javascript" src="https://payalord.github.io/xZoom/examples/fancybox/source/jquery.fancybox.js"></script>

<script type="text/javascript" src="https://payalord.github.io/xZoom/examples/js/setup.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script>
      // Customization example
      Fancybox.bind('[data-fancybox="gallery"]', {
        infinite: false
      });
    </script>
@endpush
