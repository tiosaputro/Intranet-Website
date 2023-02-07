    @if ($dataEvent->count() < 1)
        <div class="col-lg-4 col-md-6 col-12">
            <div class="card card-developer-meetup">
                <div class="alert alert-danger p-2 text-center">
                    <p>No Data Event!</p>
                </div>
            </div>
        </div>
    @else

        <div class="col-lg-4 col-md-6 col-12">

            <div class="card card-developer-meetup">
                <div class="card-header border-top-success p-1">
                    <h5 class="card-title fw-bolder"><i data-feather="award"></i> Upcoming Events</h5>
                    <div class="dropdown chart-dropdown">
                        <i data-feather="more-vertical" class="font-medium-3 cursor-pointer"
                            data-bs-toggle="dropdown"></i>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ url('calendar') }}">Semua Event</a>
                            <a class="dropdown-item" href="#">Last Month</a>
                            <a class="dropdown-item" href="#">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <section class="">
                        <div class="">
                            <div class="">
                                <div class="col-6 text-right">
                                    <a class="btn btn-sm btn-primary mb-3 mr-1" href="#calendarEmp" role="button" data-slide="prev">
                                        <i data-feather="chevrons-left"></i> Prev
                                    </a>
                                    <a class="btn btn-sm btn-primary mb-3 " href="#calendarEmp" role="button" data-slide="next">
                                        <i data-feather="chevrons-right"></i> Next
                                    </a>
                                </div>
                                <div class="col-12">
                                    <div id="calendarEmp" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            <!-- loop -->
                                            @foreach($dataEvent as $idx => $event)
                                            <div class="carousel-item {{ ($idx == 0) ? 'active' : '' }}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            @if(empty($event->banner))
                                                            <img class="img-fluid" src="{{ asset('app-assets/images/illustration/email.svg') }}">
                                                            @else
                                                            <img class="img-fluid" src="{{ asset($event->banner) }}">
                                                            @endif

                                                            <div class="card-body">
                                                                <h4 class="card-title">{{ \Str::title($event->title) }}</h4>
                                                                <p class="card-text">{{ \Str::words($event->description, 10, ' Selengkapnya >>>'); }}</p>
                                                                <div class="d-flex flex-row meetings">
                                                                    <div class="avatar bg-light-primary rounded me-1">
                                                                        <div class="avatar-content">
                                                                            <i data-feather="calendar" class="avatar-icon font-medium-3"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="content-body">
                                                                        <h6 class="mb-0">{{ customTanggal($event->start_date, 'D, d M Y') }}</h6>
                                                                        <small class="mb-0">{{ customTanggal($event->start_date, 'd M Y') }} sampai </small>
                                                                        <small class="mb-0">{{ customTanggal($event->end_date, 'd M Y') }}</small>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex flex-row meetings">
                                                                    <div class="avatar bg-light-primary rounded me-1">
                                                                        <div class="avatar-content">
                                                                            <i data-feather="map-pin" class="avatar-icon font-medium-3"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="content-body">
                                                                        <h6 class="mb-0">{{ $event->location }} </h6>
                                                                        @if(is_array($event->guest))
                                                                            PIC : {!! tagging_user(json_decode($event->guest,1)) !!}
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <!-- end row -->
                                            </div>
                                            @endforeach
                                            <!-- end loop -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div> <!-- End Col -->
    @endif
