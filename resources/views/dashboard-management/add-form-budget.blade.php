@extends('layout_web.template')
<!-- BEGIN: Content-->
@section('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/pickers/form-pickadate.css') }}">
    <style>
        body {
            zoom: 95%;
        }
    </style>
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Daily Budget</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('backend/dashboard') }}">Dashboard
                                            Management</a>
                                    </li>
                                    <li class="breadcrumb-item active">Form Add Budget
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Start -->
                <div class="row match-height">
                    <!-- Filter Data -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header border-top-primary p-1 border-3">
                                <h4 class="card-title"><i data-feather="filter"></i> Filter Data Budget</h4>
                                <h5 class="text-end">
                                    <a href="{{ url('backend/dashboard/add-budget') }}" class="btn btn-sm btn-success"><i
                                            data-feather="plus-circle"></i> Add Daily Budget</a>
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('backend/dashboard/filter-budget') }}" class="form-group"
                                    method="GET">
                                    <div class="row mt-2">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="">Tanggal Budget</label>
                                                <input type="text" id="pd-default"
                                                    class="form-control pickadate-months-year" name="date"
                                                    placeholder="{{ date('Y-m-d') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="bu">Bussiness Unit</label>
                                                <select name="bu" id="business_unit" class="form-control select2">
                                                    <option value="">All Business Unit</option>
                                                    @foreach ($bu as $rowBu)
                                                        <option value="{{ $rowBu->id }}">{{ $rowBu->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-md btn-primary form-control mt-2 text-sm">
                                                <b class="small">Filter</b>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-success p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="truck"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{ $budgetMboepd }}</h2>
                                <p class="card-text">Total Budget MBOEPD</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-danger p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="activity"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{ $budgetWi }}</h2>
                                <p class="card-text">Total Budget WI MBOEPD</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            @include('layout_web.notif-alert')
                            <form action="{{ url('backend/dashboard/save-budget') }}" method="POST">
                                <div class="card-header border-top-success p-1 border-3">
                                    <h4 class="card-title">Form Daily Budget</h4>
                                    @if (!$inputDaily)
                                        <a href="{{ url('backend/dashboard/add') }}" class="btn btn-sm btn-success"><i
                                                data-feather="plus-circle"></i> Add Production
                                            Daily</a>
                                    @else
                                        <a href="{{ url('backend/dashboard/filter?date=' . date('Y-m-d') . '&bu=') }}"
                                            class="btn btn-sm btn-primary"><i data-feather="eye"></i> Show Production</a>
                                    @endif
                                    <h4 class="text-end">{{ \Carbon\Carbon::now()->format('d M Y h:i:s') }}</h4>
                                </div>
                                <div class="card-body">

                                    <div class="table-responsive-fixed mt-2 fs-6">
                                        <table class="table table-striped text-sm">
                                            {{ csrf_field() }}
                                            <thead>
                                                <tr>
                                                    <th rowspan="1" class="align-middle headcol">PSC</th>
                                                    <th colspan="12" class="text-center bg-dark text-white">
                                                        Budget Daily
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th class="bg-white headcol">EMP Operated</th>
                                                    <th class="bg-white text-center mb-right">
                                                        <b style="text-align:right !important;">Oil BOPD</b>
                                                    </th>
                                                    <th class="bg-white text-center">Gas MMSCFD</th>
                                                    <th class="bg-success text-white text-center ">Total MBOEPD</th>
                                                    <th class="bg-success text-white text-center">WI MBOEPD</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dummy['dataProduction'] as $row)
                                                    <tr>
                                                        <th class="headcol">
                                                            {{ $row['name'] }}
                                                            <input type="hidden" value="{{ $row['id'] }}"
                                                                name="bu_id[]">
                                                        </th>
                                                        <td class="text-end fw-bold">
                                                            <input type="number" step="any" name="OIL_BOPD[]"
                                                                value="{{ $row['oil_bopd'] }}" class="form-control"
                                                                required />
                                                        </td>
                                                        <td class="text-end fw-bold">
                                                            <input type="number" step="any" name="GAS_MMSCFD[]"
                                                                value="{{ $row['gas_mmscfd'] }}" class="form-control"
                                                                required />
                                                        </td>
                                                        <td class="text-end fw-bold">
                                                            <input type="number" step="any" name="TOTAL_MBOEPD[]"
                                                                value="{{ $row['total_mboepd'] }}" class="form-control"
                                                                required />
                                                        </td>
                                                        <td class="text-end fw-bold text-white">
                                                            <input type="number" step="any" name="WI_MBOEPD[]"
                                                                value="{{ $row['wi_mboepd'] }}" class="form-control"
                                                                required />
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer mb-3">
                                    @if (in_array('update', $permission) && in_array('create', $permission))
                                        <div class="" style="float: right;">
                                            <button type="submit" class="btn btn-primary btn-large">
                                                <i data-feather="save"></i>
                                                Save Budget
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div> <!-- End Card -->
                    </div> <!-- End Col -->
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
@push('page-js')
    <script>
        var path = `{{ url('backend/dashboard') }}`;
    </script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/legacy.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>

    <script src="{{ asset('app-assets/tags-input/js/jquery.amsify.suggestags.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
@endpush
