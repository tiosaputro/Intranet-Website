    <!-- Media Highlights -->
    <div class="col-lg-4 col-md-6 col-12">
        <div class="card card-browser-states">
            <div class="card-header p-1">
                <div>
                    <h4 class="card-title fw-bolder"><i data-feather="tv"></i> Media Highlights</h4>
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
            <div class="card-body" style="background:#f8f8f8;">
                <!-- Recent Posts -->
            <div class="blog-recent-posts mt-2">
                <div class="mt-0">
                    @foreach($media as $row)
                    <div class="d-flex mb-2">
                        <a href="{{ url('content/detail/'.$row->category.'/'.$row->id) }}" class="me-2">
                            <img class="rounded" src="{{ $row->banner_path }}" width="100" height="70" alt="" style="object-fit: cover;" />
                        </a>
                        <div class="blog-info">
                            <h6 class="blog-recent-post-title">
                                <a href="{{ url('content/detail/'.$row->category.'/'.$row->id) }}" class="text-body-heading">
                                    {{ Str::words($row->title, 6) }}
                                </a>
                            </h6>
                            <div class="text-muted mb-0">{{ humanDate($row->created_at) }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!--/ Recent Posts -->
            </div>
        </div>
    </div>
    <!--/ Browser States Card -->
