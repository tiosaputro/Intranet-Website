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
                            <h2 class="content-header-title float-start mb-0">Organization Structure</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Organization Structure
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card profile-header mb-2">
                                <!-- profile cover photo -->
                                <image-zoom
                                    regular="file-manager/structure-emp.png"
                                    zoom="file-manager/structure-emp.png"
                                    :zoom-amount="2"
                                    :click-zoom="true"
                                    img-class="img-fluid"
                                    alt="Structure Organization">
                                </image-zoom>
                                <!--/ profile cover photo -->
                            </div>
                        </div>
                    </div>
            </div> <!-- end content body -->
        </div> <!-- content wraper -->
    </div> <!-- app content -->
</template>
<script>
import imageZoom from 'vue-image-zoomer';
import 'lazysizes';
export default {
    data(){
        return{

        }
    },
    components : {
        imageZoom
    }
}
</script>
