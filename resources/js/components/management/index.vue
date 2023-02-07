<template>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="row match-height">
                <dailyproduction></dailyproduction>
                <ytdproduction></ytdproduction>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
</template>

<script>
import dailyproduction from './DailyProduction.vue'
import ytdproduction from './YtdProduction.vue'
    export default {
        data(){
            return {
                output : null
            }
        },
        mounted(){

        },
        components : {
            dailyproduction,
            ytdproduction
        },
        methods : {

        }
    }
</script>
