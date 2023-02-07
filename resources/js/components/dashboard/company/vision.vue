<template>
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Vision & Mision</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Vision & Mision
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div id="user-profile">
                    <!-- profile header -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card profile-header mb-2">
                                <!-- profile cover photo -->
                                <img class="card-img-top" src="file-manager/vision-emp.jpg" alt="User Profile Image" />
                                <!--/ profile cover photo -->

                                <div class="position-relative">
                                    <!-- profile picture -->
                                    <div class="profile-img-container d-flex align-items-center">
                                        <div class="profile-img">
                                            <img src="default-image.png" class="rounded img-fluid" alt="Card image" />
                                        </div>
                                        <!-- profile title -->
                                        <div class="profile-title ms-3">
                                            <h2 class="text-white">Vision & Mision EMP</h2>
                                            <!-- <p class="text-white">UI/UX Designer</p> -->
                                        </div>
                                    </div>
                                </div>

                                <!-- tabs pill -->
                                <div class="profile-header-nav">
                                    <!-- navbar -->
                                    <div class="navbar navbar-expand-md navbar-light justify-content-end justify-content-md-between w-100">
                                        <!-- collapse  -->
                                        <div class="collapse navbar-collapse show" id="navbarSupportedContent">
                                            <div class="profile-tabs d-flex justify-content-between flex-wrap mt-5 mt-md-0">
                                                <p class="rounded fw-bold text-dark faq-contact-card p-2" style="background : rgba(115, 103, 240, 0.12) !important;">To become the leading independent Oil & Gas Exploration & Production Company in Asia. To implement safety, health and environmental protection excellence, to uphold good corporate governance, and to contribute to the community development.</p>
                                            </div>
                                        </div>
                                        <!--/ collapse  -->
                                    </div>
                                    <!--/ navbar -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ profile header -->
            </div>
            </div>


        </div>
    </div>
    <!-- END: Content-->
</template>
<style scoped>
@import '/app-assets/css/pages/page-profile.css';
</style>
<script>
    export default {
        data(){
            return {
                display : true
            }
        },
        mounted(){

        },
        components : {

        },
        methods : {

        },

    }
</script>
