<div class="modal fade show" id="app-file-manager-info-sidebar">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-0">
            <div class="modal-header d-flex align-items-center justify-content-between mb-1 p-2">
                <h5 class="modal-title" id="nama_file"></h5>
                <div>
                    <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal"></i>
                </div>
            </div>
            <div class="modal-body flex-grow-1 pb-sm-0 pb-1">
                <ul class="nav nav-tabs tabs-line" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#details-tabinfo" role="tab" aria-controls="details-tabinfo" aria-selected="true">
                            <i data-feather="file"></i>
                            <span class="align-middle ms-25">Details</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#activity-tabinfo" role="tab" aria-controls="activity-tabinfo" aria-selected="true">
                            <i data-feather="activity"></i>
                            <span class="align-middle ms-25">Activity</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="details-tabinfo" role="tabpanel" aria-labelledby="details-tabinfo">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <p class="mb-0 mt-1 text-center">
                                <span class="icon_view"></span>
                                <br/><br/>
                                <span class="description_view"></span>
                            </p>
                        </div>
                        <hr class="my-2" />
                        <h4 class="file-manager-title my-2">Info</h4>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <table class="table table-striped">
                                    <tr>
                                        <td>Title</td>
                                        <td><b id="info-title"></b></td>
                                    </tr>
                                    <tr>
                                        <td>Business Unit</td>
                                        <td><b id="info-bu"></b></td>
                                    </tr>
                                    <tr>
                                        <td>Category Library</td>
                                        <td><b id="info-category"></b></td>
                                    </tr>
                                    <tr>
                                        <td>SOP Number</td>
                                        <td><b id="info-sop"></b></td>
                                    </tr>
                                    <tr>
                                        <td>Location</td>
                                        <td><b id="info-location"></b></td>
                                    </tr>
                                    <tr>
                                        <td>Tags Relation</td>
                                        <td><b id="info-tags"></b></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 col-lg-6">
                                <table class="table table-striped">
                                    <tr>
                                        <td>Rev.No</td>
                                        <td><b id="info-revno"></b></td>
                                    </tr>
                                    <tr>
                                        <td>Issued</td>
                                        <td><b id="info-issued"></b></td>
                                    </tr>
                                    <tr>
                                        <td>Expired</td>
                                        <td><b id="info-expired"></b></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td><b id="info-status"></b></td>
                                    </tr>
                                    <tr>
                                        <td>Remark</td>
                                        <td><b id="info-remark"></b></td>
                                    </tr>
                                    <tr>
                                        <td>Note Rev</td>
                                        <td><b id="info-keterangan"></b></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="activity-tabinfo" role="tabpanel" aria-labelledby="activity-tabinfo">
                        <!-- Begin Content -->
                        <div class="log_activity"></div>
                        <!-- End Content -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade show" id="app-file-manager-info-sidebar-log">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-0">
            <div class="modal-header d-flex align-items-center justify-content-between mb-1 p-2">
                <h5 class="modal-title_log" id="nama_file"></h5>
                <div>
                    <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal"></i>
                </div>
            </div>
            <div class="modal-body flex-grow-1 pb-sm-0 pb-1">
                <ul class="nav nav-tabs tabs-line" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#details-tabinfolog" role="tab" aria-controls="details-tabinfolog" aria-selected="true">
                            <i data-feather="file"></i>
                            <span class="align-middle ms-25">Details</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#activity-tabinfolog" role="tab" aria-controls="activity-tabinfolog" aria-selected="true">
                            <i data-feather="activity"></i>
                            <span class="align-middle ms-25">Activity</span>
                        </a>
                    </li> --}}
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="details-tabinfolog" role="tabpanel" aria-labelledby="details-tabinfolog">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <p class="mb-0 mt-1 text-center">
                                <span class="icon_view_log"></span>
                                <br/><br/>
                                <span class="description_view_log"></span>
                            </p>
                        </div>
                        <hr class="my-2" />
                        <h4 class="file-manager-title my-2">Info</h4>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <table class="table table-striped">
                                    <tr>
                                        <td>Title</td>
                                        <td><b class="info-title_log"></b></td>
                                    </tr>
                                    <tr>
                                        <td>Business Unit</td>
                                        <td><b class="info-bu_log"></b></td>
                                    </tr>
                                    <tr>
                                        <td>Category Library</td>
                                        <td><b class="info-category_log"></b></td>
                                    </tr>
                                    <tr>
                                        <td>SOP Number</td>
                                        <td><b class="info-sop_log"></b></td>
                                    </tr>
                                    <tr>
                                        <td>Location</td>
                                        <td><b class="info-location_log"></b></td>
                                    </tr>
                                    <tr>
                                        <td>Tags Relation</td>
                                        <td><b class="info-tags_log"></b></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 col-lg-6">
                                <table class="table table-striped">
                                    <tr>
                                        <td>Rev.No</td>
                                        <td><b class="info-revno_log"></b></td>
                                    </tr>
                                    <tr>
                                        <td>Issued</td>
                                        <td><b class="info-issued_log"></b></td>
                                    </tr>
                                    <tr>
                                        <td>Expired</td>
                                        <td><b class="info-expired_log"></b></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td><b class="info-status_log"></b></td>
                                    </tr>
                                    <tr>
                                        <td>Remark</td>
                                        <td><b class="info-remark_log"></b></td>
                                    </tr>
                                    <tr>
                                        <td>Note Rev</td>
                                        <td><b class="info-keterangan_log"></b></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="tab-pane fade" id="activity-tabinfolog" role="tabpanel" aria-labelledby="activity-tabinfolog">
                        <!-- Begin Content -->
                        <div class="log_activity_log"></div>
                        <!-- End Content -->
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
</div>
