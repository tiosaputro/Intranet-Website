@extends('layout_web.template')
<!-- BEGIN: Content-->
@section('custom_css')
    <style>

    </style>
@endsection

@section('content')
    <div class="app-content content" style="zoom:95%;">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Start -->
                <div class="row">
                    <div class="col-md-4">
                        <!-- Create Filter Form Year -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Filter Data</h4>
                            </div>
                            <div class="card-body">
                                @include('layout_web.notif-alert')
                                <form action="{{ url('management-yearly') }}" method="GET">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <select class="form-control select2 form-select" name="tahun"
                                                    id="select2-basic">
                                                    <option value="">--Select Year--</option>
                                                    @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                                        <option value="{{ $i }}"
                                                            {{ $i == $filterTahun ? 'selected' : '' }}>{{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="chart" width="500" height="350"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
@push('page-js')
    <script>
        var dataParse = JSON.parse('{!! json_encode($result) !!}');
        console.log(dataParse)
        var labelBulan = JSON.parse('{!! json_encode($labelBulan) !!}');
        var chartOptions = {
            series: dataParse,
            chart: {
                height: 350,
                type: 'line',
            },
            stroke: {
                width: [0, 4]
            },
            title: {
                text: 'All EMP'
            },
            dataLabels: {
                enabled: true,
                enabledOnSeries: [1]
            },
            labels: labelBulan,
            xaxis: {
                type: 'string'
            },
            yaxis: [{
                title: {
                    text: 'Oil',
                },

            }, {
                opposite: true,
                title: {
                    text: 'Gas'
                }
            }]
        };
        var chart = new ApexCharts(document.querySelector("#chart"), chartOptions);
        chart.render();
        chart.zoomX(0, 10);
    </script>
    <script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
@endpush
