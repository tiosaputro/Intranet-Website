<template>
    <div>
                <div class="row match-height">
                        <!-- Developer Meetup Card -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card card-developer-meetup">
                        <div class="card-header border-top-success p-1">
                            <h5 class="card-title fw-bolder"><i data-feather="award"></i> Upcoming Events</h5>
                            <div class="dropdown chart-dropdown">
                                <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Semua Event</a>
                                    <a class="dropdown-item" href="#">Last Month</a>
                                    <a class="dropdown-item" href="#">Last Year</a>
                                </div>
                            </div>
                        </div>
                        <div class="meetup-img-wrapper rounded-top text-center">
                            <img src="app-assets/images/illustration/email.svg" alt="Meeting Pic" height="170" />
                        </div>
                        <div class="card-body">
                            <div class="meetup-header d-flex align-items-center">
                                <div class="meetup-day">
                                    <h6 class="mb-0">Rabu</h6>
                                    <h3 class="mb-0">06</h3>
                                </div>
                                <div class="my-auto">
                                    <h4 class="card-title mb-25">Meet & Great EMP</h4>
                                    <p class="card-text mb-0">Evaluasi Kinerja</p>
                                </div>
                            </div>
                            <div class="d-flex flex-row meetings">
                                <div class="avatar bg-light-primary rounded me-1">
                                    <div class="avatar-content">
                                        <i data-feather="calendar" class="avatar-icon font-medium-3"></i>
                                    </div>
                                </div>
                                <div class="content-body">
                                    <h6 class="mb-0">Rabu, 06 Oktober 2021</h6>
                                    <small>10:AM to 6:PM</small>
                                </div>
                            </div>
                            <div class="d-flex flex-row meetings">
                                <div class="avatar bg-light-primary rounded me-1">
                                    <div class="avatar-content">
                                        <i data-feather="map-pin" class="avatar-icon font-medium-3"></i>
                                    </div>
                                </div>
                                <div class="content-body">
                                    <h6 class="mb-0">Room 27A </h6>
                                    <small>Bakrie Tower</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End Col -->
                <!--/ Developer Meetup Card -->
                <!-- Knowledges Sharing -->
                <div class="col-lg-4 col-md-6 col-12">
                        <!-- twitter feed card -->
                        <div class="card">
                            <div class="card-header border-top-success p-1">
                                <h5 class="card-title fw-bolder"><i data-feather="share" class="font-medium-2"></i> Knowledges Sharing</h5>
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
                                    <!-- twitter feed -->
                                    <div class="profile-twitter-feed mt-2" v-for="knowledge in dataKnowledge" :key="knowledge.id">
                                        <div class="d-flex justify-content-start align-items-center mb-1">
                                            <div class="avatar me-1">
                                                <img src="app-assets/images/avatars/12-small.png" alt="avatar img" height="40" width="40" />
                                            </div>
                                            <div class="profile-user-info">
                                                <h6 class="mb-0">{{ knowledge.author }}</h6>
                                                <a href="#">
                                                    <small class="text-muted">{{ knowledge.position }}</small>
                                                    <i data-feather="check-circle"></i>
                                                </a>
                                            </div>
                                            <div class="profile-star ms-auto">
                                                <i data-feather="star" class="font-medium-3 profile-favorite"></i>
                                            </div>
                                        </div>
                                        <p class="card-text mb-50">
                                            <router-link :to="`${ 'knowledge-sharings/detail/'+knowledge.id }`" class="text-dark"> {{ knowledge.title }} </router-link>
                                        </p>
                                        <a href="#">
                                            <small v-for="metatag in knowledge.tags" :key="metatag.id">
                                                {{ '#'+metatag }} &nbsp;
                                            </small>
                                        </a>
                                    </div>
                                    <!-- end twitter feed -->

                                </div>
                            </div>
                            <!--/ twitter feed card -->

                </div>
                <!-- End Knowledge -->

                <!-- Comodities -->
                    <!-- Transaction Card -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card card-transaction">
                            <div class="card-header border-top-success p-1">
                                <h4 class="card-title"><i class="font-medium-2" data-feather="trending-up"></i> Live Comodities</h4>
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
                                <!-- iframe -->
                                <iframe src="https://www.widgets.investing.com/live-commodities?theme=lightTheme&amp;pairs=8833,8849,8830,8836" width="100%" height="330" frameborder="0" allowtransparency="true" marginwidth="0" marginheight="0"></iframe>
                            </div>
                        </div>
                    </div>
                    <!--/ Transaction Card -->

                <!-- End Comodities -->

                </div> <!-- End Row -->
    </div>

</template>
<script>
export default {
    data(){
        return {
            dataKnowledge : [
                {
                    id : 0,
                    title : 'Tips Keselamatan Diri saat gempa bumi',
                    tags : [
                        "Safety Work", "Tips Keselamatan"
                    ],
                    author : 'Mr.Arief',
                    position : 'Kepala Departemen'
                }
            ]
        }
    }
}
</script>
