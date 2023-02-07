<template>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="row match-height">
                <!-- Start Card -->
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header border-top-primary p-1 border-3">
                            <h4 class="card-title">EMP Oil Production</h4>
                            <h4 class="text-end" style="font-size : 1em !important;">1 Desember 2021 - 11 Desember 2021</h4>
                        </div>
                    <div class="card-body">
                        <blockquote class="border-bottom-primary border-3 text-black rounded p-1">
                            Average Prod : &nbsp; 5.052 BOPD <br/>
                            Budget OCT : &nbsp; 6.946 BOPD <br/>
                            LE OCT : &nbsp; 5.912 BOPD
                        </blockquote>
                        <div id="vuechart-example">
                            <apexchart type="line" height="350" :options="chartOptions" :series="series"></apexchart>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="font-table headcol">OIL (BOPD)</th>
                                        <th class="font-table">Last Week</th>
                                        <th class="font-table">This Week</th>
                                        <th class="font-table">#</th>
                                        <th class="font-table">OCT Target</th>
                                        <th class="font-table">#</th>
                                        <th class="font-table">WI</th>
                                        <th class="font-table">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="row in params" :key="row.id">
                                        <td class="font-table headcol">{{ row.name }}</td>
                                        <td class="font-table">{{ row.last_week }}</td>
                                        <td class="font-table">{{ row.this_week }}</td>
                                        <td class="font-table">{{ row.prod }}</td>
                                        <td class="font-table">{{ row.oct_target }}</td>
                                        <td class="font-table">{{ row.sales }}</td>
                                        <td class="font-table">{{ row.wi }}</td>
                                        <td class="font-table">{{ row.percent }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div> <!-- end card footer -->
                    </div>
                <!-- End Card -->
                </div>
                <!-- end col -->

                <!-- Gas Grafik -->
                <grafikgas></grafikgas>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
</template>
<style scoped>
    .font-table{
        font-size: 0.7em !important;
    }
    .headcol{
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
        .table-responsive{
            overflow-x: scroll;
            margin-left: 5em;
            overflow-y: visible;
            padding: 0;
        }
</style>
<script>
import VueApexCharts from 'vue-apexcharts';
import weeklygas from './WeeklyGas.vue'
const random = (Math.random() * 10).toFixed(0);
const dataTable = [
    {
        name : "Malacca", last_week : 5.037, this_week : (parseInt(random)+0.2), prod : (parseInt(random)+0.5), sales : (parseInt(random)/0.2), oct_target : (parseInt(random)+1.3), wi : (parseInt(random)+2.2), percent : (parseInt(random)*0.2)+'%'
    },
    {
        name : "Sengkang", last_week : 5.037, this_week : (parseInt(random)+0.2), prod : (parseInt(random)+0.5), sales : (parseInt(random)/0.2), oct_target : (parseInt(random)+1.3), wi : (parseInt(random)+2.2), percent : (parseInt(random)*0.2)+'%'
    },
    {
        name : "Gebang", last_week : 5.037, this_week : (parseInt(random)+0.2), prod : (parseInt(random)+0.5), sales : (parseInt(random)/0.2), oct_target : (parseInt(random)+1.3), wi : (parseInt(random)+2.2), percent : (parseInt(random)*0.2)+'%'
    },
    {
        name : "Tonga", last_week : 5.037, this_week : (parseInt(random)+0.2), prod : (parseInt(random)+0.5), sales : (parseInt(random)/0.2), oct_target : (parseInt(random)+1.3), wi : (parseInt(random)+2.2), percent : (parseInt(random)*0.2)+'%'
    },
    {
        name : "Kangean", last_week : 5.037, this_week : (parseInt(random)+0.2), prod : (parseInt(random)+0.5), sales : (parseInt(random)/0.2), oct_target : (parseInt(random)+1.3), wi : (parseInt(random)+2.2), percent : (parseInt(random)*0.2)+'%'
    },
    {
        name : "WK B", last_week : 5.037, this_week : (parseInt(random)+0.2), prod : (parseInt(random)+0.5), sales : (parseInt(random)/0.2), oct_target : (parseInt(random)+1.3), wi : (parseInt(random)+2.2), percent : (parseInt(random)*0.2).toFixed(2)+'%'
    },

]
    export default {
       data: function() {
        return {
           params : dataTable,
           series: [{
            name: 'Malacca',
            type: 'column',
            data: [23, 11, 22, (Math.random() * 10).toFixed(0), 13, (Math.random() * 10).toFixed(0), 37, 21, 44, (Math.random() * 10).toFixed(0), 30]
          }, {
            name: 'Kangean',
            type: 'column',
            data: [44, 55, 41, (Math.random() * 10).toFixed(0), 22, 43, 21, (Math.random() * 10).toFixed(0), 56, 27, (Math.random() * 10).toFixed(0)]
          }, {
            name: 'Tonga',
            type: 'column',
            data: [30, 25, 36, (Math.random() * 10).toFixed(0), 45, 35, (Math.random() * 10).toFixed(0), 52, (Math.random() * 10).toFixed(0), 36, (Math.random() * 10).toFixed(0)]
          },
          {
            name: 'Korinci',
            type: 'column',
            data: [30, 25, (Math.random() * 10).toFixed(0), 30, 45, (Math.random() * 10).toFixed(0), 64, (Math.random() * 10).toFixed(0), 59, 36, 39]
          },
          {
            name: 'Bentu',
            type: 'column',
            data: [30, 25, 36, (Math.random() * 10).toFixed(0), 45, 35, (Math.random() * 10).toFixed(0), 52, (Math.random() * 10).toFixed(0), 36, (Math.random() * 10).toFixed(0)]
          },
          {
            name: 'Gebang',
            type: 'column',
            data: [30, (Math.random() * 10).toFixed(0), (Math.random() * 10).toFixed(0), 30, 45, (Math.random() * 10).toFixed(0), 64, 52, 59, (Math.random() * 10).toFixed(0), 39]
          },
          {
            name: 'Budget',
            type: 'line',
            data: [30, (Math.random() * 10).toFixed(0), (Math.random() * 10).toFixed(0), 30, 45, (Math.random() * 10).toFixed(0), 64, 52, 59, (Math.random() * 10).toFixed(0), 39]
          },
          {
            name: 'LE',
            type: 'line',
            data: [30, (Math.random() * 10).toFixed(0), (Math.random() * 10).toFixed(0), 30, 45, (Math.random() * 10).toFixed(0), 64, 52, 59, (Math.random() * 10).toFixed(0), 39]
          },
          {
            name: 'Operated',
            type: 'line',
            data: [30, (Math.random() * 10).toFixed(0), 36, 30, 45, (Math.random() * 10).toFixed(0), 64, 52, 59, 36, 39]
          },
          {
            name: 'Percentage',
            type: 'area',
            data: [30, (Math.random() * 10).toFixed(0), 36, 30, 45, (Math.random() * 10).toFixed(0), 64, 52, 59, 36, 39]
          }
          ],
          chartOptions: {
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
            labels: ['11/01/2021', '11/02/2021', '11/03/2021', '11/04/2021', '11/05/2021', '11/06/2021', '11/07/2021',
              '11/08/2021', '11/09/2021', '11/10/2021', '11/11/2021'
            ],
            markers: {
              size: 0
            },
            xaxis: {
              type: 'datetime'
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
                formatter: function (y) {
                  if (typeof y !== "undefined") {
                    return y.toFixed(0) + " Oil";
                  }
                  return y;

                }
              }
            }
          },
        }
        },
        mounted(){

        },
        components : {
            apexchart: VueApexCharts,
            grafikgas : weeklygas
        },
        methods : {

        }
    }
</script>
