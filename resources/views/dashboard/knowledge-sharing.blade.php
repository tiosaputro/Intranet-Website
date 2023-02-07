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
                    <div class="card-body" style="background:#f8f8f8;">
                        <!-- twitter feed -->
                        @foreach($knowledgeSharing as $row)
                        <div class="profile-twitter-feed mt-2 bg-white p-2">
                            <div class="d-flex justify-content-start align-items-center mb-1">
                                <div class="avatar me-1">
                                    @if($row->photo_author != null)
                                    <img src="{{ asset($row->photo_author) }}" alt="avatar img" height="40" width="40" style="object-fit: cover;" />
                                    @else
                                    <img src="{{ asset('app-assets/images/avatars/12-small.png') }}" alt="avatar img" height="40" width="40" />
                                    @endif
                                </div>
                                <div class="profile-user-info">
                                    <h6 class="mb-0">{{ $row->author }}</h6>
                                    <a href="{{ url('knowledges-sharing/detail/'.$row->id) }}">
                                        <small class="text-muted">{{ $row->departement }}</small> |
                                        <small class="text-muted">{{ $row->author }}</small> |
                                        <i data-feather="calendar"></i> {{ humanDate($row->created_at) }}
                                    </a>
                                </div>
                                <div class="profile-star ms-auto">
                                    <i data-feather="star" class="font-medium-3 profile-favorite"></i>
                                </div>
                            </div>
                            <p class="card-text mb-50">
                                <a href="{{ url('knowledges-sharing/detail/'.$row->id) }}" class="text-dark">
                                     {{ Str::words($row->title, 6) }}
                                </a>
                            </p>
                            <a href="#">
                                @if(is_array($row->tags))
                                    @foreach($row->tags as $tg)
                                <small>
                                    {{ '#'.$tg }} &nbsp;
                                </small>
                                    @endforeach
                                @endif
                            </a>
                        </div>
                        <!-- end twitter feed -->
                        @endforeach
                    </div>
                </div>
                <!--/ twitter feed card -->

    </div>
    <!-- End Knowledge -->
