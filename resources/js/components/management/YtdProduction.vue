<template>
<div class="col-md-8">
    <div class="card">
      <div class="card-header border-top-success p-1 border-3">
        <h4 class="card-title">YTD Budget vs Actual Production</h4>
        <h4 class="text-end">Ending 1 November 2021</h4>
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
              <tr v-for="row in dataProduction" :key="row.id">
                  <td class="headcol">{{ row.name }}</td>
                  <td class="text-end fw-bold">{{ row.gros_oil }}</td>
                  <td class="text-end fw-bold">{{ row.gros_sale }}</td>
                  <td class="text-end fw-bold">{{ row.gros_total }}</td>
                  <td class="text-end fw-bold">{{ row.wi_oil }}</td>
                  <td class="text-end fw-bold">{{ row.wi_sale }}</td>
                  <td class="text-end fw-bold">{{ row.wi_total }}</td>
              </tr>
            <!-- JOIN OPERATED -->
            <tr class="">
                <th class="bg-white text-center headcol">Jointly Operated</th>
                <th colspan="2">&nbsp;</th>
                <th colspan="2">&nbsp;</th>
                <th colspan="2">&nbsp;</th>
            </tr>
              <tr v-for="(rows,idx) in dataProductionJoin" :key="rows.id">
                  <td class="headcol">{{ rows.name }}</td>
                  <td class="text-end fw-bold">{{ rows.gros_oil }}</td>
                  <td class="text-end fw-bold">{{ rows.gros_sale }}</td>
                  <td class="text-end fw-bold">{{ rows.gros_total }}</td>
                  <td class="text-end fw-bold">{{ rows.wi_oil }}</td>
                  <td class="text-end fw-bold">{{ rows.wi_sale }}</td>
                  <td class="text-end fw-bold">{{ rows.wi_total }}</td>
              </tr>

            <tr class="">
                <th class="bg-white text-center headcol">EMP Non Operated</th>
                <th colspan="2">&nbsp;</th>
                <th colspan="2">&nbsp;</th>
                <th colspan="2">&nbsp;</th>
            </tr>
              <tr v-for="(rows,idx) in dataProductionEmpNonOperated" :key="rows.id">
                  <td class="headcol">{{ rows.name }}</td>
                  <td class="text-end fw-bold">{{ rows.gros_oil }}</td>
                  <td class="text-end fw-bold">{{ rows.gros_sale }}</td>
                  <td class="text-end fw-bold">{{ rows.gros_total }}</td>
                  <td class="text-end fw-bold">{{ rows.wi_oil }}</td>
                  <td class="text-end fw-bold">{{ rows.wi_sale }}</td>
                  <td class="text-end fw-bold">{{ rows.wi_total }}</td>
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
              </tr>
          </tbody>
        </table>
      </div>
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
            dataProduction :[
                {id : 1, name : "MS", gros_oil : 4.776, gros_sale : 0.43, gros_total : 4.85, wi_oil : 6.85, wi_sale : 4.85, wi_total : 6.85},
                {id : 2, name : "Bentu", gros_oil : 0, gros_sale : 79.85, gros_total : 13.31, wi_oil : 14.50, wi_sale : 13.31, wi_total : 14.50},
                {id : 3, name : "Tonga", gros_oil : 0, gros_sale : 0, gros_total : 0, wi_oil : 0, wi_sale : 0, wi_total : 0},
                {id : 4, name : "Korinci", gros_oil : 0, gros_sale : 0, gros_total : 0, wi_oil : 0, wi_sale : 0, wi_total : 0},
                {id : 5, name : "Gebang", gros_oil : 0, gros_sale : 0, gros_total : 0, wi_oil : 0.42, wi_sale : 0, wi_total : 0.21},
                {id : 6, name : "BUZI", gros_oil : 0, gros_sale : 0, gros_total : 0, wi_oil : 0, wi_sale : 0, wi_total : 0},
            ],
            dataProductionJoin :[
                {id : 0, name : "Kangean", gros_oil : 65, gros_sale : 159.42, gros_total : 26.63, wi_oil : 25.62, wi_sale : 19.98, wi_total : 14.76}
            ],
            dataProductionEmpNonOperated :[
                {name : "Sengkang", gros_oil : 0, gros_sale : 39.55, gros_total : 6.59, wi_oil : 6.00, wi_sale : 3.23, wi_total : 2.94},
                {name : "WKB", gros_oil : 914, gros_sale : 10.36, gros_total : 2.64, wi_oil : 2.93, wi_sale : 1.29, wi_total : 1.43}
            ],
            dataTotal : [
                {name : "Total", gros_oil : 5.755, gros_sale : 289.60, gros_total : 54.02, wi_oil : 56.32, wi_sale : 42.66, wi_total : 40.69}
            ]
        }
    }
}
</script>
