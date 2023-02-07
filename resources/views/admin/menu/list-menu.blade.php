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
                        <div class="card-datatable table-responsive">
                            <table class="user-list-table table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Slug</th>
                                        <th>Menu</th>
                                        <th>Url/Path</th>
                                        <th>Parent Menu</th>
                                        <th>Order</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datatable as $idx => $row)
                                    <tr>
                                        <td>{{ $row->slug }}</td>
                                        <td>{!! ($row->icon) ? '<i data-feather="'.$row->icon.'"></i>' : ''; !!} {{ $row->menu_name }}</td>
                                        <td>{{ $row->url }}</td>
                                        <td class="text-center">{{ ($row->parent_name) ? $row->parent_name : '#' }}</td>
                                        <td>{{ $row->order }}</td>
                                        <td>{!! ($row->active == 1) ? '<span class="badge badge-glow bg-success"><i data-feather="check-circle"></i> Active</span>' : '<span class="badge badge-glow bg-danger"><i data-feather="x-circle"></i> Inactive</span>' !!}</td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-sm btn-primary" data-bs-toggle = "modal"
                                            data-bs-target = "#modals-slide-in" onclick="editData('{{ $row->id }}')">
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
                        <!-- Modal to add new user starts-->
                        <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
                            <div class="modal-dialog">
                                <form class="add-new-user modal-content pt-0" id="add-form">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" id="id">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                    <div class="modal-header mb-1">
                                        <h5 class="modal-title" id="title-modal">Add Menu</h5>
                                    </div>
                                    <div class="modal-body flex-grow-1">
                                        <div class="alert alert-danger p-2" id="error" style="display:none;">
                                            <p id="message-error"></p>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="basic-icon-default-slug">Slug</label>
                                            <input type="text" class="form-control dt-slug" id="basic-icon-default-slug" placeholder="" name="slug" required/>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="basic-icon-default-menuname">Nama Menu</label>
                                            <input type="text" class="form-control dt-menu-name" id="basic-icon-default-menuname" placeholder="" name="name" required/>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="basic-icon-default-menuname">URL / Path</label>
                                            <input type="text" class="form-control dt-menu-url" id="basic-icon-default-menuurl" placeholder="" name="url" required/>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="basic-icon-default-menuicon">Icon (<a href="https://feathericons.com" target="_blank">feather icon</a>)</label>
                                            <input type="text" class="form-control dt-menu-icon" id="basic-icon-default-menuicon" placeholder="" name="icon"/>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="basic-icon-default-menuorder">Order</label>
                                            <input type="number" class="form-control dt-menu-order" id="basic-icon-default-menuorder" placeholder="" name="order"/>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="basic-icon-default-menuorder">Child Menu / Parent</label>
                                            <select class="form-control dt-menu-parent select2 form-select" id="select2-basic" data-select2-id="select2-basic" name="is_parent" required>
                                                <option value="#">-- Parent Menu --</option>
                                                @foreach($datatable as $idx => $row)
                                                    {{-- @if($row->is_parent == '#') --}}
                                                    <option value="{{ $row->id }}">{{ $row->menu_name }}</option>
                                                    {{-- @endif --}}
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <input type="checkbox" class="checkbox" name="active"> Aktif ?
                                        </div>
                                        <div class="mb-2">
                                            <input type="checkbox" class="checkbox" name="hide_mobile"> Hide Mobile ?
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
var path = `{{ url('backend/menu') }}`;
var fetch = `{{ url('backend/menu/get-list') }}`;
</script>
<script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
<script src="{{ asset('js/pages/helpers.js?v='.date('ymdhis')) }}"></script>
<script src="{{ asset('js/pages/list-menu.js?v='.date('ymdhis')) }}"></script>
@endpush

