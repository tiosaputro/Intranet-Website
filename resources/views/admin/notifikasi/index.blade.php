@extends('layout_web.template')
<!-- BEGIN: Content-->
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- users list start -->
                <section class="app-user-list">
                    <!-- list and filter start -->
                    <div class="row">
                        <div class="col-md-12">
                            @if(Session::has('notifSuccess'))
                            <div class="col-md-12">
                                <div class="alert alert-success">
                                    <p class="p-1"><i data-feather="check-circle"></i> {{ Session::get('notifSuccess') }}</p>
                                </div>
                            </div>
                            @endif
                            @if(Session::has('error'))
                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                    <p class="p-1"><i data-feather="x-circle"></i> {{ Session::get('error') }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="card card-statistics">
                                <div class="card-header">
                                    <h4 class="card-title">Repeat Weekday Notification</h4>
                                    <div class="d-flex align-items-center">
                                        <p class="card-text font-small-2 me-25 mb-0">On this week</p>
                                    </div>
                                </div>
                                <div class="card-body statistics-body">
                                    <div class="row">
                                        <div class="col-xl-6 col-sm-6 col-12 mb-2 mb-xl-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-primary me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="link"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0">{{ $summary['news'] }}</h4>
                                                    <p class="card-text font-small-3 mb-0">Info & News</p>
                                                </div>
                                            </div>
                                            <span class="badge badge-primary badge-glow text-black bold">{{ ucwords($news['duration']).' at '.$news['at'] }}</span>
                                        </div>
                                        <div class="col-xl-6 col-sm-6 col-12 mb-2 mb-xl-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-info me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="globe"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0">{{ $summary['knowledge'] }}</h4>
                                                    <p class="card-text font-small-3 mb-0">Knowledge Sharing</p>
                                                </div>
                                            </div>
                                            <span class="badge badge-primary badge-glow text-black bold">{{ ucwords($knowledge['duration']).' at '.$knowledge['at'] }}</span>
                                        </div>
                                        <div class="col-xl-6 col-sm-6 col-12 mb-2 mt-xl-1">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-danger me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="book-open"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0">{{ $summary['library'] }}</h4>
                                                    <p class="card-text font-small-3 mb-0">Library</p>
                                                </div>
                                            </div>
                                            <span class="badge badge-primary badge-glow text-black bold">{{ ucwords($library['duration']).' at '.$library['at'] }}</span>
                                        </div>
                                        <div class="col-xl-6 col-sm-6 col-12 mt-xl-1">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-success me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="calendar"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0">{{ $summary['calendar'] }}</h4>
                                                    <p class="card-text font-small-3 mb-0">Calendar</p>
                                                </div>
                                            </div>
                                            <span class="badge badge-primary badge-glow text-black bold">{{ ucwords($calendar['duration']).' at '.$calendar['at'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 col-md-6">
                            <!-- Form Setting Recurring -->
                            <form action="{{ url('backend/notifikasi-repeat') }}" method="POST">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Setting Recurring</h4>
                                        <span class="alert alert-warning p-1">
                                            Note : Configuration change takes 2 hour.
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select class="form-control" name="category">
                                                @foreach($categoryNotif as $ct)
                                                    <option value="{{ $ct }}">{{ ucwords($ct) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Repeat On</label>
                                            <select class="form-control" name="duration">
                                                @foreach($recurrence_type as $row => $value)
                                                    <option value="{{ $value['frequency'] }}">{{ $value['title'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Repeat Time</label>
                                            <input type="time" class="form-control" name="at"
                                                placeholder="Repeat Time">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary"><i data-feather="edit"></i> Setting</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Setting Expired OTP Authentification -->
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ url('backend/notifikasi/update-otp') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Expired OTP (Day) </label>
                                                    <input type="number" class="form-control" name="expired_date" min="1" max="365"
                                                        placeholder="Hari" value="{{ $otp['expired_date'] }}"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Expired Time (Minute) </label>
                                                    <input type="number" class="form-control" name="expired_time" min="1" max="30"
                                                        placeholder="Hari" value="{{ $otp['expired_time'] }}"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-1 mt-2">
                                                    <div class="form-check form-switch form-check-primary">
                                                        <input type="checkbox" class="form-check-input" id="customSwitch10" name="active" {{ $otp['otp_active'] ? 'checked' : '' }} />
                                                        <label class="form-check-label" for="customSwitch10">
                                                            <span class="switch-icon-left"><i data-feather="check"></i></span>
                                                            <span class="switch-icon-right"><i data-feather="x"></i></span>
                                                        </label>
                                                        <span class="fw-bold">Status Fitur OTP ?</span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <hr/>
                                        <button type="submit" name="otp-set" class="btn btn-outline btn-sm btn-primary">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body border-bottom">
                            <h4 class="card-title">Notification Mobile App</h4>
                            @include('layout_web.notif-alert')
                        </div>
                        <div class="card-datatable table-responsive">
                            <table class="user-list-table table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:5%;">Type</th>
                                        <th>Title</th>
                                        <th>Link</th>
                                        <th>Author</th>
                                        <th>Created Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($table as $row)
                                        <tr>
                                            <td>{{ $row->category }}</td>
                                            <td>{{ $row->title }}</td>
                                            <td>{!! '<a href="' .
                                                $row->path .
                                                '" target="_blank" class="badge badge-glow bg-primary"><i data-feather="link"></i> Content </a>' !!}</td>
                                            <td>{{ $row->author_by }}</td>
                                            <td>{{ customTanggal($row->created_at, 'Y-m-d h:i') }}</td>
                                            <td><span class="badge badge-glow bg-success"><i
                                                        data-feather="check-circle"></i> Success</span></td>
                                            <td>
                                                <!-- Button Resend -->
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-resend-{{ $row->id }}">
                                                    <i data-feather="mail"></i> Resend
                                                </button>
                                                <!-- Modal Resend -->
                                                <div class="modal fade text-start" id="modal-resend-{{ $row->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="modal-resend-{{ $row->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="modal-resend-{{ $row->id }}">Resend
                                                                    Notification</h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure to resend this notification?
                                                                    <br />
                                                                    <strong>Title : <i>{{ $row->title }}</i></strong>
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-outline-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <a href="{{ url('backend/notifikasi/resend/' . $row->id) }}"
                                                                    class="btn btn-primary"><i data-feather="send"></i>
                                                                    Resend</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- users list ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
    <!-- END: Content-->
@endsection

@push('page-js')
    <script>
        var path = `{{ url($route) }}`;
    </script>

    <script src="{{ asset('js/pages/helpers.js?v=' . date('ymdhis')) }}"></script>
    <script src="{{ asset('js/pages/list-notifikasi.js?v=' . date('ymdhis')) }}"></script>
@endpush
