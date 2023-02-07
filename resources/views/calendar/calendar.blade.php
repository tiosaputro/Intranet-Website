@extends('layout_web.template')
<!-- BEGIN: Content-->
@section('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-calendar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-validation.css') }}">
@endsection
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Full calendar start -->
                <section>
                    <div class="app-calendar overflow-hidden border">
                        <div class="row g-0">
                            <!-- Sidebar -->
                            <div class="col app-calendar-sidebar flex-grow-0 overflow-hidden d-flex flex-column"
                                id="app-calendar-sidebar">
                                <div class="sidebar-wrapper">
                                    <div class="card-body d-flex justify-content-center">
                                        @if (in_array('create', $permission) || in_array('update', $permission))
                                            <button class="btn btn-primary btn-toggle-sidebar w-100" data-bs-toggle="modal"
                                                data-bs-target="#add-new-sidebar">
                                                <span class="align-middle">Add Event</span>
                                            </button>
                                        @endif
                                    </div>
                                    <div class="card-body pb-0">
                                        <h5 class="section-label mb-1">
                                            <span class="align-middle">Filter</span>
                                        </h5>
                                        <div class="form-check mb-1">
                                            <input type="checkbox" class="form-check-input select-all" id="select-all"
                                                checked />
                                            <label class="form-check-label" for="select-all">View All</label>
                                        </div>
                                        <div class="calendar-events-filter">
                                            <?php $obj = new StdClass(); ?>
                                            @foreach ($category as $idx => $label)
                                                <div class="form-check form-check-{{ $categoryColor[$idx] }} mb-1">
                                                    <input type="checkbox" class="form-check-input input-filter"
                                                        id="{{ strtolower($label) }}"
                                                        data-value="{{ strtolower($label) }}" checked />
                                                    <label class="form-check-label"
                                                        for="{{ strtolower($label) }}">{{ $label }}</label>
                                                </div>
                                                <?php
                                                //parse color
                                                $obj->$label = $categoryColor[$idx];
                                                ?>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-auto">
                                    <img src="../../../app-assets/images/pages/calendar-illustration.png"
                                        alt="Calendar illustration" class="img-fluid" />
                                </div>
                            </div>
                            <!-- /Sidebar -->

                            <!-- Calendar -->
                            <div class="col position-relative">
                                <div class="card shadow-none border-0 mb-0 rounded-0">
                                    <div class="card-body pb-0">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Calendar -->
                            <div class="body-content-overlay"></div>
                        </div>
                    </div>
                    @include('calendar.form-calendar')
                </section>
                <!-- Full calendar end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('page-js')
    <script>
        var urlPost = `{{ url('calendar/store') }}`;
        var dataCalendar = `<?php echo json_encode($dataCalendar); ?>`;
        var colorCalendar = `<?php echo json_encode((object) $obj); ?>`;
        var defaultImage = `{{ asset("app-assets/image_not_found.gif") }}`;
    </script>
    <script src="{{ asset('app-assets/vendors/js/calendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('js/pages/calendar.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/pages/app-calendar.js') }}"></script>
@endpush
