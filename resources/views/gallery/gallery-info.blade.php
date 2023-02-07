<div class="modal modal-slide-in fade show" id="app-file-manager-info-sidebar">
    <div class="modal-dialog sidebar-lg">
        <div class="modal-content p-0">
            <div class="modal-header d-flex align-items-center justify-content-between mb-1 p-2">
                <h5 class="modal-title" id="nama_file"></h5>
                <div>
                    {{-- <i data-feather="trash" class="cursor-pointer me-50" data-bs-dismiss="modal"></i> --}}
                    <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal"></i>
                </div>
            </div>
            <div class="modal-body flex-grow-1 pb-sm-0 pb-1">
                <ul class="nav nav-tabs tabs-line" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#details-tab" role="tab" aria-controls="details-tab" aria-selected="true">
                            <i data-feather="file"></i>
                            <span class="align-middle ms-25">Details</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#activity-tab" role="tab" aria-controls="activity-tab" aria-selected="true">
                            <i data-feather="activity"></i>
                            <span class="align-middle ms-25">Activity</span>
                        </a>
                    </li> --}}
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="details-tab" role="tabpanel" aria-labelledby="details-tab">
                        <div class="d-flex flex-column justify-content-center align-items-center py-5">
                            <div class="flex-column alert alert-primary text-center justify-content-center border-3">
                            <span id="icon_view"></span>
                            <p class="mb-0 mt-1">
                                <span class="icon_view"></span>
                                <span class="description_view text-bold text-center"></span>
                                <br/>
                                <span class="download_file"></span>
                            </p>
                            </div>
                        </div>
                        <div id="form-detail" style="display:none;">
                            <h4 class="file-manager-title my-1">Settings</h4>
                            <form action="{{ url('gallery/update') }}" method="post">
                                {{ csrf_field() }}
                                <input id="id_gallery" type="hidden" name="id_gallery">
                                <input id="type_gallery" type="hidden" name="type_gallery">
                            <ul class="list-unstyled">
                                @if(in_array('moderasi', $permission))
                                <li class="flex justify-content-between align-items-center mb-1">
                                    <span>Publish</span>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="private" name="is_public" />
                                        <label class="form-check-label" for="private"></label>
                                    </div>
                                </li>
                                @else
                                <input type="hidden" class="form-check-input" id="private" name="is_public" value="off" />
                                    @if(in_array('create', $permission) || in_array('update', $permission))
                                        <div id="notif_publish"></div>
                                    @endif
                                @endif
                                <li class="flex justify-content-between align-items-center mb-1 setting" style="display: none;">
                                    <span>Important</span>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="important" name="is_important" />
                                        <label class="form-check-label" for="important"></label>
                                    </div>
                                </li>
                                <li>
                                    <span>File Name</span>
                                    <input type="text" name="name" class="form-control">
                                    <br/>
                                    <span>Description</span>
                                    <textarea name="description" class="form-control"></textarea>
                                </li>
                                @if(in_array('create', $permission) || in_array('update', $permission) || in_array('moderasi', $permission))
                                <li class="flex justify-content-between align-items-center mb-1">
                                    <br/>
                                    <br/>
                                    <button name="submit" type="submit" class="btn btn-primary">Save</button>
                                </li>
                                @endif
                            </ul>
                            </form>
                        </div>
                        <hr class="my-2" />
                        <h4 class="file-manager-title my-2">Info</h4>
                        <ul class="list-unstyled border p-1">
                            <li class="d-flex justify-content-between align-items-center">
                                <p>Type</p>
                                <p class="fw-bold" id="type_view"></p>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <p>Viewer <i data-feather="eye"></i></p>
                                <p class="fw-bold" id="total_viewer_view"></p>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <p>Size</p>
                                <p class="fw-bold size_view"></p>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <p>Owner</p>
                                <p class="fw-bold" id="owner_view"></p>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <p>Created</p>
                                <p class="fw-bold" id="created_at"></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
