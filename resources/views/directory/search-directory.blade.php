@extends('layout_web.template')
@section('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/page-knowledge-base.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/dashboard-ecommerce.css') }}">
@endsection
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            {{-- <h2 class="content-header-title float-start mb-0">INFO EMP</h2> --}}
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Directory EMP
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                    <div class="mb-1 breadcrumb-right">
                        <div class="dropdown">
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Knowledge base Jumbotron -->
                <section id="knowledge-base-search">
                    <div class="row">
                        <div class="col-12">
                            <div class="card knowledge-base-bg text-center" style="background-image: url('{{ asset($fotoBanner)}}'); padding: 0.7rem !important;">
                                <div class="card-body">
                                    <h2 class="fn-color-nav">Directory EMP</h2>
                                    <p class="card-text mb-2">
                                        {{-- <span>Pencarian Semua Tentang : </span><span class="fw-bolder"><i>{{ ($keyword == 'all') ? '' : $keyword }}</i></span> --}}
                                    </p>
                                    <form class="kb-search-input" action="{{ url('directory/search') }}" method="GET">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i data-feather="search"></i></span>
                                            <input type="text" name="q" class="form-control" id="autocomplete" placeholder="Search" value="{{ ($keyword == 'all') ? '' : $keyword }}" />
                                        </div>
                                    {!! (count($result) > 0) ? "<h4 class='text-success mt-2'><i data-feather='check-circle'></i> ". count($result).' Pencarian Ditemukan ! </h4>' : "" !!}
                                </div>

                                <div class="col-md-12">
                                    <h4 class="fn-color-nav">Pilih Pencarian</h4>
                                    <input onclick="changeDirectory('emergency')" class="custom-option-item-check" type="radio" name="directory" id="customOptionsCheckableRadiosWithIcon1" value="emergency" {{ (isset($_GET['directory']) && $_GET['directory'] == 'emergency') ? 'checked' : ''  }} {{ (!isset($_GET['directory'])) ? 'checked' : '' }} />
                                    <label class="custom-option-item text-center p-1" for="customOptionsCheckableRadiosWithIcon1" style="cursor:pointer;">
                                        <i data-feather="alert-triangle" class="font-large-1 mb-75"></i>
                                        <span class="custom-option-item-title h4 d-block">Emergency Call</span>
                                        <small>Cari nomor darurat</small>
                                    </label>

                                    <input onclick="changeDirectory('extension')" class="custom-option-item-check" type="radio" name="directory" id="customOptionsCheckableRadiosWithIcon2" value="extension" {{ (isset($_GET['directory']) && $_GET['directory'] == 'extension') ? 'checked' : ''  }} />
                                    <label class="custom-option-item text-center text-center p-1" for="customOptionsCheckableRadiosWithIcon2" style="cursor:pointer;">
                                        <i data-feather="phone-call" class="font-large-1 mb-75"></i>
                                        <span class="custom-option-item-title h4 d-block">Phone Ext</span>
                                        <small>Cari informasi staff</small>
                                    </label>
                                </div>
                                </form>
                            </div>
                            <!-- end col -->
                        </div>
                    </div>
                </section>
                <!--/ Knowledge base Jumbotron -->
                <div class="row match-height">
                    <div class="col-lg-2 col-12">

                    </div>
                    @if(isset($_GET['directory']) && $_GET['directory'] == 'extension' && count($result) > 0)
                    <!-- Company Table Card -->
                    <div class="col-lg-8 col-12 table-extension-get">
                        <div class="card card-company-table">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Departement</th>
                                                <th>Lantai</th>
                                                <th>Ext</th>
                                                <th>Divison</th>
                                                <th>Location</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($result as $row)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar rounded">
                                                            <div class="avatar-content rounded" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up my-0" title="" data-bs-original-title="{{ str_replace('"',"",$row->name) }}">
                                                                <img src="{{ asset('app-assets/images/portrait/small/avatar-s-9.jpg') }}" alt="" width="50" height="50" />
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bolder">{{ str_replace('"','',$row->name) }}</div>
                                                            <div class="font-small-2 text-muted">{{ str_replace('"','',$row->position) }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar bg-light-primary me-1">
                                                            <div class="avatar-content">
                                                                <i data-feather="monitor" class="font-medium-3"></i>
                                                            </div>
                                                        </div>
                                                        <span>{{ str_replace('"','',$row->departement) }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-nowrap">
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-bolder mb-25">{{ $row->lantai }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $row->ext }}</td>
                                                <td>{{ $row->division }}</td>
                                                <td>{{ $row->location }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Company Table Card -->
                    @endif

                    <div class="col-lg-8 col-12 table-extension" style="display: none;">
                        <div class="card card-company-table">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Departement</th>
                                                <th>Lantai</th>
                                                <th>Ext</th>
                                                <th>Divison</th>
                                                <th>Location</th>
                                            </tr>
                                        </thead>
                                        <tbody id="data-extension">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-12 table-emergency" style="display: none;">
                        <div class="card card-company-table">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Phone</th>
                                                <th>Ket</th>
                                            </tr>
                                        </thead>
                                        <tbody id="data-emergency">
                                        </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(isset($_GET['directory']) && $_GET['directory'] == 'emergency' && count($result) > 0)
                     <!-- Emergency Table Card -->
                     <div class="col-lg-8 col-12 table-emergency-get">
                        <div class="card card-company-table">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Phone</th>
                                                <th>Ket</th>
                                            </tr>
                                        </thead>
                                        <tbody id="data-emergency">
                                            @foreach($result as $row)
                                            <tr class="info">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar bg-light-primary me-1">
                                                            <div class="avatar-content">
                                                                <i data-feather="phone-call" class="font-medium-3"></i>
                                                            </div>
                                                        </div>
                                                        <span>{{ $row->name }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-nowrap">
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-bolder mb-25">{{ $row->phone }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="fw-bolder mb-25">{{ $row->position }}</span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ emergency Table Card -->
                    @endif
                    <div class="col-lg-2 col-12">
                        <img src="{{ asset('app-assets/images/illustration/marketing.svg') }}" class="card-img-top" alt="knowledge-base-image">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('page-js')
    <script>
        var urlPost = `{{ url('directory/api-search') }}`;
    </script>
    <script src="{{ asset('js/pages/directory.js') }}"></script>
@endpush
