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
                    <div class="card">
                        <div class="card-body border-bottom">
                            <h4 class="card-title">Content Broadcast & Banner</h4>
                            @include('layout_web.notif-alert')
                        </div>
                        <div class="card-datatable table-responsive">
                            <table class="user-list-table table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Type</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Created Date</th>
                                        @if ($superUser)
                                            <th>Publish Date</th>
                                            <th>Publisher</th>
                                        @endif
                                        <th>Status</th>
                                        <th>Notif</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($table as $row)
                                        <tr>
                                            <td>{{ $category[$row->type] }}</td>
                                            <td>{{ $row->title }}</td>
                                            <td>{{ $row->author }}</td>
                                            <td>{{ customTanggal($row->created_at, 'Y-m-d h:i') }}</td>
                                            @if ($superUser)
                                                <td>{{ customTanggal($row->updated_at, 'Y-m-d h:i') }}</td>
                                                <td>{{ $row->editor }}</td>
                                            @endif
                                            <td>{!! $row->active == 1
                                                ? '<span class="badge badge-glow bg-success"><i data-feather="check-circle"></i> Active</span>'
                                                : '<span class="badge badge-glow bg-danger"><i data-feather="x-circle"></i> Inactive</span>' !!}
                                            </td>
                                            <td>
                                                {!! $row->is_notif_mobile == 1
                                                    ? '<span class="badge badge-glow bg-primary"><i data-feather="check-circle"></i> Mobile </span>'
                                                    : '' !!}
                                                {!! $row->is_recurrence == 1
                                                    ? '<span class="badge badge-glow bg-success"><i data-feather="check-circle"></i> Recurrence <br/> ' .
                                                        $row->duration .
                                                        '</span>'
                                                    : '<span class="badge badge-glow bg-danger"><i data-feather="x-circle"></i></span>' !!}
                                            </td>
                                            <td>
                                                @include('layout_web.action')
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
    @if (!in_array('create', $permission))
        <script>
            $(window).on("load", function() {
                $(".add-new").hide();
            })
        </script>
    @endif
    <script src="{{ asset('js/pages/helpers.js?v=' . date('ymdhis')) }}"></script>
    <script src="{{ asset('js/pages/list-content.js?v=' . date('ymdhis')) }}"></script>
@endpush
