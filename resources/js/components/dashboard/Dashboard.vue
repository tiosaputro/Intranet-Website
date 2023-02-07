<template>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Start -->
            <div class="row match-height">
                <slider :image="image"></slider>
                <production></production>
                <media :media="dataMedia" :campaign="dataCampaign" :infoemp="dataInfo"></media>
                <footerdashboard></footerdashboard>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
</template>

<script>
import {mapGetters} from 'vuex'
import slider from '../dashboard/Slider.vue'
import production from './Production.vue'
import media from './Media.vue'
import footerdashboard from './Footerdashboard.vue'
    export default {
        cache : false,
        data(){
            return{
                image : null,
                dataMedia : null,
                dataInfo : null,
                dataCampaign : null,
                title : ''
            }
        },
        mounted(){

        },
        components : {
            slider,
            production,
            media,
            footerdashboard
        },
        methods : {
            logout: function() {
                this.$store.dispatch("logout").then(() => {
                this.$router.push("login");
            });
            },
           async getNews(){
                await axios.get('data-news').then(function(response){
                    const res = response.data;
                    this.image = res.news;
                    this.dataMedia = res.media
                    this.dataInfo = res.info
                    this.dataCampaign = res.campaign
                }.bind(this));
            }
        },
        computed : {
            ...mapGetters({
                loggedin : 'isLoggedIn',
                authCheck : 'user',
                auth : 'user'
            })
        },
        created(){
            this.getNews()
        }
    }
</script>
