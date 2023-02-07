<template>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="row match-height">
                <div id="vuechart-example">
                    <apexchart type="line" height="350" :options="chartOptions" :series="series"></apexchart>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
</template>

<script>
import VueApexCharts from 'vue-apexcharts';
    export default {
        data(){
            return {
        series: [
          {
            name: 'Mallaca Gas',
            type: 'column',
            data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160]
          },
          {
            name: 'Mallaca Oil',
            type: 'column',
            data: [410, 305, 214, 171, 327, 113, 301, 552, 652, 120, 157, 60]
          },
          {
            name: 'Gebang Gas',
            type: 'column',
            data: [233, 342, 325, 217, 343, 122, 217, 311, 222, 322, 412, 516]
          },
          {
            name: 'Gebang Oil',
            type: 'column',
            data: [28, 62, 15, 26, 143, 122, 117, 131, 212, 121, 124, 162]
          },
          {
            name: 'Bentu Gas',
            type: 'column',
            data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16]
          },
          {
            name: 'Bentu Oil',
            type: 'column',
            data: [28, 62, 15, 26, 143, 122, 117, 131, 212, 121, 124, 162]
          },
          {
            name: 'Tonga Gas',
            type: 'column',
            data: [58, 72, 35, 76, 443, 132, 217, 139, 312, 171, 224, 362]
          },
          {
            name: 'Tonga Oil',
            type: 'column',
            data: [123, 92, 65, 57, 23, 62, 87, 51, 42, 32, 52, 76]
          },
          {
            name: 'Kangean Gas',
            type: 'column',
            data: [98, 72, 45, 56, 243, 212, 217, 181, 111, 29, 174, 232]
          },
          {
            name: 'Kangean Oil',
            type: 'column',
            data: [233, 342, 325, 217, 343, 122, 217, 311, 222, 322, 412, 516]
          },
          {
            name: 'WK B Oil',
            type: 'column',
            data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160]
          },
          {
            name: 'WK B Gas',
            type: 'column',
            data: [410, 305, 214, 171, 327, 113, 301, 552, 652, 120, 157, 60]
          },
          {
            name: 'Sengkang Gas',
            type: 'column',
            data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16]
          },
          {
            name: 'Sengkang Oil',
            type: 'column',
            data: [128, 262, 215, 126, 243, 212, 317, 113, 112, 221, 194, 192]
          },
          {
            name: 'Total Budget',
            type: 'line',
            data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16]
          },
          {
            name: 'Total Sales',
            type: 'line',
            data: [28, 62, 15, 26, 143, 122, 117, 131, 212, 121, 124, 162]
          },
          {
            name: 'EMP Operated',
            type: 'line',
            data: [233, 342, 325, 217, 343, 122, 217, 311, 222, 322, 412, 516]
          }
          ],
          chartOptions: {
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
            labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
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
          },
            }
        },
        mounted(){

        },
        components : {
            apexchart : VueApexCharts
        },
        methods : {

        }
    }
</script>
