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
                        <div class="row">
                            <!-- Statistics Card -->
                           <div class="col-xl-12">
                               <div class="card card-statistics" style="margin-bottom:0 !important;">
                                   <div class="card-header">
                                       <h5 class="card-title">Statistics Library</h5>
                                       <div class="d-flex align-items-center">
                                           <p class="card-text font-small-2 me-0 mb-0">Updated {{ $lastUpdate }}</p>
                                       </div>
                                   </div>
                                   <div class="card-body statistics-body" style="padding:1rem !important; margin-left:10%;">
                                       <div class="row">
                                           <!-- Begin Loop -->
                                           @php $i = 0; @endphp
                                           @foreach($dashboard['data'] as $key => $value)
                                           <div class="col-sm-2  col-12 mb-2 mb-xl-0">
                                               <div class="d-flex flex-row">
                                                   <div class="avatar me-2" style="background: {{ $dashboard['color'][$i] }}">
                                                       <div class="avatar-content">
                                                           <i data-feather="{{ $dashboard['icon-feather'][$i] }}" class="avatar-icon"></i>
                                                       </div>
                                                   </div>
                                                   <div class="my-auto">
                                                       <h4 class="fw-bolder mb-0">{{ $value }}</h4>
                                                       <p class="card-text font-small-3 mb-0">{{ ucwords($key) }}</p>
                                                   </div>
                                               </div>
                                           </div>
                                           @php $i++; @endphp
                                           @endforeach
                                           <!-- End Start Loop -->

                                       </div>
                                   </div>
                               </div>
                           </div>
                       <!--/ Statistics Card -->
                           </div>
                    </div>
                    <div class="card">
                        <div class="border-bottom p-0">
                            @include('layout_web.notif-alert')
                        </div>
                        <div class="card-datatable table-responsive">
                            <table class="user-list-table table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Category</th>
                                        <th>SOP Number</th>
                                        <th>Title</th>
                                        <th>BU</th>
                                        <th>Owner</th>
                                        <th>Status Doc</th>
                                        <th>Issued</th>
                                        <th>Expired</th>
                                        <th>REV No.</th>
                                        <th>Remark</th>
                                        <th>Location</th>
                                        <th>Tags</th>
                                        <th>Link File</th>
                                        <th>Creator</th>
                                        <th>Last Update</th>
                                        <th>Created At</th>
                                        <th>Updater</th>
                                        <th>Updated At</th>
                                        <th>#</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($table as $row)
                                    <tr>
                                        <td>{{ $row->category_libraries }}</td>
                                        <td>{{ $row->sop_number }}</td>
                                        <td>{{ $row->title }}</td>
                                        <td>{{ $row->business_unit_name }}</td>
                                        <td>{{ $row->department->name }}</td>
                                        <td>{!! colorStatusLibrary($row->status) !!}</td>
                                        <td>{{ customTanggal($row->issued,'d M Y') }}</td>
                                        <td>{{ customTanggal($row->expired,'d M Y') }}</td>
                                        <td>{{ $row->rev_no }}</td>
                                        <td>{{ $row->remark }}</td>
                                        <td>{{ $row->location }}</td>
                                        <td>{{ implode(",",json_decode($row->tags_relation,1)) }}</td>
                                        <td>{{ asset($row->file_path) }}</td>
                                        <td>{{ $row->creator->name }}</td>
                                        <td>{{ $row->updater->name }}</td>
                                        <td>{{ customTanggal($row->created_at,'d M Y') }}</td>
                                        <td>{{ $row->updater->name }}</td>
                                        <td>{{ customTanggal($row->updated_at,'d M Y') }}</td>
                                        <td>{!! ($row->active == 1) ? '<span class="badge badge-glow bg-success"><i data-feather="check-circle"></i> Active</span>' : '<span class="badge badge-glow bg-danger"><i data-feather="x-circle"></i> Inactive</span>' !!}</td>
                                        <td>
                                            <a href="{{ url($route.'/edit/'.$row->id) }}" class="btn btn-sm btn-primary">
                                                <i data-feather="edit"></i> Edit
                                            </a>
                                            <a href="javascript:;" class="btn btn-sm btn-danger" onclick="removeData('{{ $row->id }}')">
                                                <i data-feather="x"></i> Delete
                                            </a>
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
<script src="{{ asset('js/pages/helpers.js?v='.date('ymdhis')) }}"></script>
<script src="{{ asset('js/pages/list-library-admin.js?v='.date('ymdhis')) }}"></script>
@endpush

