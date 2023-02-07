<template>
    <div id="dashboard-ecommerce">
                <div class="row match-height">

                    <!-- Browser States Card -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card card-browser-states">
                            <div class="card-header border-top-secondary p-1">
                                <div>
                                    <h4 class="card-title fw-bolder"><feather-icon icon="TvIcon"></feather-icon> Media Highlights</h4>
                                    <!-- <p class="card-text font-small-2">Counter August 2020</p> -->
                                </div>
                                <div class="dropdown chart-dropdown">
                                    <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Last 28 Days</a>
                                        <a class="dropdown-item" href="#">Last Month</a>
                                        <a class="dropdown-item" href="#">Last Year</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Recent Posts -->
                            <div class="blog-recent-posts" v-if="media">
                                <div class="mt-0">
                                    <div class="d-flex mb-2" v-for="rowMedia in media" :key="rowMedia.id">
                                        <a :href="'#/media-highlight/detail/'+rowMedia.id" class="me-2">
                                            <img class="rounded" :src="'../'+rowMedia.banner_path" width="100" height="70" alt="" />
                                        </a>
                                        <div class="blog-info">
                                            <h6 class="blog-recent-post-title">
                                                <a :href="'#/media-highlight/detail/'+rowMedia.id" class="text-body-heading">
                                                    {{ rowMedia.title }}
                                                </a>
                                            </h6>
                                            <!-- <div class="text-muted mb-0">{{ rowMedia.created_at }}</div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Recent Posts -->
                            </div>
                        </div>
                    </div>
                    <!--/ Browser States Card -->

                    <!-- Goal Overview Card -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <!-- latest profile pictures -->
                        <div class="card">
                                <div class="card-header border-top-secondary p-1">
                                <div><h4 class="card-title fw-bolder"><feather-icon icon="TvIcon"></feather-icon> Company Campaign</h4></div>
                                <div class="dropdown chart-dropdown">
                                    <feather-icon icon="MoreVerticalIcon" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></feather-icon>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Lihat Semua</a>
                                    </div>
                                </div>
                                </div>
                                <div class="card-body" v-if="campaign">
                                    <div class="row mt-2" v-for="camp in campaign" :key="camp.id">
                                        <div class="col-md-4 col-6 profile-latest-img">
                                            <a :href="'#/company-campaign/detail/'+camp.id">
                                            <img class="rounded" :src="'../'+camp.banner_path" width="100" height="70" alt="" />
                                                <h6 class="text-center fw-bolder">{{ camp.title }}</h6>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ latest profile pictures -->
                    </div>
                    <!--/ Goal Overview Card -->

                    <!-- Info EMP -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card card-browser-states">
                            <div class="card-header border-top-secondary p-1">
                                <div>
                                    <h4 class="card-title fw-bolder"><i data-feather="tv"></i> Info EMP</h4>
                                    <!-- <p class="card-text font-small-2">Counter August 2020</p> -->
                                </div>
                                <div class="dropdown chart-dropdown">
                                    <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Last 28 Days</a>
                                        <a class="dropdown-item" href="#">Last Month</a>
                                        <a class="dropdown-item" href="#">Last Year</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Recent Posts -->
                            <div class="blog-recent-posts">
                                <div class="mt-0">
                                    <div class="d-flex mb-2" v-for="info in infoemp" :key="info.id">
                                        <router-link :to="`${ 'info-emp/detail/'+info.id }`" class="me-2">
                                            <img class="rounded" :src="'../'+info.banner_path" width="100" height="70" alt="" />
                                        </router-link>
                                        <div class="blog-info">
                                            <h6 class="blog-recent-post-title">
                                                <router-link :to="`${ 'info-emp/detail/'+info.id }`" class="text-body-heading">
                                                    {{ info.title }}
                                                </router-link>
                                            </h6>
                                            <div class="text-muted mb-0">{{ info.created_date }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Recent Posts -->
                            </div>
                        </div>
                    </div>
                    <!--/ Browser States Card -->
                </div> <!-- End Row -->
    </div>

</template>
<script>
import FeatherIcon from '../../@core/components/feather-icon/FeatherIcon.vue';

export default {
    props : ['infoemp','media','campaign'],
    components : {
        FeatherIcon
    },
    data(){
        return{
            defaultImage : 'default-image.png',
            galleryInfoEmp : [
                {
                    id : 0,
                    path_image : 'file-manager/info_emp/info-emp.png',
                    title : 'Corporate Online Class by R-Fitness',
                    created_date : '5 Oktober 201'
                }
            ]
        }
    },
    created() {

    }
}
</script>
