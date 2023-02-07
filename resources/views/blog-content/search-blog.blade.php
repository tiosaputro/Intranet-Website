@extends('layout_web.template')
@section('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/page-knowledge-base.css') }}">
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <style>
        .relative {
            padding: 15px 15px !important;
        }
    </style>
@endsection
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            {{-- <h2 class="content-header-title float-start mb-0">INFO EMP</h2> --}}
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Search Info & News EMP
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                    <div class="mb-1 breadcrumb-right">
                        <div class="dropdown">
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Knowledge base Jumbotron -->
                <section id="knowledge-base-search">
                    <div class="row">
                        <div class="col-12">

                            <div class="card knowledge-base-bg text-center"
                                style="background-image: url('{{ asset($bannerInfoNews) }}'); padding: 1rem !important;">
                                <div class="card-body">
                                    <h2 class="fn-color-nav">Info & News EMP</h2>
                                    <form class="kb-search-input" action="{{ url('content/search') }}" method="GET">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i data-feather="search"></i></span>
                                            <input type="text" name="q" class="form-control" id="autocomplete"
                                                placeholder="Tentang info EMP" value="{{ $keyword }}" />
                                        </div>
                                    </form>
                                    {!! $result->total() > 0
                                        ? "<h4 class='text-white mt-2'><i data-feather='check-circle'></i> " .
                                            $result->total() .
                                            ' Pencarian Ditemukan ! </h4>'
                                        : "<h5 class='text-danger mt-2'><i data-feather='check-circle'></i> Coba gunakan <i>keyword</i> lain !</h5>" !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Knowledge base Jumbotron -->
                <!-- Knowledge base -->
                <section id="knowledge-base-content">
                    <div class="row kb-search-content-info match-height">
                        <!-- sales card -->
                        @if (count($result) > 0)
                            <div class="col-md-12 col-sm-12 col-12 kb-search-content">
                                <div class="d-flex justify-content-right">
                                    <!-- Create Pagination -->
                                    <b>Page : &nbsp; </b> {{ $result->appends(['q' => $keyword])->links() }}
                                </div>
                            </div>
                            @foreach ($result as $row)
                                <div class="col-md-4 col-sm-6 col-12 kb-search-content mt-4">
                                    <div class="card">
                                        <a href="{{ url('content/detail/' . $row->category . '/' . $row->id) }}">
                                            <img src="{{ asset($row->banner_path) }}" class="card-img-top" width="250"
                                                height="220" alt="knowledge-base-image" style="object-fit:contain;" />

                                            <div class="card-body text-center">
                                                <h4>{{ $row->title }}</h4>
                                                <p class="text-body mt-1 mb-0 text-truncate">
                                                    @if (is_array(json_decode($row->meta_tags, 1)))
                                                        @foreach (json_decode($row->meta_tags, 1) as $tg)
                                                            <a
                                                                href="{{ url('content/detail/' . $row->category . '/' . $row->id) }}">
                                                                <span
                                                                    class="badge rounded-pill badge-light-danger me-50">{{ '#' . $tg }}</span>
                                                            </a>
                                                        @endforeach
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="float-right p-1">
                                                <strong>{{ $row->creator->name . ' | ' . customTanggal($row->created_at, 'd M Y h:i') }}</strong>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-md-12 col-sm-12 col-12 bg-white p-2">
                                <div class="d-flex justify-content-center">
                                    <!-- Create Pagination -->
                                    <b>Page : &nbsp; </b>{{ $result->appends(['q' => $keyword])->links() }}
                                </div>
                            </div>
                        @endif

                        @if (count($result) < 1)
                            <!-- no result -->
                            <div class="col-12 text-center no-result no-items">
                                <h4 class="mt-4">Search result not found!!</h4>
                            </div>
                        @endif
                    </div>
                </section>
                <!-- Knowledge base ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
@push('page-js')
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
        var tags = JSON.parse(`<?php echo json_encode($tagging); ?>`);
        $(function() {
            $("#autocomplete").autocomplete({
                source: tags,
                minLength: 2,
                delay: 500,
                select: showResult,
                //   focus : showResult,
                change: showResult
            });

            function showResult(event, ui) {
                if (ui.item.label != '') {
                    var q = ui.item.label;
                    window.location.href = '/content/search?q=' + q
                }
            }
        });
    </script>
@endpush
