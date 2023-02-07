<template>
<div class="col-12">
    <div class="card">
      <div class="card-header border-top-success p-1 border-3">
        <h4 class="card-title">Daily Production</h4>
        <h4 class="text-end">Ending {{ tanggal_ending }}</h4>
      </div>
      <div class="card-body">

      <div class="table-responsive-fixed mt-2 fs-6">
        <table class="table table-striped text-sm">
          <thead>
            <tr>
              <th rowspan="2" class="align-middle headcol">PSC</th>
              <th colspan="12" class="text-center bg-dark text-white">Actual Delivery</th>
            </tr>
            <tr>
                <th colspan="3" class="bg-primary text-white text-center">GROS</th>
                <th colspan="3" class="bg-warning text-white text-center">WI</th>
                <th colspan="4" class="bg-secondary text-white text-center">Dec 2021 Budget(*)</th>
            </tr>
            <tr>
                <th class="bg-white headcol">EMP Operated</th>
                <th class="bg-white text-center mb-right"><b style="text-align:right !important;">Oil BOPD</b></th>
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
              <tr v-for="row in dataProduction" :key="row.id">
                  <th class="headcol">{{ row.name }}</th>
                  <td class="text-end fw-bold">{{ row.gros_oil }}</td>
                  <td class="text-end fw-bold">{{ row.gros_sale }}</td>
                  <td class="text-end fw-bold">{{ row.gros_total }}</td>
                  <td class="text-end fw-bold">{{ row.wi_oil }}</td>
                  <td class="text-end fw-bold">{{ row.wi_sale }}</td>
                  <td class="text-end fw-bold">{{ row.wi_total }}</td>
                  <td class="text-end fw-bold">{{ row.budget_oil }}</td>
                  <td class="text-end fw-bold">{{ row.budget_gas }}</td>
                  <td class="text-end fw-bold">{{ row.budget_total }}</td>
                  <td class="text-end fw-bold bg-success text-white">{{ row.wi_mboepd }}</td>
              </tr>
            <!-- JOIN OPERATED -->
            <tr>
                <th class="bg-warning headcol">Jointly Operated</th>
                <th colspan="3">&nbsp;</th>
                <th colspan="3">&nbsp;</th>
                <th colspan="4">&nbsp;</th>
            </tr>
              <tr v-for="(rows,idx) in dataProductionJoin" :key="rows.id">
                  <td class="headcol">{{ rows.name }}</td>
                  <td class="text-end fw-bold">{{ rows.gros_oil }}</td>
                  <td class="text-end fw-bold">{{ rows.gros_sale }}</td>
                  <td class="text-end fw-bold">{{ rows.gros_total }}</td>
                  <td class="text-end fw-bold">{{ rows.wi_oil }}</td>
                  <td class="text-end fw-bold">{{ rows.wi_sale }}</td>
                  <td class="text-end fw-bold">{{ rows.wi_total }}</td>
                  <td class="text-end fw-bold">{{ rows.budget_oil }}</td>
                  <td class="text-end fw-bold">{{ rows.budget_gas }}</td>
                  <td class="text-end fw-bold">{{ rows.budget_total }}</td>
                  <td class="text-end fw-bold bg-success text-white">{{ rows.wi_mboepd }}</td>
              </tr>

            <tr class="bg-warning">
                <th class="headcol">EMP Non Operated</th>
                <th colspan="3">&nbsp;</th>
                <th colspan="3">&nbsp;</th>
                <th colspan="4">&nbsp;</th>
            </tr>
              <tr v-for="(rows,idx) in dataProductionEmpNonOperated" :key="rows.id">
                  <td class="headcol">{{ rows.name }}</td>
                  <td class="text-end fw-bold">{{ rows.gros_oil }}</td>
                  <td class="text-end fw-bold">{{ rows.gros_sale }}</td>
                  <td class="text-end fw-bold">{{ rows.gros_total }}</td>
                  <td class="text-end fw-bold">{{ rows.wi_oil }}</td>
                  <td class="text-end fw-bold">{{ rows.wi_sale }}</td>
                  <td class="text-end fw-bold">{{ rows.wi_total }}</td>
                  <td class="text-end fw-bold">{{ rows.budget_oil }}</td>
                  <td class="text-end fw-bold">{{ rows.budget_gas }}</td>
                  <td class="text-end fw-bold">{{ rows.budget_total }}</td>
                  <td class="text-end fw-bold bg-success text-white">{{ rows.wi_mboepd }}</td>
              </tr>
            <!-- Total -->
              <tr v-for="(rows,idx) in dataTotal" :key="rows.id" class="bg-secondary text-white">
                  <td class="fw-bold headcol">{{ rows.name }}</td>
                  <td class="text-end fw-bold">{{ rows.gros_oil }}</td>
                  <td class="text-end fw-bold">{{ rows.gros_sale }}</td>
                  <td class="text-end fw-bold">{{ rows.gros_total }}</td>
                  <td class="text-end fw-bold">{{ rows.wi_oil }}</td>
                  <td class="text-end fw-bold">{{ rows.wi_sale }}</td>
                  <td class="text-end fw-bold">{{ rows.wi_total }}</td>
                  <td class="text-end fw-bold">{{ rows.budget_oil }}</td>
                  <td class="text-end fw-bold">{{ rows.budget_gas }}</td>
                  <td class="text-end fw-bold">{{ rows.budget_total }}</td>
                  <td class="text-end fw-bold bg-success text-white">{{ rows.wi_mboepd }}</td>
              </tr>

          </tbody>
        </table>
      </div>
      </div>
      <div class="card-footer">
        <p class="card-text">
            <code class="text-danger">*Production gas is using gas sales volume for all BU</code><br/>
            <b class="text-small">(*) The quoted budget is using WP&B 2021 budget</b><br/>
            <b class="text-small">(**) Waiting data from sengkang for oil production</b>
        </p>
      </div>
    </div> <!-- End Card -->
