@extends('layouts.template')
<!-- BEGIN: Content-->
@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper" style="margin-top:-2%;">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <router-view></router-view>

        </div>
    </div>
</div>
<!-- END: Content-->
@endsection

