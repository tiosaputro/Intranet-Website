<div class="sidebar-detached sidebar-right">
    <div class="sidebar">
        <div class="blog-sidebar my-2 my-lg-0">
            <!-- Recent Posts -->
            <div class="blog-recent-posts">
                <h6 class="section-label">Upcoming Event</h6>
                <div class="mt-75">
                    @if(count($recentPost) < 1)
                    <div class="alert alert-danger">
                        <p>Tidak ada posting!</p>
                    </div>
                    @endif
                    @if(count($recentPost) > 0)
                    @foreach($recentPost as $row)
                    <div class="d-flex mb-2">
                        <a href="{{ url('calendar/detail/'.$row->id) }}" class="me-2">
                            @if(!empty($row->banner))
                            <img class="rounded" src="{{ asset($row->banner) }}" width="100" height="70" alt="Recent Post" style="object-fit: contain;" />
                            @else
                            <div class="avatar bg-light-primary rounded me-1">
                                <div class="avatar-content">
                                    <i data-feather="calendar" class="avatar-icon font-medium-3"></i>
                                </div>
                            </div>
                            @endif
                        </a>
                        <div class="blog-info">
                            <h6 class="blog-recent-post-title">
                                <a href="{{ url('calendar/detail/'.$row->id) }}" class="text-body-heading">
                                    {{ Str::words($row->title,6) }}
                                </a>
                            </h6>
                            <div class="text-muted mb-0">
                                <strong>{{ customTanggal($calendar->start_date, 'D, d M Y') }}</strong> <br/>
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
