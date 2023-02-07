<div class="col-md-8">
    <div class="card">
        <div class="card-header border-top-success p-1 border-3">
            <h4 class="card-title">YTD Budget vs Actual Production</h4>
            <h4 class="text-end">Ending {{ \Carbon\Carbon::parse(now())->format('d M Y') }}</h4>
        </div>
        <div class="card-body">

            <div class="table-responsive-fixed mt-2 fs-7">
                <table class="table table-striped text-sm">
                    <thead class="fs-3">
                        <tr>
                            <th class="align-middle headcol" rowspan="2">PSC</th>
                            <th colspan="12" class="text-center bg-info text-white">Budget vs Actual</th>
                        </tr>
                        <tr>
                            <th colspan="2" class="bg-primary text-white text-center">YTD</th>
                            <th colspan="2" class="bg-warning text-white text-center">Gross YTD (mboepd)</th>
                            <th colspan="2" class="bg-secondary text-white text-center">WI YTD(mboepd)</th>
                        </tr>
                        <tr>
                            <th class="bg-white text-center headcol">EMP Operated</th>
                            <th class="bg-white text-center mb-right">Oil BOPD</th>
                            <th class="bg-white text-center">Sale Gas BBTUD</th>
                            <th class="bg-white text-center">Actual</th>
                            <th class="bg-white text-center">Budget</th>
                            <th class="bg-white text-center">Actual</th>
                            <th class="bg-white text-center">Budget</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($year['dataProduction'] as $row)
                            <tr>
                                <td class="headcol">{{ $row['name'] }}</td>
                                <td class="text-end fw-bold">{{ $row['budget_oil'] }}</td>
                                <td class="text-end fw-bold">{{ $row['budget_gas'] }}</td>
                                <td class="text-end fw-bold">{{ $row['gros_total'] }}</td>
                                <td class="text-end fw-bold">{{ $row['budget_total'] }}</td>
                                <td class="text-end fw-bold">{{ $row['wi_sale'] }}</td>
                                <td class="text-end fw-bold">{{ $row['budget_wi'] }}</td>
                            </tr>
                        @endforeach
                        <!-- JOIN OPERATED -->
                        <tr class="">
                            <th class="bg-white text-center headcol">Jointly Operated</th>
                            <th colspan="2">&nbsp;</th>
                            <th colspan="2">&nbsp;</th>
                            <th colspan="2">&nbsp;</th>
                        </tr>
                        @foreach ($year['dataProductionJoin'] as $row)
                            <tr>
                                <td class="headcol">{{ $row['name'] }}</td>
                                <td class="text-end fw-bold">{{ $row['budget_oil'] }}</td>
                                <td class="text-end fw-bold">{{ $row['budget_gas'] }}</td>
                                <td class="text-end fw-bold">{{ $row['gros_total'] }}</td>
                                <td class="text-end fw-bold">{{ $row['budget_total'] }}</td>
                                <td class="text-end fw-bold">{{ $row['wi_sale'] }}</td>
                                <td class="text-end fw-bold">{{ $row['budget_wi'] }}</td>
                            </tr>
                        @endforeach
                        <tr class="">
                            <th class="bg-white text-center headcol">EMP Non Operated</th>
                            <th colspan="2">&nbsp;</th>
                            <th colspan="2">&nbsp;</th>
                            <th colspan="2">&nbsp;</th>
                        </tr>
                        @foreach ($year['dataProductionEmpNonOperated'] as $row)
                            <tr>
                                <td class="headcol">{{ $row['name'] }}</td>
                                <td class="text-end fw-bold">{{ $row['budget_oil'] }}</td>
                                <td class="text-end fw-bold">{{ $row['budget_gas'] }}</td>
                                <td class="text-end fw-bold">{{ $row['gros_total'] }}</td>
                                <td class="text-end fw-bold">{{ $row['budget_total'] }}</td>
                                <td class="text-end fw-bold">{{ $row['wi_sale'] }}</td>
                                <td class="text-end fw-bold">{{ $row['budget_wi'] }}</td>
                            </tr>
                        @endforeach
                        <!-- Total -->
                        <tr class="bg-secondary">
                            <td class="fw-bold headcol">{{ $year['dataTotal']['name'] }}</td>
                            <td class="text-end fw-bold text-white">{{ $year['dataTotal']['budget_oil'] }}</td>
                            <td class="text-end fw-bold text-white">{{ $year['dataTotal']['budget_gas'] }}</td>
                            <td class="text-end fw-bold text-white">{{ $year['dataTotal']['gros_total'] }}</td>
                            <td class="text-end fw-bold text-white">{{ $year['dataTotal']['budget_total'] }}</td>
                            <td class="text-end fw-bold text-white">{{ $year['dataTotal']['wi_sale'] }}</td>
                            <td class="text-end fw-bold text-white">{{ $year['dataTotal']['budget_wi'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- End Card -->
</div> <!-- End Col -->
