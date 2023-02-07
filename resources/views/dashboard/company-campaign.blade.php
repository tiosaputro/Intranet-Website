<div class="col-lg-4 col-md-6 col-12">
    <!-- latest profile pictures -->
    <div class="card">
            <div class="card-header p-1">
            <div><h4 class="card-title fw-bolder"><i data-feather="tv"></i> Company Campaign</h4></div>
            <div class="dropdown chart-dropdown">
                <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#">Lihat Semua</a>
                </div>
            </div>
            </div>
            <div class="card-body" style="background:#f8f8f8;">

                <div class="blog-recent-posts mt-2">
                    <div class="mt-0">
                        @foreach($campaign as $row)
                        <div class="col-md-12">
                        <div class="d-flex mb-2">
                            <a href="{{ url('content/detail/'.$row->category.'/'.$row->id) }}" class="me-2">
                                <img class="rounded" src="{{ $row->banner_path }}" width="100" height="70" alt="" style="object-fit: cover;"/>
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
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
        <!--/ latest profile pictures -->
</div>
