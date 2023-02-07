    <!-- Start Card -->
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header border-top-success p-1 border-3">
                <h4 class="card-title">EMP Gas Production</h4>
                <h4 class="text-end" style="font-size : 1em !important;">
                    {{ \Carbon\Carbon::parse($filterFirstWeek)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($filterLastWeek)->format('d M Y') }}
                </h4>
            </div>
            <div class="card-body" style="background:#f8f8f8;">
                <blockquote class="border-bottom-success border-3 text-black rounded p-1">
                    Average Prod : &nbsp; <b>{{ $averageGas }} MMCFD </b><br />
                    {{-- Budget OCT : &nbsp; 216.9 MMCFD <br />
                    LE OCT : &nbsp; 238.1 MMCFD --}}
                </blockquote>
                <div style="padding:2%;">
                    <div id="chart2" height="350"></div>
                </div>
            </div>
            <div class="card-footer">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="font-table headcol">Gas (MMCFD)</th>
                                <th class="font-table text-center">Last Week</th>
                                <th class="font-table text-center">This Week</th>
                                {{-- <th class="font-table">#</th>
                                <th class="font-table">OCT Target</th>
                                <th class="font-table">#</th> --}}
                                <th class="font-table text-center">WI</th>
                                {{-- <th class="font-table">%</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalGasLastWeek = 0;
                                $totalGasThisWeek = 0;
                                $totalGasWI = 0;
                            @endphp
                            @foreach ($dataGasSummary as $gas)
                                <tr>
                                    <td class="font-table headcol">{{ $gas['name'] }}</td>
                                    <td class="font-table text-center">
                                        {{ number_format($gas['last_week'], 2, '.', '.') }}
                                    </td>
                                    <td class="font-table text-center">
                                        {{ number_format($gas['this_week'], 2, ',', ',') }}
                                    </td>
                                    {{-- <td class="font-table">
                                                        {{ number_format(substr($gas['prod'], 0, 4), 0, ',', ',') }}</td>
                                                    <td class="font-table">
                                                        {{ number_format(substr($row['oct_target'], 0, 4), 0, ',', ',') }}
                                                    </td>
                                                    <td class="font-table">
                                                        {{ number_format(substr($row['sales'], 0, 4), 0, ',', ',') }}</td> --}}
                                    <td class="font-table text-center">
                                        {{ number_format($gas['wi'], 2, ',', ',') }}</td>
                                    {{-- <td class="font-table">
                                                        {{ number_format(substr($row['percent'], 0, 4), 0, ',', ',') }}
                                                    </td> --}}
                                </tr>
                                @php
                                    $totalGasLastWeek += $gas['last_week'];
                                    $totalGasThisWeek += $gas['this_week'];
                                    $totalGasWI += $gas['wi'];
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
