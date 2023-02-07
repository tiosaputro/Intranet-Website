<div class="modal fade show" id="app-file-manager-info-revision">
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
                        <a class="nav-link active" data-bs-toggle="tab" href="#details-tab" role="tab" aria-controls="details-tab" aria-selected="true">
                            <i data-feather="file"></i>
                            <span class="align-middle ms-25">Revision File</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#activity-tab" role="tab" aria-controls="activity-tab" aria-selected="true">
                            <i data-feather="activity"></i>
                            <span class="align-middle ms-25">Activity</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="details-tab" role="tabpanel" aria-labelledby="details-tab">
                        <div id="form-revision">
                            <h4 class="file-manager-title my-1">Settings</h4>
                            <form action="{{ url('library/revision') }}" enctype="multipart/form-data" method="POST">
                                {{ csrf_field() }}
                                <input id="id_library" type="hidden" name="id_library">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="row">
                                            <div class="col-md-6 ">
                                                <div class="mb-1">
                                                    <label class="form-label fw-bold">Business Unit</label>
                                                    <select name="business_unit_id" class="select2 form-select form-control" id="business_unit" required>
                                                        <option value="">--Business Unit--</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label fw-bold">Category Library</label>
                                                    <select name="category_libraries"  class="select2 form-select form-control" id="category" required>
                                                        <option value="">--Category--</option>
                                                    </select>
                                                    @if ($errors->has('category'))
                                                        <span class="text-danger">{{ $errors->first('category_libraries') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" />
                                            @if ($errors->has('title'))
                                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 col-md-6 col-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label fw-bold">SOP Number</label>
                                                        <input class="form-control" type="text" name="sop_number">
                                                        @if ($errors->has('sop_number'))
                                                            <span class="text-danger">{{ $errors->first('sop_number') }}</span>
                                                        @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label fw-bold">Rev No</label>
                                                        <input class="form-control" type="number" name="rev_no">
                                                        @if ($errors->has('rev_no'))
                                                            <span class="text-danger">{{ $errors->first('rev_no') }}</span>
                                                        @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-1 position-relative">
                                                    <label class="form-label fw-bold">Issued (Year-Month-Day)</label>
                                                    <input type="text" class="form-control pickadate-months-year" name="issued" placeholder="YYYY-MM-DD" />
                                                        @if ($errors->has('issued'))
                                                            <span class="text-danger">{{ $errors->first('issued') }}</span>
                                                        @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-1 position-relative">
                                                    <label class="form-label fw-bold">Expired (Year-Month-Day)</label>
                                                    <input type="text" class="form-control pickadate-months-year" name="expired" placeholder="YYYY-MM-DD" />
                                                        @if ($errors->has('expired'))
                                                            <span class="text-danger">{{ $errors->first('expired') }}</span>
                                                        @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label fw-bold">Status</label>
                                                    <select name="status" id="status"  class="form-select form-control" required>
                                                        <option value="">--Status--</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label fw-bold">Department/Division Owner</label>
                                                    <select name="devision_owner" id="department"  class="select2 form-select form-control" required>
                                                        <option value="">--Department--</option>
                                                    </select>
                                                        @if ($errors->has('devision_owner'))
                                                            <span class="text-danger">{{ $errors->first('devision_owner') }}</span>
                                                        @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label fw-bold">Remark</label>
                                                    <input type="text" class="form-control" name="remark"/>
                                                    @if ($errors->has('remark'))
                                                        <span class="text-danger">{{ $errors->first('remark') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label fw-bold">Location</label>
                                                    <input type="text" class="form-control" name="location"/>
                                                    @if ($errors->has('location'))
                                                        <span class="text-danger">{{ $errors->first('location') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label fw-bold">Change File Library</label>
                                                    <input type="file" name="file" placeholder="Choose File">
                                                    <br/>
                                                    <br/>
                                                    <div id="preview_file"></div>
                                                    @if ($errors->has('file'))
                                                        <span class="text-danger">{{ $errors->first('file') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label fw-bold">Tags Relation Document (Press Comma (,))</label>
                                                        <input class="form-control" type="text" name="tags_relation" id="edit_tags">
                                                        @if ($errors->has('tags_relation'))
                                                            <span class="text-danger">{{ $errors->first('tags_relation') }}</span>
                                                        @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-1 mt-2">
                                                    <input type="checkbox" name="active" class="checkbox form-check-input"> Status Active ?
                                                    @if ($errors->has('active'))
                                                    <span class="text-danger">{{ $errors->first('active') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-1 mt-2">
                                                    <label class="form-label fw-bold"><strong>Description Revision</strong></label>
                                                    <textarea name="keterangan" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                    <div class="col-xl-12 col-12 mt-3">
                                        <button type="submit" class="btn btn-primary me-1 data-submit">Update Document</button>
                                        <a href="#close" data-bs-dismiss="modal" class="btn btn-outline-secondary">Cancel</a>
                                    </div>
                                    </div>

                                    </div> <!-- End row -->
                            </form>
                        </div> <!-- End Form Revision -->
                        <hr class="my-2" />
                    </div> <!-- End Form Revision -->
                    <div class="tab-pane fade" id="activity-tab" role="tabpanel" aria-labelledby="activity-tab">
                        <!-- Begin Content -->
                        <div id="log_activity"></div>
                        <!-- End Content -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
