<template>
    <div class="col-lg-4 col-12" style="position:relative;">
                <!-- <div class="row match-height"> -->
                    <!-- Bar Chart - Orders -->
                    <!-- <div class="col-lg-12 col-md-12 col-12"> -->
                        <!-- Activity Timeline -->
                        <div class="card border-top-success border-3">
                            <h4 class="card-header">Aktivitas Terakhir</h4>
                            <div class="card-body pt-1">
                            <ul class="timeline ms-50">
                                <li class="timeline-item">
                                    <span class="timeline-point timeline-point-indicator"></span>
                                    <div class="timeline-event">
                                        <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                        <h6>Anda login</h6>
                                        <span class="timeline-event-time me-1">1 min ago</span>
                                        </div>
                                        <p>login at {{ currentDateTime() }}</p>
                                    </div>
                                </li>
                                <li class="timeline-item">
                                    <span class="timeline-point timeline-point-indicator"></span>
                                    <div class="timeline-event">
                                        <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                        <h6>Menu User Management</h6>
                                        <span class="timeline-event-time me-1">12 min ago</span>
                                        </div>
                                        <p>view  at {{ currentDateTime() }}</p>
                                    </div>
                                </li>
                                <li class="timeline-item">
                                    <span class="timeline-point timeline-point-indicator"></span>
                                    <div class="timeline-event">
                                        <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                        <h6>Menu User Management</h6>
                                        <span class="timeline-event-time me-1">12 min ago</span>
                                        </div>
                                        <p>view  at {{ currentDateTime() }}</p>
                                    </div>
                                </li>
                            </ul>
                            </div>
                        </div>
                        <!-- /Activity Timeline -->

                    <!-- </div> -->
                    <!--/ Bar Chart - Orders -->

                    <!-- User Online -->
                    <!-- <div class="col-lg-12 col-md-6 col-12">
                    <div class="card border-top-success border-3">
                        <div class="card-body">
                            <h4 class="text-title">User Online</h4>
                            <div class="demo-inline-spacing">
                                <div class="avatar pull-up">
                                <img
                                    src="app-assets/images/portrait/small/avatar-s-20.jpg"
                                    alt="avatar"
                                    width="32"
                                    height="32"
                                />
                                <span class="avatar-status-online"></span>
                                </div>
                                <div class="avatar">
                                 <img
                                    src="app-assets/images/portrait/small/avatar-s-5.jpg"
                                    alt="Avatar"
                                    height="32"
                                    width="32"
                                />
                                <span class="avatar-status-online"></span>
                                </div>
                                <div class="avatar">
                                <img
                                    src="app-assets/images/portrait/small/avatar-s-12.jpg"
                                    alt="Avatar"
                                    height="32"
                                    width="32"
                                />
                                <span class="avatar-status-online"></span>
                                </div>
                                <div class="avatar">
                                <img
                                    src="app-assets/images/portrait/small/avatar-s-9.jpg"
                                    alt="Avatar"
                                    height="32"
                                    width="32"
                                />
                                <span class="avatar-status-online"></span>
                                </div>
                                <div class="avatar">
                                <img
                                    src="app-assets/images/portrait/small/avatar-s-10.jpg"
                                    alt="Avatar"
                                    height="32"
                                    width="32"
                                />
                                <span class="avatar-status-online"></span>
                                </div>
                                <div class="avatar">
                                <img
                                    src="app-assets/images/portrait/small/avatar-s-11.jpg"
                                    alt="Avatar"
                                    height="32"
                                    width="32"
                                />
                                <span class="avatar-status-online"></span>
                                </div>
                                <div class="avatar pull-up">
                                <img
                                    src="app-assets/images/portrait/small/avatar-s-20.jpg"
                                    alt="avatar"
                                    width="32"
                                    height="32"
                                />
                                <span class="avatar-status-online"></span>
                                </div>
                                <div class="avatar">
                                 <img
                                    src="app-assets/images/portrait/small/avatar-s-5.jpg"
                                    alt="Avatar"
                                    height="32"
                                    width="32"
                                />
                                <span class="avatar-status-online"></span>
                                </div>
                                <div class="avatar">
                                <img
                                    src="app-assets/images/portrait/small/avatar-s-12.jpg"
                                    alt="Avatar"
                                    height="32"
                                    width="32"
                                />
                                <span class="avatar-status-online"></span>
                                </div>
                                <div class="avatar">
                                <img
                                    src="app-assets/images/portrait/small/avatar-s-9.jpg"
                                    alt="Avatar"
                                    height="32"
                                    width="32"
                                />
                                <span class="avatar-status-online"></span>
                                </div>
                                <div class="avatar">
                                <img
                                    src="app-assets/images/portrait/small/avatar-s-10.jpg"
                                    alt="Avatar"
                                    height="32"
                                    width="32"
                                />
                                <span class="avatar-status-online"></span>
                                </div>

                            </div>
                        </div>
                    </div> -->
                    <!-- </div> -->
                    <!--/ Earnings Card -->
                <!-- </div> -->
    </div>

</template>
<style scoped>
::-webkit-scrollbar{ width: 4px;}
::-webkit-scrollbar-track {
  background: #f1f1f1;
}
::-webkit-scrollbar-thumb {
  background: #888;
}
::-webkit-scrollbar-thumb:hover {
  background: #555;
}
</style>
<script>
export default {
    methods : {
        currentDateTime() {
            const current = new Date();
            const date = current.getDate()+'/'+(current.getMonth()+1)+'/'+current.getFullYear();
            const time = current.getHours() + ":" + current.getMinutes() + ":" + current.getSeconds();
            const dateTime = date +' '+ time;
            return dateTime;
        }
    }
}
</script>
