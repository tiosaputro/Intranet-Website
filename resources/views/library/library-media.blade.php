@extends('layout_web.template')
@section('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/pickers/form-pickadate.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/jstree.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-file-manager.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/ext-component-tree.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/file-uploaders/dropzone.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-file-uploader.css') }}">
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<link href="{{ asset('app-assets/tags-input/css/amsify.suggestags.css') }}" rel="stylesheet"/>
@endsection
<!-- BEGIN: Content-->
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content file-manager-application">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-area-wrapper container-xxl p-0">
            <div class="sidebar-left">
                <div class="sidebar">
                    <div class="sidebar-file-manager">
                        <div class="sidebar-inner">
                            <!-- sidebar list items starts  -->
                            @include('library.library-sidebar')
                            <!-- side bar list items ends  -->
                        </div>
                    </div>

                </div>
            </div>
            <div class="content-right">
                <div class="content-wrapper container-xxl p-0">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
                        <!-- overlay container -->
                        <div class="body-content-overlay"></div>

                        <!-- file manager app content starts -->
                        <div class="file-manager-main-content">
                            <!-- search area start -->
                            <div class="file-manager-content-header d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="sidebar-toggle d-block d-xl-none float-start align-middle ms-1">
                                        <i data-feather="menu" class="font-medium-5"></i>
                                    </div>
                                    <div class="input-group input-group-merge shadow-none m-0 flex-grow-1">
                                        <span class="input-group-text border-0">
                                            <i data-feather="search"></i>
                                        </span>
                                        <input type="text" class="form-control files-filter border-0 bg-transparent" placeholder="Search" />
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    @if(in_array('create', $permission) || in_array('update', $permission))
                                    {{-- @include('library.library-action-check') --}}
                                    @endif
                                    <div class="btn-group view-toggle ms-50" role="group" style="cursor: pointer;">
                                        <input type="radio" class="btn-check" name="view-btn-radio" data-view="grid" id="gridView" checked autocomplete="off" />
                                        <label class="btn btn-outline-primary p-50 btn-sm" for="gridView">
                                            <i data-feather="grid"></i>
                                        </label>
                                        <input type="radio" class="btn-check" name="view-btn-radio" data-view="list" id="listView" autocomplete="off" />
                                        <label class="btn btn-outline-primary p-50 btn-sm" for="listView">
                                            <i data-feather="list"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- search area ends here -->

                            <div class="file-manager-content-body">

                                @include('layout_web.notif-alert')

                                <!-- Files Container Starts -->
                                @include('library.library-file')
                                <!-- /Files Container Ends -->
                            </div>
                        </div>
                        <!-- file manager app content ends -->

                        <!-- File Info Sidebar Starts-->
                        @include('library.library-revision')
                        @include('library.library-info')
                        <!-- File Info Sidebar Ends -->

                        <!-- File Dropdown Starts-->
                        <div class="dropdown-menu dropdown-menu-end file-dropdown" style="left:auto !important; right:0 !important;">
                            <input id="paramHref" type="text" style="display: none;"/>
                            <input id="paramIdFile" type="text" style="display: none;"/>
                            <a class="dropdown-item" href="#" onclick="detailInfo()" data-bs-toggle="modal" data-bs-target="#app-file-manager-info-sidebar">
                                <i data-feather="info" class="align-middle me-50"></i>
                                <span class="align-middle">Detail Info</span>
                            </a>
                            <a class="dropdown-item" href="#" onclick="copyLink(event)">
                                <i data-feather="copy" class="align-middle me-50"></i>
                                <span class="align-middle">Share / Copy Link</span>
                            </a>

                            @if(in_array('update', $permission))
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" onclick="revision()" data-bs-toggle="modal" data-bs-target="#app-file-manager-info-revision">
                                <i data-feather="edit" class="align-middle me-50"></i>
                                <span class="align-middle">Revision File</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            {{-- <a class="dropdown-item" href="#" onclick="removeData()">
                                <i data-feather="trash" class="align-middle me-50"></i>
                                <span class="align-middle">Delete</span>
                            </a> --}}
                            @endif
                        </div>
                        <!-- /File Dropdown Ends -->

                        <!-- Create New Folder Modal Starts-->
                        @include('library.library-revision')
                        <!-- /Create New Folder Modal Ends -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

@endsection

@push('page-js')
<script>
    var path = `{{ url('library') }}`;
    var sugesTags = `<?php echo json_encode($sugesTags); ?>`;
</script>
<script src="{{ asset('app-assets/tags-input/js/jquery.amsify.suggestags.js') }}"></script>
<script>
    $(document).ready(function() {
        $('input[name="tags_relation"]').amsifySuggestags({
            type : 'amsify',
            suggestions: JSON.parse(sugesTags)
        });
    });
</script>

<script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>

<script src="{{ asset('js/pages/helpers.js?v='.date('ymdhis')) }}"></script>
<script src="{{ asset('app-assets/vendors/js/extensions/jstree.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/file-uploaders/dropzone.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/form-file-uploader.js?v='.date('ymdhis')) }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>

<script src="{{ asset('js/pages/library.js?v='.date('ymdhis')) }}"></script>
@endpush
