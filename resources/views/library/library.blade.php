@extends('layout_web.template')
<!-- BEGIN: Content-->
@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper" style="margin-top:-2%;">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <h3 class="mt-2">Library</h3>
            <p>Pencarian file : Form, Policy & Procedure, References.</p>
            <!-- Permission Table -->
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="datatables-permissions table">
                        <thead class="table-light">
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>SOP Number</th>
                                <th>Rev.No</th>
                                <th>Issued</th>
                                <th>Business Unit</th>
                                <th>Shared Function</th>
                                <th>File</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!--/ Permission Table -->
        </div>
    </div>
</div>
<!-- END: Content-->
@endsection
@push('page-js')
<script>
var route = `{{ url($route) }}`;
</script>
<script src="{{ asset('js/pages/library.js') }}"></script>
@endpush

