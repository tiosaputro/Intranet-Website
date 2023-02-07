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
                    <div class="row">
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="fw-bolder mb-75">{{ $totalUser }}</h3>
                                        <span>Total Users</span>
                                    </div>
                                    <div class="avatar bg-light-primary p-50">
                                        <span class="avatar-content">
                                            <i data-feather="user" class="font-medium-4"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="fw-bolder mb-75">{{ ($totalUser-$hasNotRole) }}</h3>
                                        <span>Users Has Role</span>
                                    </div>
                                    <div class="avatar bg-light-danger p-50">
                                        <span class="avatar-content">
                                            <i data-feather="user-plus" class="font-medium-4"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="fw-bolder mb-75">{{ $hasNotRole }}</h3>
                                        <span>Users Hasn't Role</span>
                                    </div>
                                    <div class="avatar bg-light-success p-50">
                                        <span class="avatar-content">
                                            <i data-feather="user-check" class="font-medium-4"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="fw-bolder mb-75">{{ $notActive }}</h3>
                                        <span>Inactive Users</span>
                                    </div>
                                    <div class="avatar bg-light-warning p-50">
                                        <span class="avatar-content">
                                            <i data-feather="user-x" class="font-medium-4"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- list and filter start -->
                    <div class="card">
                        {{-- <div class="card-body border-bottom"> --}}
                            {{-- <h4 class="card-title">Data User</h4> --}}
                            {{-- <div class="row">
                                <div class="col-md-4 user_role"></div>
                                <div class="col-md-4 user_plan"></div>
                                <div class="col-md-4 user_status"></div>
                            </div> --}}
                        {{-- </div> --}}
                        <div class="card-datatable table-responsive">
                            <table class="user-list-table table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datatable as $row)
                                    <tr>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->email }}</td>
                                        <td>{{ $row->nama_role }}</td>
                                        <td>{!! ($row->active == 1) ? '<span class="badge badge-glow bg-success"><i data-feather="check-circle"></i> Active</span>' : '<span class="badge badge-glow bg-danger"><i data-feather="x-circle"></i> Inactive</span>' !!}</td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-sm btn-primary" data-bs-toggle = "modal"
                                            data-bs-target = "#modals-slide-in" onclick="editUser('{{ $row->id }}')">
                                                <i data-feather="edit"></i> Edit User
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Modal to add new user starts-->
                        <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
                            <div class="modal-dialog">
                                <form class="add-new-user modal-content pt-0" id="add-form">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" id="id">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                    <div class="modal-header mb-1">
                                        <h5 class="modal-title" id="title-modal">Add User</h5>
                                    </div>
                                    <div class="modal-body flex-grow-1">
                                        <div class="alert alert-danger p-2" id="error" style="display:none;">
                                            <p id="message-error"></p>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="basic-icon-default-fullname">Nama Lengkap</label>
                                            <input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="" name="name" required/>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="basic-icon-default-email">Email</label>
                                            <input type="text" id="basic-icon-default-email" class="form-control dt-email" placeholder="john.doe@example.com" name="email" required/>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="basic-icon-default-email">Password</label>
                                            <input
                                                id="basic-icon-default-password"
                                                class="form-control"
                                                placeholder="******"
                                                name="password"
                                                type="password"
                                            />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="basic-icon-default-email">Re-Type Password</label>
                                            <input
                                                id="basic-icon-default-retypepassword"
                                                class="form-control"
                                                placeholder="******"
                                                name="retypepassword"
                                                type="password"
                                            />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="user-role">User Role</label>
                                            <!-- class="select2 form-select" id="select2-basic" -->
                                            <select class="select2 form-select" id="select2-multiple" name="role[]" multiple required>
                                                <option value="">Pilih Role</option>
                                                @foreach($role as $row)
                                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                            <div class="mb-2">
                                                <input type="checkbox" class="checkbox" name="active"> Aktif ?
                                        </div>
                                        <button type="submit" id="submit" class="btn btn-primary me-1 data-submit">Submit</button>
                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Modal to add new user Ends-->
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
var path = `{{ url('backend/admin-users') }}`;
var fetch = `{{ url('backend/get-admin-users') }}`;
</script>
<script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
<script src="{{ asset('js/pages/list-user.js?v='.date('ymdhis')) }}"></script>
@endpush

