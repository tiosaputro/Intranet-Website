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
                <h3>Roles List</h3>
                <p class="mb-2">
                    Management Role, Menu, Permission
                </p>
                <!-- Role cards -->
                @include('layout_web.notif-alert')

                <div class="row">

                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="d-flex align-items-end justify-content-center h-100">
                                        <img src="../../../app-assets/images/illustration/faq-illustrations.svg" class="img-fluid mt-2" alt="Image" width="85" />
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="card-body text-sm-end text-center ps-sm-0">
                                        <a href="javascript:void(0)" data-bs-target="#addRoleModal" data-bs-toggle="modal" class="stretched-link text-nowrap add-new-role">
                                            <span class="btn btn-primary mb-1">Add New Role</span>
                                        </a>
                                        <p class="mb-0">Add role, if it does not exist</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach($datatable as $row)
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <span>Total {{ $row->hasUserRole->count() }} users</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                                    <div class="role-heading">
                                        <h4 class="fw-bolder">{{ $row->name }}</h4>
                                        <a href="javascript:;" onclick="resetCheck({{ $row->id }})" class="role-edit-modal" data-bs-toggle="modal" data-bs-target="#editRoleModal_{{ $row->id }}">
                                            <small class="fw-bolder">Setting Access</small>
                                        </a>
                                    </div>
                                    @if($row->active == 1)
                                    <a href="javascript:void(0);" class="text-body">
                                        <span class="badge badge-glow bg-success"><i data-feather="check-circle"></i> Active</span>
                                    </a>
                                    @else
                                    <a href="javascript:void(0);" class="text-body">
                                        <span class="badge badge-glow bg-danger"><i data-feather="x-circle"></i> Inactive</span>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-danger" style="float:right;" onclick="removeData('{{ $row->id }}')">
                                        <i data-feather="x"></i>
                                    </a>
                                    @endif
                                </div>
                                                <!-- Add Role Modal -->
                <div class="modal fade" id="editRoleModal_{{ $row->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="zoom:87%;">
                                <div class="text-center">
                                    <h3 class="text-title">Role {{ $row->name }} - Menu Permission</h3>
                                </div>
                                <!-- Edit role form -->
                                <form id="editRoleForm_{{ $row->id }}" class="" method="post" action="{{ url('backend/role-modul/'.$row->id) }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="idrole" value="{{ $row->id }}">
                                    <div class="form-check me-3 me-lg-5" style="float:right;">
                                        <input type="checkbox" class="form-check-input" id="{{ $row->id }}_active" name="active" {{ ($row->active) ? 'checked' : '' }}> Status Role ?
                                    </div>
                                    <div class="col-12">
                                        <h4 class="">Menu Permissions</h4>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="slug" value="{{ $row->slug }}" class="form-control" placeholder="slug">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="name_role" value="{{ $row->name }}" class="form-control" placeholder="Name Role">
                                            </div>
                                        </div>
                                        <!-- Permission table -->
                                        <div class="table-responsive">
                                            <table class="table table-flush-spacing">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-nowrap fw-bolder">
                                                            <b class="text-primary">Super Administrator Access</b>
                                                            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system">
                                                                <i data-feather="info"></i>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="selectAll_{{ $row->id }}" onclick="checkAllForm({{ $row->id }}, this)" name="all" />
                                                                <label class="form-check-label" for="selectAll"> Select All </label>
                                                                &nbsp; &nbsp;
                                                                <a href="javascript:void(0);" onclick="rollbackCheck()" class="text-body">
                                                                    <span class="badge badge-glow bg-danger"><i data-feather="x-circle"></i> Reset Checked </span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @foreach($m_menu as $menus)
                                                    <!-- not submenu -->
                                                    @if($menus->is_parent == '#' && count($menus->submenu) == 0)
                                                    <tr>
                                                        <td class="text-nowrap fw-bolder">{{ $menus->menu_name }}</td>
                                                        <td>
                                                            <div class="d-flex">
                                                                @foreach($permission as $permissions)
                                                                <?php
                                                                $exist = false;
                                                                if($row->hasRoleMenuPermission->count() > 0){
                                                                 $exist = checkValueExist($menus->id.'_'.$permissions->name, $row->hasRoleMenuPermission);
                                                                }
                                                                ?>
                                                                @if(strtolower($permissions->name) == 'view')
                                                                <div class="form-check me-3 me-lg-5">
                                                                    <input class="form-check-input"
                                                                    name="checklist[]"
                                                                    type="checkbox"
                                                                    value="{{ $menus->id.'_'.$permissions->name }}"
                                                                    id="{{ $row->id }}_permit_{{ $menus->id.'_'.$permissions->id }}" {{ ($exist) ? 'checked' : '' }} />
                                                                    <label class="form-check-label" for="userManagementRead"> {{ $permissions->name }} </label>
                                                                </div>
                                                                @endif
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @else
                                                    <tr>
                                                        <td class="text-nowrap fw-bolder">{{ $menus->menu_name }}</td>
                                                        <td>
                                                            <div class="d-flex">
                                                                @foreach($permission as $permissions)
                                                                <?php
                                                                $exist = false;
                                                                if($row->hasRoleMenuPermission->count() > 0){
                                                                 $exist = checkValueExist($menus->id.'_'.$permissions->name, $row->hasRoleMenuPermission);
                                                                }
                                                                ?>
                                                                @if(strtolower($permissions->name) == 'view')
                                                                <div class="form-check me-3 me-lg-5">
                                                                    <input class="form-check-input"
                                                                    name="checklist[]"
                                                                    type="checkbox"
                                                                    value="{{ $menus->id.'_'.$permissions->name }}"
                                                                    id="{{ $row->id }}_permit_{{ $menus->id.'_'.$permissions->id }}" {{ ($exist) ? 'checked' : '' }} />
                                                                    <label class="form-check-label" for="userManagementRead"> {{ $permissions->name }} </label>
                                                                </div>
                                                                @endif
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <!-- submenu -->
                                                    @if(count($menus->submenu) > 0)
                                                    @foreach($menus->submenu as $submenus)
                                                    <tr>
                                                        <td class="text-nowrap fw-bolder">&nbsp;&nbsp; <i data-feather="minus-square"></i> {{ $submenus['menu_name'] }}</td>
                                                        <td>
                                                            <div class="d-flex">
                                                                @foreach($permission as $permissions)
                                                                <?php
                                                                $exist = false;
                                                                if($row->hasRoleMenuPermission->count() > 0){
                                                                 $exist = checkValueExist($submenus['id'].'_'.$permissions->name, $row->hasRoleMenuPermission);
                                                                }
                                                                ?>
                                                                <div class="form-check me-3 me-lg-5">
                                                                    <input class="form-check-input"
                                                                    name="checklist[]"
                                                                    type="checkbox"
                                                                    value="{{ $submenus['id'].'_'.$permissions->name }}"
                                                                    id="{{ $row->id }}_permit_{{ $submenus['id'].'_'.$permissions->id }}" {{ ($exist) ? 'checked' : '' }} />
                                                                    <label class="form-check-label" for="userManagementRead"> {{ $permissions->name }} </label>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                    </tr>
                                                        <!-- child menu -->
                                                        @if(count($submenus['child']) > 0)
                                                        @foreach($submenus['child'] as $childs)
                                                            <tr>
                                                                <td>&nbsp; &nbsp; &nbsp; &nbsp; <i data-feather="plus-circle"></i> <strong class="text-info">{{ $childs['menu_name'] }}</strong></td>
                                                                <td colspan="4"></td>
                                                            </tr>
                                                        @endforeach
                                                        @endif
                                                        <!-- end child menu -->

                                                    @endforeach
                                                    @endif

                                                    @endif

                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Permission table -->
                                    </div>
                                    <div class="col-12 text-center mt-2">
                                        <button type="submit" name="submit_edit" class="btn btn-primary me-1">Submit</button>
                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                            Close
                                        </button>
                                    </div>
                                </form>
                                <!--/ edit role form -->
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ edit Role Modal -->
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <br/>
                    <br/>
                    <div class="pagination mt-10">
                        {{ $datatable->appends(['sort' => 'name'])->links() }}
                    </div>
                </div>
                <!--/ Role cards -->
                <!-- Add Role Modal -->
                <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-5 pb-5">
                                <div class="text-center mb-4">
                                    <h1 class="role-title">Add Role</h1>
                                </div>
                                <!-- Add role form -->
                                <form class="add-new-user" id="add-form">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" id="id">
                                        <div class="alert alert-danger p-2" id="error" style="display:none;">
                                            <p id="message-error"></p>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="basic-icon-default-menuname">Nama Role</label>
                                            <input type="text" class="form-control dt-menu-name" id="basic-icon-default-menuname" placeholder="" name="name" required/>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" name="active"> Aktif ?
                                        </div>
                                        <div class="col-md-6 mt-5">
                                        <button type="submit" id="submit" class="btn btn-primary me-1 data-submit">Submit</button>
                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                </form>
                                <!--/ Add role form -->
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Add Role Modal -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
<!-- END: Content-->
@endsection
@push('page-js')
<script>
var path = `{{ url('backend/role') }}`;
var fetch = `{{ url('backend/role/get-list') }}`;
</script>
{{-- <script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script> --}}
<script src="{{ asset('js/pages/helpers.js?v='.date('ymdhis')) }}"></script>
<script src="{{ asset('js/pages/list-role.js?v='.date('ymdhis')) }}"></script>

@endpush

