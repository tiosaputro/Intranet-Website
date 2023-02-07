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
                            <h2 class="content-header-title float-start mb-0">Daily Production</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('backend/dashboard') }}">Dashboard
                                            Management</a>
                                    </li>
                                    <li class="breadcrumb-item active">Form Add
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
                                <h4 class="card-title"><i data-feather="filter"></i> Filter Data Production</h4>
                                <h5 class="text-end">
                                    <a href="{{ url('backend/dashboard/add') }}" class="btn btn-sm btn-success"><i
                                            data-feather="plus-circle"></i> Add Daily</a>
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('backend/dashboard/filter') }}" class="form-group" method="GET">
                                    <div class="row mt-2">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="">Tanggal Production</label>
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
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="users"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{ $bu->count() }}</h2>
                                <p class="card-text">Business Unit Registered</p>
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
                                <h2 class="fw-bolder">{{ $totalGross }}</h2>
                                <p class="card-text">Total Gross MBOEPD</p>
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
                                <h2 class="fw-bolder">{{ $totalWi }}</h2>
                                <p class="card-text">Total WI MBOEPD</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            @include('layout_web.notif-alert')
                            <form action="{{ url('backend/dashboard/save-daily') }}" method="POST">
                                <div class="card-header border-top-success p-1 border-3">
                                    <h4 class="card-title">Form Daily Production</h4>
                                    @if ($inputBudget)
                                        <a href="{{ url('backend/dashboard/add-budget') }}"
                                            class="btn btn-sm btn-success"><i data-feather="plus-circle"></i> Add Budget
                                            Daily</a>
                                    @else
                                        <a href="{{ url('backend/dashboard/filter-budget?date=' . date('Y-m-d') . '&bu=') }}"
                                            class="btn btn-sm btn-primary"><i data-feather="eye"></i> Show Budget Daily</a>
                                    @endif
                                    <h4 class="text-end">{{ \Carbon\Carbon::now()->format('d M Y h:i:s') }}</h4>
                                </div>
                                <div class="card-body">

                                    <div class="table-responsive-fixed mt-2 fs-6">
                                        <table class="table table-striped text-sm">
                                            {{ csrf_field() }}
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="align-middle headcol">PSC</th>
                                                    <th colspan="12" class="text-center bg-dark text-white">Actual
                                                        Delivery</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="4" class="bg-primary text-white text-center">GROS
                                                    </th>
                                                    <th colspan="4" class="bg-warning text-white text-center">WI</th>
                                                </tr>
                                                <tr>
                                                    <th class="bg-white headcol">EMP Operated</th>
                                                    <th class="bg-white text-center mb-right"><b
                                                            style="text-align:right !important;">Oil BOPD</b></th>
                                                    <th class="bg-white text-center">Sale Gas MMSCFD</th>
                                                    <th class="bg-white text-center">Gross Gas BOEPD</th>
                                                    <th class="bg-white text-center">Total MBOEPD</th>
                                                    <th class="bg-white text-center">Oil BOPD</th>
                                                    <th class="bg-white text-center">Sale Gas MMSCFD</th>
                                                    <th class="bg-white text-center">WI Gas BOEPD</th>
                                                    <th class="bg-white text-center">Total MBOEPD</th>
                                                    <th class="bg-success text-white">WI MBOEPD</th>
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
                                                            <input type="number" step="any" name="GROSS_OIL_BOPD[]"
                                                                value="{{ $row['gros_oil'] }}" class="form-control"
                                                                required />
                                                        </td>
                                                        <td class="text-end fw-bold">
                                                            <input type="number" step="any"
                                                                name="GROSS_GAS_MMSCFD[]" value="{{ $row['gros_sale'] }}"
                                                                class="form-control" required />
                                                        </td>
                                                        <td class="text-end fw-bold">
                                                            <input type="number" step="any" name="GROSS_GAS_BOEPD[]"
                                                                value="{{ $row['gros_gas_boepd'] }}" class="form-control"
                                                                required />
                                                        </td>
                                                        <td class="text-end fw-bold">
                                                            <input type="number" step="any"
                                                                name="GROSS_TOTAL_MBOEPD[]"
                                                                value="{{ $row['gros_total'] }}" class="form-control"
                                                                required />
                                                        </td>
                                                        <td class="text-end fw-bold">
                                                            <input type="number" step="any" name="WI_OIL_BOPD[]"
                                                                value="{{ $row['wi_oil'] }}" class="form-control"
                                                                required />
                                                        </td>
                                                        <td class="text-end fw-bold">
                                                            <input type="number" step="any" name="WI_GAS_MMSCFD[]"
                                                                value="{{ $row['wi_sale'] }}" class="form-control"
                                                                required />
                                                        </td>
                                                        <td class="text-end fw-bold">
                                                            <input type="number" step="any" name="WI_GAS_BOEPD[]"
                                                                value="{{ $row['wi_gas_boepd'] }}" class="form-control"
                                                                required />
                                                        </td>
                                                        <td class="text-end fw-bold">
                                                            <input type="number" step="any" name="WI_TOTAL_MBOEPD[]"
                                                                value="{{ $row['wi_total'] }}" class="form-control"
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
                                <div class="card-footer">
                                    @if (in_array('update', $permission) && in_array('create', $permission))
                                        <div class="" style="float: right;">
                                            <button type="submit" class="btn btn-primary btn-large">
                                                <i data-feather="save"></i>
                                                Save Production
                                            </button>
                                        </div>
                                    @endif
                                    <p class="card-text">
                                        <code class="text-danger">*Production gas is using gas sales volume for all
                                            BU</code><br />
                                        <b class="text-small">(*) The quoted budget is using WP&B {{ date('Y') }}
                                            budget</b><br />
                                        <b class="text-small">(**) Waiting data from sengkang for oil production</b>
                                    </p>
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
