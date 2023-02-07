    <div class="sidebar-detached sidebar-right">
        <div class="sidebar">
            <div class="blog-sidebar my-2 my-lg-0">
                <!-- Search bar -->
                <form action="{{ url('content/search') }}" method="GET">
                <div class="blog-search">
                    <div class="input-group input-group-merge">
                        <input type="text" name="q" class="form-control" placeholder="Search Info EMP" />
                        <span class="input-group-text cursor-pointer">
                            <i data-feather="search"></i>
                        </span>
                    </div>
                </div>
                </form>
                <!--/ Search bar -->
                <!-- Categories -->
                <div class="blog-categories mt-3">
                    <h6 class="section-label">Categories</h6>
                    <div class="mt-1">
                        @if(count($taggingCategory) > 0)
                        @foreach($taggingCategory as $tg)
                        <div class="d-flex justify-content-start align-items-center mb-75">
                            <a href="#" class="me-75">
                                <div class="avatar bg-light-info rounded">
                                    <div class="avatar-content">
                                        <i data-feather="hash" class="avatar-icon font-medium-1"></i>
                                    </div>
                                </div>
                            </a>
                            <a href="{{ url('content/search?q='.$tg) }}">
                                <div class="blog-category-title text-body">{{ $tg }}</div>
                            </a>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <!--/ Categories -->

                <!-- Recent Posts -->
                <div class="blog-recent-posts mt-3">
                    <h6 class="section-label">Recent Posts {{ strtoupper($news->category) }}</h6>
                    <div class="mt-75">
                        @if(count($recentPost) < 1)
                        <div class="alert alert-danger">
                            <p>Tidak ada posting!</p>
                        </div>
                        @endif
                        @if(count($recentPost) > 0)
                        @foreach($recentPost as $row)
                        <div class="d-flex mb-2">
                            <a href="{{ url('content/detail/'.$row->category.'/'.$row->id) }}" class="me-2">
                                <img class="rounded" src="{{ asset($row->banner_path) }}" width="100" height="70" alt="Recent Post" style="object-fit: contain;" />
                            </a>
                            <div class="blog-info">
                                <h6 class="blog-recent-post-title">
                                    <a href="{{ url('content/detail/'.$row->category.'/'.$row->id) }}" class="text-body-heading">
                                        {{ Str::words($row->title,6) }}
                                    </a>
                                </h6>
                                <div class="text-muted mb-0">
                                    {{ humanDate($row->updated_at) }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif

                    </div>
                </div>
                <!--/ Recent Posts -->

            </div>

        </div>
    </div>
