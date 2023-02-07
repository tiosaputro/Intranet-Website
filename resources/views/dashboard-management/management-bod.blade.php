@extends('layout_web.template')
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content" style="zoom:95%;">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Start -->
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-top-success p-1 border-3">
                                <h4 class="card-title">Daily Production</h4>
                                <h4 class="text-end">Ending {{ $dummy['tanggal_ending'] }}</h4>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive-fixed mt-2 fs-6">
                                    <table class="table table-bordered table-condensed text-sm">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="align-middle headcol">PSC</th>
                                                <th colspan="12" class="text-center bg-dark text-white">Actual Delivery
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="3" class="bg-primary text-white text-center">GROS</th>
                                                <th colspan="3" class="bg-warning text-white text-center">WI</th>
                                                <th colspan="4" class="bg-secondary text-white text-center">
                                                    {{ Carbon\Carbon::now()->format('F Y') }} Budget(*)</th>
                                            </tr>
                                            <tr>
                                                <th class="bg-white headcol">EMP Operated</th>
                                                <th class="bg-white text-center mb-right"><b
                                                        style="text-align:right !important;">Oil BOPD</b></th>
                                                <th class="bg-white text-center">Sale Gas MMSCFD</th>
                                                <th class="bg-white text-center">Total MBOEPD</th>
                                                <th class="bg-white text-center">Oil BOPD</th>
                                                <th class="bg-white text-center">Sale Gas MMSCFD</th>
                                                <th class="bg-white text-center">Total MBOEPD</th>
                                                <th class="bg-white text-center">Oil BOPD</th>
                                                <th class="bg-white text-center">Sale Gas MMSCFD</th>
                                                <th class="bg-white text-center">Total MBOEPD</th>
                                                <th class="bg-success text-white">WI MBOEPD</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dummy['dataProduction'] as $row)
                                                <tr>
                                                    <th class="headcol">{{ $row['name'] }}</th>
                                                    <td class="text-end fw-bold">{{ $row['gros_oil'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['gros_sale'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['gros_total'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['wi_oil'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['wi_sale'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['wi_total'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['budget_oil'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['budget_gas'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['budget_total'] }}</td>
                                                    <td class="text-end fw-bold bg-success text-white">
                                                        {{ $row['budget_wi'] }}</td>
                                                </tr>
                                            @endforeach
                                            <!-- JOIN OPERATED -->
                                            <tr class="bg-warning ">
                                                <th class="headcol bg-warning text-white">Jointly Operated</th>
                                                <th colspan="3">&nbsp;</th>
                                                <th colspan="3">&nbsp;</th>
                                                <th colspan="4">&nbsp;</th>
                                            </tr>
                                            @foreach ($dummy['dataProductionJoin'] as $row)
                                                <tr>
                                                    <td class="headcol">{{ $row['name'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['gros_oil'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['gros_sale'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['gros_total'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['wi_oil'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['wi_sale'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['wi_total'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['budget_oil'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['budget_gas'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['budget_total'] }}</td>
                                                    <td class="text-end fw-bold bg-success text-white">
                                                        {{ $row['budget_wi'] }}</td>
                                                </tr>
                                            @endforeach
                                            <tr class="bg-warning">
                                                <th class="headcol bg-warning text-white">EMP Non Operated</th>
                                                <th colspan="3">&nbsp;</th>
                                                <th colspan="3">&nbsp;</th>
                                                <th colspan="4">&nbsp;</th>
                                            </tr>
                                            @foreach ($dummy['dataProductionEmpNonOperated'] as $row)
                                                <tr>
                                                    <td class="headcol">{{ $row['name'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['gros_oil'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['gros_sale'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['gros_total'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['wi_oil'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['wi_sale'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['wi_total'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['budget_oil'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['budget_gas'] }}</td>
                                                    <td class="text-end fw-bold">{{ $row['budget_total'] }}</td>
                                                    <td class="text-end fw-bold bg-success text-white">
                                                        {{ $row['budget_wi'] }}</td>
                                                </tr>
                                            @endforeach
                                            <!-- Total -->
                                            <tr class="bg-secondary text-white">
                                                <td class="fw-bold headcol">{{ $dummy['dataTotal']['name'] }}</td>
                                                <td class="text-end fw-bold">{{ $dummy['dataTotal']['gros_oil'] }}</td>
                                                <td class="text-end fw-bold">{{ $dummy['dataTotal']['gros_sale'] }}</td>
                                                <td class="text-end fw-bold">{{ $dummy['dataTotal']['gros_total'] }}</td>
                                                <td class="text-end fw-bold">{{ $dummy['dataTotal']['wi_oil'] }}</td>
                                                <td class="text-end fw-bold">{{ $dummy['dataTotal']['wi_sale'] }}</td>
                                                <td class="text-end fw-bold">{{ $dummy['dataTotal']['wi_total'] }}</td>
                                                <td class="text-end fw-bold">{{ $dummy['dataTotal']['budget_oil'] }}</td>
                                                <td class="text-end fw-bold">{{ $dummy['dataTotal']['budget_gas'] }}</td>
                                                <td class="text-end fw-bold">{{ $dummy['dataTotal']['budget_total'] }}</td>
                                                <td class="text-end fw-bold bg-success text-white">
                                                    {{ $dummy['dataTotal']['budget_wi'] }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p class="card-text">
                                    <code class="text-danger">*Production gas is using gas sales volume for all
                                        BU</code><br />
                                    {{-- <b class="text-small">(*) The quoted budget is using WP&B 2021 budget</b><br />
                                    <b class="text-small">(**) Waiting data from sengkang for oil production</b> --}}
                                </p>
                            </div>
                        </div> <!-- End Card -->
                    </div> <!-- End Col -->
                </div>

                <div class="row match-height">
                    @include('dashboard-management.management-year-bod')
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
