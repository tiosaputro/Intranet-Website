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

        .font-table {
            font-size: 0.7em !important;
        }

        .headcol {
            position: absolute;
            left: 0;
            top: auto;
        }

        td,
        th {
            margin: 0;
            white-space: nowrap;
            border-top-width: 0px;
        }

        .table-responsive {
            overflow-x: scroll;
            margin-left: 5em;
            overflow-y: visible;
            padding: 0;
        }
    </style>
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="col-md-4">
                    <!-- Create Filter Form Year -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Filter Data</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('management-weekly') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="text" name="range" id="fp-range"
                                                class="form-control flatpickr-range" value="{{ $filterRange }}"
                                                placeholder="Select Date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-md btn-primary"><i
                                                    data-feather="filter"></i>
                                                Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Start -->
                <div class="row match-height">
                    <!-- Start Card -->
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-header border-top-primary p-1 border-3">
                                <h4 class="card-title">EMP Oil Production</h4>
                                <h4 class="text-end" style="font-size : 1em !important;">
                                    {{ \Carbon\Carbon::parse($filterFirstWeek)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($filterLastWeek)->format('d M Y') }}
                                </h4>
                            </div>
                            <div class="card-body" style="background:#f8f8f8;">
                                <blockquote class="border-bottom-primary border-3 text-black rounded p-1">
                                    Average Prod : &nbsp; <b>{{ $averageOil }} BOPD </b><br />
                                    {{-- Budget OCT : &nbsp; 6.946 BOPD <br />
                                    LE OCT : &nbsp; 5.912 BOPD --}}
                                </blockquote>
                                <div style="padding:2%;">
                                    <div id="chart" height="350"></div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="font-table headcol bold">OIL (BOPD)</th>
                                                <th class="font-table">Last Week</th>
                                                <th class="font-table">This Week</th>
                                                {{-- <th class="font-table">#</th>
                                                <th class="font-table">OCT Target</th>
                                                <th class="font-table">#</th> --}}
                                                <th class="font-table">WI</th>
                                                {{-- <th class="font-table">%</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalOilLastWeek = 0;
                                                $totalOilThisWeek = 0;
                                                $totalOilWI = 0;
                                            @endphp
                                            @foreach ($dataOilSummary as $oil)
                                                <tr>
                                                    <td class="font-table headcol bolc">{{ $oil['name'] }}</td>
                                                    <td class="font-table">
                                                        {{ number_format($oil['last_week'], 2, '.', '.') }}
                                                    </td>
                                                    <td class="font-table">
                                                        {{ number_format($oil['this_week'], 2, ',', ',') }}
                                                    </td>
                                                    {{-- <td class="font-table">
                                                        {{ number_format(substr($oil['prod'], 0, 4), 0, ',', ',') }}</td>
                                                    <td class="font-table">
                                                        {{ number_format(substr($row['oct_target'], 0, 4), 0, ',', ',') }}
                                                    </td>
                                                    <td class="font-table">
                                                        {{ number_format(substr($row['sales'], 0, 4), 0, ',', ',') }}</td> --}}
                                                    <td class="font-table">
                                                        {{ number_format($oil['wi'], 2, ',', ',') }}</td>
                                                    {{-- <td class="font-table">
                                                        {{ number_format(substr($row['percent'], 0, 4), 0, ',', ',') }}
                                                    </td> --}}
                                                </tr>
                                                @php
                                                    $totalOilThisWeek += $oil['this_week'];
                                                    $totalOilLastWeek += $oil['last_week'];
                                                    $totalOilWI += $oil['wi'];
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <td class="font-table headcol"><strong>Total</strong></td>
                                                <td class="font-table">{{ number_format($totalOilThisWeek, 2, ',', ',') }}
                                                <td class="font-table">{{ number_format($totalOilWI, 2, ',', ',') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div> <!-- end card footer -->
                        </div>
                        <!-- End Card -->
                    </div>
                    <!-- end col -->
                    @include('dashboard-management.management-weekly-gas')
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
@push('page-js')
    <script>
        var dataGas = JSON.parse('{!! json_encode($dataGas) !!}');
        var dataOil = JSON.parse('{!! json_encode($dataOil) !!}');
        var labelTanggal = JSON.parse('{!! json_encode($labelTanggal) !!}');
        // Chart options
        var chartOptions = {
            series: dataGas,
            chart: {
                height: 350,
                type: 'line',
                stacked: false,
            },
            stroke: {
                width: [0, 2, 5],
                curve: 'smooth'
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%'
                }
            },

            fill: {
                opacity: [0.85, 0.25, 1],
                gradient: {
                    inverseColors: false,
                    shade: 'light',
                    type: "vertical",
                    opacityFrom: 0.85,
                    opacityTo: 0.55,
                    stops: [0, 100, 100, 100]
                }
            },
            labels: labelTanggal,
            markers: {
                size: 0
            },
            xaxis: {
                type: 'date'
            },
            yaxis: {
                title: {
                    text: 'Oil',
                },
                min: 0
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function(y) {
                        if (typeof y !== "undefined") {
                            return y.toFixed(0) + " Oil";
                        }
                        return y;

                    }
                }
            }
        };
        var chartOptions2 = {
            series: dataOil,
            chart: {
                height: 350,
                type: 'line',
                stacked: false,
            },
            stroke: {
                width: [0, 2, 5],
                curve: 'smooth'
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%'
                }
            },

            fill: {
                opacity: [0.85, 0.25, 1],
                gradient: {
                    inverseColors: true,
                    shade: 'light',
                    type: "vertical",
                    opacityFrom: 0.85,
                    opacityTo: 0.55,
                    stops: [0, 100, 100, 100]
                }
            },
            labels: labelTanggal,
            markers: {
                size: 0
            },
            xaxis: {
                type: 'date'
            },
            yaxis: {
                title: {
                    text: 'Gas',
                },
                min: 0
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function(y) {
                        if (typeof y !== "undefined") {
                            return y.toFixed(0) + " Gas";
                        }
                        return y;

                    }
                }
            }
        }
        var chart = new ApexCharts(document.querySelector("#chart"), chartOptions);
        chart.render();
        var chart2 = new ApexCharts(document.querySelector("#chart2"), chartOptions2);
        chart2.render();
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
