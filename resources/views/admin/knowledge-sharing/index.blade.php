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
                            <h4 class="card-title">{{ $modul }}</h4>
                            <div class="row">
                                @if(Session::has('success'))
                                <div class="col-md-12">
                                    <div class="alert alert-success">
                                        <p class="p-1"><i data-feather="check-circle"></i> {{ Session::get('success') }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-datatable table-responsive">
                            <table class="user-list-table table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Departement</th>
                                        <th>Title</th>
                                        <th>Tags</th>
                                        <th>Author</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($table as $row)
                                    <tr>
                                        <td>{{ $row->departement }}</td>
                                        <td>{{ $row->title }}</td>
                                        <td>
                                        @if(is_array(json_decode($row->meta_tags,1)))
                                            @foreach(json_decode($row->meta_tags,1) as $tg)
                                                <small>
                                                    {{ '#'.$tg }} &nbsp;
                                                </small>
                                            @endforeach
                                        @endif
                                        </td>
                                        <td>{{ $row->author }}</td>
                                        <td>{!! ($row->active == 1) ? '<span class="badge badge-glow bg-success"><i data-feather="check-circle"></i> Publish</span>' : '<span class="badge badge-glow bg-danger"><i data-feather="x-circle"></i></span>' !!}</td>
                                        <td>{{ customTanggal($row->created_at,'Y-m-d H:i') }}</td>
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
var path = `{{ url('/backend/management-knowledge-sharing') }}`;
</script>
@if(!in_array('create', $permission))
<script>
    $(window).on("load", function() {
        $(".add-new").hide();
    })
</script>
@endif
<script src="{{ asset('js/pages/helpers.js?v='.date('ymdhis')) }}"></script>
<script src="{{ asset('js/pages/list-content.js?v='.date('ymdhis')) }}"></script>
@endpush