</div> <!-- End Col -->
</template>
<style scoped>

</style>
<script>
export default {
    data : function(){
        return {
            tanggal_ending : '22 Desember 2021',
            dataProduction :[
                {id : 1, name : "MS", gros_oil : 5.446, gros_sale : 0.49, gros_total : 5.52, wi_oil : 5.446, wi_sale : 0.49, wi_total : 5.52, budget_oil : 6.037, budget_gas : 3.50, budget_total : 6.62, wi_mboepd : 6.62},
                {id : 2, name : "Bentu", gros_oil : 0, gros_sale : 81.03, gros_total : 13.51, wi_oil : 0, wi_sale : 81.03, wi_total : 13.51, budget_oil : 0, budget_gas : 87.00, budget_total : 14.50, wi_mboepd : 14.50},
                {id : 3, name : "Tonga", gros_oil : 0, gros_sale : 0, gros_total : 0, wi_oil : 0, wi_sale : 0, wi_total : 0, budget_oil : 0, budget_gas : 0, budget_total : 0, wi_mboepd : 0},
                {id : 4, name : "Gebang", gros_oil : 0, gros_sale : 0, gros_total : 0, wi_oil : 0, wi_sale : 0, wi_total : 0, budget_oil : 0, budget_gas : 3.00, budget_total : 0.50, wi_mboepd : 0.25},
                {id : 5, name : "Korinci", gros_oil : 0, gros_sale : 0, gros_total : 0, wi_oil : 0, wi_sale : 0, wi_total : 0, budget_oil : 0, budget_gas : 0, budget_total : 0, wi_mboepd : 0},
                {id : 6, name : "BUZI", gros_oil : 0, gros_sale : 0, gros_total : 0, wi_oil : 0, wi_sale : 0, wi_total : 0, budget_oil : 0, budget_gas : 0, budget_total : 0, wi_mboepd : 0},
            ],
            dataProductionJoin :[
                {id : 0, name : "Kangean", gros_oil : 57, gros_sale : 145.73, gros_total : 24.66, wi_oil : 43, wi_sale : 109.30, wi_total : 18.50, budget_oil : 73, budget_gas : 109.87, budget_total : 18.38, wi_mboepd : 13.79}
            ],
            dataProductionEmpNonOperated :[
                {name : "Sengkang **", gros_oil : 0, gros_sale : 32.66, gros_total : 5.61, wi_oil : 0, wi_sale : 16.00, wi_total : 2.75, budget_oil : 0, budget_gas : 34.59, budget_total : 5.77, wi_mboepd : 2.82},
                {name : "WKB", gros_oil : 791, gros_sale : 12.59, gros_total : 2.89, wi_oil : 388, wi_sale : 6.17, wi_total : 1.42, budget_oil : 629, budget_gas : 11.43, budget_total : 2.53, wi_mboepd : 1.24}
            ],
            dataTotal : [
                {name : "Total", gros_oil : 6.294, gros_sale : 272.50, gros_total : 52.18, wi_oil : 5.876, wi_sale : 212.99, wi_total : 41.68, budget_oil : 6.740, budget_gas : 249.39, budget_total : 48.30, wi_mboepd : 39.23}
            ]
        }
    }
}
</script>
