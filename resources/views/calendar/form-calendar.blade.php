                    <!-- Calendar Add/Update/Delete event modal-->
                    <div class="modal modal-slide-in event-sidebar fade" id="add-new-sidebar">
                        <div class="modal-dialog sidebar-lg">
                            <div class="modal-content p-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title">Add Calendar Event</h5>
                                </div>
                                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                    <form class="event-form needs-validation" data-ajax="false" novalidate method="POST"
                                        action="{{ url('calendar/store') }}" enctype="multipart/form-data" id="form">
                                        <div class="mb-1">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                placeholder="Event Title" required />
                                        </div>
                                        <div class="mb-1">
                                            <label for="select-label" class="form-label">Label</label>
                                            <select class="select2 select-label form-select w-100" id="select-label"
                                                name="category" required>
                                                @foreach ($category as $idx => $label)
                                                    <option data-label="{{ $categoryColor[$idx] }}"
                                                        value="{{ $label }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-1 position-relative">
                                            <label for="start-date" class="form-label">Start Date</label>
                                            <input type="text" class="form-control" id="start-date" name="start_date"
                                                placeholder="Start Date" />
                                        </div>
                                        <div class="mb-1 position-relative">
                                            <label for="end-date" class="form-label">End Date</label>
                                            <input type="text" class="form-control" id="end-date" name="end_date"
                                                placeholder="End Date" />
                                        </div>
                                        <div class="mb-1">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input allDay-switch"
                                                    id="customSwitch3" name="allDay" />
                                                <label class="form-check-label" for="customSwitch3">All Day</label>
                                            </div>
                                        </div>
                                        <div class="mb-1">
                                            <label for="event-url" class="form-label">Event URL / Link News &nbsp;
                                                <a href="{{ url('content/search') }}" target="_blank"><i data-feather="link"></i> Go to EMP News</a>
                                            </label>
                                            <input type="url" class="form-control" name="url" id="event-url"
                                                placeholder="https://www.google.com" />
                                        </div>
                                        <div class="mb-1 select2-primary">
                                            <label for="event-guests" class="form-label">Add PIC / Coordinator</label>
                                            <select class="select2 select-add-guests form-select w-100"
                                                id="event-guests" name="guests" multiple>
                                                @foreach ($users as $user)
                                                    @php
                                                        $photo = empty($user->profile) ? null : $user->profile->path_photo;
                                                        if (empty($photo) || $photo == 'undefined') {
                                                            $photo = 'app-assets/image_not_found.gif';
                                                        }
                                                    @endphp
                                                    <option data-avatar="{{ $photo }}"
                                                        value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="mb-1">
                                            <label for="event-location" class="form-label">Location</label>
                                            <input type="text" class="form-control" id="event-location"
                                                name="location" placeholder="Enter Location" />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label">Description</label>
                                            <textarea name="event-description-editor" id="event-description-editor" class="form-control"></textarea>
                                        </div>
                                        <div class="mb-1">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input repeat" id="repeat"
                                                    name="repeat" />
                                                <label class="form-check-label" for="repeat">Recurrence</label>
                                            </div>
                                            <div class="alert alert-info p-1 mt-1">*Make this a repeating event</div>
                                        </div>
                                        <div class="mb-1">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input push_notif" id="push_notif"
                                                    name="push_notif" />
                                                <label class="form-check-label" for="push_notif">Notification For Mobile</label>
                                            </div>
                                            <div class="alert alert-info p-1 mt-1">*Send Broadcast notification mobile</div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-12">
                                            <div class="mb-1">
                                                @if (in_array('create', $permission) || in_array('update', $permission))
                                                <label class="form-label fw-bold">Banner / Slider / Photo</label>
                                                <br/>
                                                <input type="file" name="file" placeholder="Choose image" id="image">
                                                @endif
                                                @if ($errors->has('file'))
                                                    <span class="text-danger">{{ $errors->first('file') }}</span>
                                                @endif
                                                <div class="col-md-12 mb-2 mt-2 image">
                                                        <img id="preview-image" class="lightboxed rounded" rel="group1" src="{{ asset('app-assets/image_not_found.gif') }}" width="120" height="120" style="max-height: 250px;" />
                                                </div>
                                                <div class="col-md-12 mb-2 mt-2 showimage border-2" style="display: none;">
                                                    <h3>Banner Event</h3>
                                                    <div id="showbanner"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 d-flex">
                                            @if (in_array('create', $permission) || in_array('update', $permission))
                                                <button type="submit"
                                                    class="btn btn-primary add-event-btn me-1">Add</button>
                                                <button type="submit"
                                                    class="btn btn-primary update-event-btn d-none me-1">Update</button>
                                            @endif
                                            {{-- <button
                                                class="btn btn-outline-danger btn-delete-event d-none">Delete</button> --}}
                                                <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                        <div id="showDetailCalendar"></div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Calendar Add/Update/Delete event modal-->
